<?php

class OrderModel extends BaseModel
{
    protected $table = "orders";

    /**
     * Lấy danh sách tất cả đơn hàng của một người dùng
     */
    public function getOrdersByUser($userId = null, string $userEmail = ''): array
    {
        if (!$this->pdo) return [];

        $conditions = [];
        $params = [];

        if (!empty($userId)) {
            $conditions[] = "o.user_id = :uid";
            $params[':uid'] = (int)$userId;
        }

        $cleanEmail = trim($userEmail);
        if (!empty($cleanEmail)) {
            $conditions[] = "LOWER(o.email) = :email";
            $params[':email'] = strtolower($cleanEmail);
        }

        if (empty($conditions)) {
            return [];
        }

        $whereSql = implode(' OR ', $conditions);

        try {
            $sql = "SELECT o.*, o.order_date as formatted_order_date
                    FROM orders o
                    WHERE {$whereSql}
                    ORDER BY o.id DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $orders = $stmt->fetchAll();

            if (empty($orders)) {
                return [];
            }

            // Lấy danh sách sản phẩm cho từng đơn hàng
            $orderIds = array_column($orders, 'id');
            $placeholders = implode(',', array_fill(0, count($orderIds), '?'));

            $itemSql = "SELECT od.*, p.product_name, p.image as product_image
                        FROM order_details od
                        LEFT JOIN products p ON od.product_id = p.id
                        WHERE od.order_id IN ({$placeholders})
                        ORDER BY od.id ASC";

            $itemStmt = $this->pdo->prepare($itemSql);
            $itemStmt->execute($orderIds);
            $allItems = $itemStmt->fetchAll();

            // Nhóm items theo order_id
            $itemsByOrder = [];
            foreach ($allItems as $item) {
                $itemsByOrder[$item['order_id']][] = $item;
            }

            foreach ($orders as &$order) {
                $order['items'] = $itemsByOrder[$order['id']] ?? [];
                $order['items_count'] = count($order['items']);
                $order['total_quantity'] = array_sum(array_column($order['items'], 'quantity'));
            }
            unset($order);

            return $orders;
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Lấy thông tin chi tiết một đơn hàng
     */
    public function getOrderDetail($orderId, $userId = null, string $userEmail = '')
    {
        if (!$this->pdo || empty($orderId)) return null;

        try {
            $sql = "SELECT * FROM orders WHERE id = :id";
            $params = [':id' => (int)$orderId];

            // Nếu truyền user_id/email, kiểm tra quyền xem đơn hàng
            $conditions = [];
            if (!empty($userId)) {
                $conditions[] = "user_id = :uid";
                $params[':uid'] = (int)$userId;
            }
            $cleanEmail = trim($userEmail);
            if (!empty($cleanEmail)) {
                $conditions[] = "LOWER(email) = :email";
                $params[':email'] = strtolower($cleanEmail);
            }

            if (!empty($conditions)) {
                $sql .= " AND (" . implode(' OR ', $conditions) . ")";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $order = $stmt->fetch();

            if (!$order) {
                return null;
            }

            // Lấy danh sách sản phẩm trong đơn
            $itemSql = "SELECT od.*, p.product_name, p.image as product_image, p.price as original_p_price
                        FROM order_details od
                        LEFT JOIN products p ON od.product_id = p.id
                        WHERE od.order_id = :oid
                        ORDER BY od.id ASC";

            $itemStmt = $this->pdo->prepare($itemSql);
            $itemStmt->execute([':oid' => (int)$orderId]);
            $order['items'] = $itemStmt->fetchAll();

            return $order;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * Hủy đơn hàng (chỉ khi đơn hàng đang ở trạng thái 'Đang xử lý' hoặc 'Chờ xử lý')
     */
    public function cancelOrder($orderId, $userId = null, string $userEmail = ''): array
    {
        if (!$this->pdo || empty($orderId)) {
            return ['success' => false, 'message' => 'Mã đơn hàng không hợp lệ.'];
        }

        $order = $this->getOrderDetail($orderId, $userId, $userEmail);
        if (!$order) {
            return ['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền thao tác.'];
        }

        $cancellableStatuses = ['Đang xử lý', 'Chờ xử lý', 'pending', 'processing'];
        $currentStatus = trim($order['status'] ?? '');

        if (!in_array(mb_strtolower($currentStatus, 'UTF-8'), array_map('mb_strtolower', $cancellableStatuses), true)) {
            return [
                'success' => false, 
                'message' => "Đơn hàng đang ở trạng thái '{$currentStatus}' nên không thể tự hủy. Vui lòng liên hệ hotline Bunny Wear!"
            ];
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET status = 'Đã hủy' WHERE id = :id");
            $stmt->execute([':id' => (int)$orderId]);
            return ['success' => true, 'message' => 'Đã hủy đơn hàng thành công!'];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi khi cập nhật trạng thái đơn hàng.'];
        }
    }
}

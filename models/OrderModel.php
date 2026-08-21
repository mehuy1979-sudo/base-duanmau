<?php

class OrderModel extends BaseModel
{
    protected $table = "orders";

    // ==========================================
    // CÁC PHƯƠNG THỨC DÀNH CHO KHÁCH HÀNG (FRONTEND)
    // ==========================================

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
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            $allItems = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

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
     * Lấy thông tin chi tiết một đơn hàng (Frontend)
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
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

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
            $order['items'] = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

            return $order;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * Hủy đơn hàng phía khách hàng
     */
    public function cancelOrderUser($orderId, $userId = null, string $userEmail = ''): array
    {
        if (!$this->pdo || empty($orderId)) {
            return ['success' => false, 'message' => 'Mã đơn hàng không hợp lệ.'];
        }

        $order = $this->getOrderDetail($orderId, $userId, $userEmail);
        if (!$order) {
            return ['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền thao tác.'];
        }

        $cancellableStatuses = ['Đang xử lý', 'Chờ xử lý', 'pending', 'processing', '1'];
        $currentStatus = trim($order['status'] ?? ($order['order_status'] ?? ''));

        if (!in_array(mb_strtolower($currentStatus, 'UTF-8'), array_map('mb_strtolower', $cancellableStatuses), true)) {
            return [
                'success' => false, 
                'message' => "Đơn hàng đang ở trạng thái '{$currentStatus}' nên không thể tự hủy. Vui lòng liên hệ hotline Bunny Wear!"
            ];
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET status = 'Đã hủy', order_status = 7 WHERE id = :id");
            $stmt->execute([':id' => (int)$orderId]);
            return ['success' => true, 'message' => 'Đã hủy đơn hàng thành công!'];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi khi cập nhật trạng thái đơn hàng.'];
        }
    }

    // ==========================================
    // CÁC PHƯƠNG THỨC DÀNH CHO ADMIN (BACKEND)
    // ==========================================

    // Lấy danh sách đơn hàng
    public function getAllOrders() 
    {
        if (!$this->pdo) return [];
        $sql = "SELECT * FROM orders ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin 1 đơn hàng theo ID
    public function getOrderById($order_id) 
    {
        if (!$this->pdo) return null;
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết các sản phẩm trong đơn hàng (Kèm thông tin ảnh từ bảng products)
    public function getOrderDetails($order_id) 
    {
        if (!$this->pdo) return [];
        $sql = "SELECT 
                    od.*, 
                    p.product_name, 
                    p.image 
                FROM order_details od
                LEFT JOIN products p ON od.product_id = p.id
                WHERE od.order_id = :order_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status_code) 
    {
        if (!$this->pdo) return false;
        $statusLabels = [
            1 => 'Chờ xử lý',
            2 => 'Đã xác nhận',
            3 => 'Đang giao',
            4 => 'Đã giao',
            5 => 'Giao thất bại',
            6 => 'Hoàn thành',
            7 => 'Đã hủy'
        ];
        $statusText = $statusLabels[$status_code] ?? 'Đang xử lý';

        $sql = "UPDATE orders SET order_status = :status, status = :status_text WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status'      => $status_code, 
            'status_text' => $statusText,
            'id'          => $order_id
        ]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus($order_id, $payment_status) 
    {
        if (!$this->pdo) return false;
        $sql = "UPDATE orders SET payment_status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $payment_status, 'id' => $order_id]);
    }

    // Hủy đơn hàng (Admin hoặc User)
    public function cancelOrder($order_id, $reasonOrUserId = '', $userEmail = '') 
    {
        if (is_int($reasonOrUserId) || (is_numeric($reasonOrUserId) && (int)$reasonOrUserId > 0 && !empty($userEmail))) {
            return $this->cancelOrderUser($order_id, (int)$reasonOrUserId, (string)$userEmail);
        }

        if (!$this->pdo) return false;
        $sql = "UPDATE orders SET order_status = 7, status = 'Đã hủy', cancel_reason = :reason WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['reason' => (string)$reasonOrUserId, 'id' => $order_id]);
    }
}

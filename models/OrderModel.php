<?php

class OrderModel extends BaseModel 
{
    protected $table = "orders";

    // Lấy danh sách đơn hàng
    public function getAllOrders() 
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin 1 đơn hàng theo ID
    public function getOrderById($order_id) 
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy lịch sử mua hàng của 1 khách hàng (kèm tổng số sản phẩm mỗi đơn)
    public function getOrdersByUserId($user_id) 
    {
        $sql = "SELECT 
                    o.*,
                    COALESCE(SUM(od.quantity), 0) AS items_count
                FROM orders o
                LEFT JOIN order_details od ON od.order_id = o.id
                WHERE o.user_id = :user_id
                GROUP BY o.id
                ORDER BY o.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết các sản phẩm trong đơn hàng (Kèm thông tin ảnh từ bảng products)
    public function getOrderDetails($order_id) 
    {
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
        $sql = "UPDATE orders SET order_status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $status_code, 'id' => $order_id]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus($order_id, $payment_status) 
    {
        $sql = "UPDATE orders SET payment_status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $payment_status, 'id' => $order_id]);
    }

    // Hủy đơn hàng
    public function cancelOrder($order_id, $reason) 
    {
        $sql = "UPDATE orders SET order_status = 7, cancel_reason = :reason, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['reason' => $reason, 'id' => $order_id]);
    }
}
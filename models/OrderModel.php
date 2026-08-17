<?php
class OrderModel extends BaseModel {
    
    // Lấy thông tin đơn hàng theo ID để kiểm tra trạng thái hiện tại
    public function getOrderById($order_id) {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng (Order Status)
    public function updateOrderStatus($order_id, $status_code) {
        $sql = "UPDATE orders SET order_status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['status' => $status_code, 'id' => $order_id]);
    }

    // Cập nhật trạng thái thanh toán (Payment Status) - Logic #2
    public function updatePaymentStatus($order_id, $payment_status) {
        $sql = "UPDATE orders SET payment_status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['status' => $payment_status, 'id' => $order_id]);
    }

    // Xử lý riêng cho trạng thái Hủy đơn (yêu cầu phải có lý do)
    public function cancelOrder($order_id, $reason) {
        $sql = "UPDATE orders SET order_status = 7, cancel_reason = :reason, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['reason' => $reason, 'id' => $order_id]);
    }
}
?>
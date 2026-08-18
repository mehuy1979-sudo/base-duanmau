<?php

class AdminOrderController 
{
    // Hiển thị danh sách đơn hàng
    public function list() 
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders(); 
        
        require_once PATH_VIEW . 'order/list.php';
    }

    // Hiển thị chi tiết 1 đơn hàng
    public function detail() 
    {
        $id = $_GET['id'] ?? 0;
        $orderModel = new OrderModel();
        
        $order = $orderModel->getOrderById($id);
        $orderDetails = $orderModel->getOrderDetails($id); 

        if (!$order) {
            die("Không tìm thấy đơn hàng!");
        }

        require_once PATH_VIEW . 'order/detail.php';
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus() 
    {
        $order_id = $_POST['order_id'] ?? 0;
        $new_status = (int)($_POST['new_status'] ?? 0);
        $cancel_reason = trim($_POST['cancel_reason'] ?? '');

        $orderModel = new OrderModel();
        $current_order = $orderModel->getOrderById($order_id);
        
        if (!$current_order) {
            die("Đơn hàng không tồn tại!");
        }

        $current_status = (int)$current_order['order_status'];
        $is_valid_transition = false;

        // BƯỚC 1: KIỂM TRA LOGIC CHUYỂN TRẠNG THÁI
        switch ($current_status) {
            case 1: // CHỜ XÁC NHẬN
                if ($new_status === 2 || $new_status === 7) $is_valid_transition = true;
                break;
                
            case 2: // ĐÃ XÁC NHẬN
                if ($new_status === 3) $is_valid_transition = true;
                break;
                
            case 3: // ĐANG GIAO
                if ($new_status === 4 || $new_status === 5) $is_valid_transition = true;
                break;
                
            case 4: // GIAO HÀNG THÀNH CÔNG
                if ($new_status === 6) $is_valid_transition = true;
                break;
        }

        if (!$is_valid_transition) {
            echo "Lỗi: Không được phép chuyển đổi trạng thái này!";
            return;
        }

        // BƯỚC 2: THỰC THI CẬP NHẬT
        if ($new_status === 7) {
            if (empty($cancel_reason)) {
                echo "Lỗi: Bắt buộc phải nhập lý do khi hủy đơn hàng!";
                return;
            }
            $orderModel->cancelOrder($order_id, $cancel_reason);
        } else {
            $orderModel->updateOrderStatus($order_id, $new_status);
        }

        // BƯỚC 3: CẬP NHẬT THANH TOÁN
        if ($new_status === 4) {
            $orderModel->updatePaymentStatus($order_id, 1);
        }

        // Điều hướng lại đúng tham số route
        header("Location: ?action=order_detail&id=" . $order_id);
        exit;
    }
}
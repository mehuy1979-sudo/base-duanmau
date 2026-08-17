<?php
class AdminOrderController {
    
    public function updateStatus() {
        // Giả sử dữ liệu được gửi lên từ Form (POST)
        $order_id = $_POST['order_id'];
        $new_status = (int)$_POST['new_status'];
        $cancel_reason = trim($_POST['cancel_reason'] ?? '');

        $orderModel = new OrderModel();
        $current_order = $orderModel->getOrderById($order_id);
        
        if (!$current_order) {
            die("Đơn hàng không tồn tại!");
        }

        $current_status = (int)$current_order['order_status'];
        $is_valid_transition = false;

        // BƯỚC 1: KIỂM TRA LOGIC CHUYỂN TRẠNG THÁI (Dựa theo flowchart #1)
        switch ($current_status) {
            case 1: // CHỜ XÁC NHẬN
                // Chỉ được chuyển sang Đã xác nhận (2) hoặc Hủy (7)
                if ($new_status === 2 || $new_status === 7) $is_valid_transition = true;
                break;
                
            case 2: // ĐÃ XÁC NHẬN
                // Chỉ được chuyển sang Đang giao (3)
                if ($new_status === 3) $is_valid_transition = true;
                break;
                
            case 3: // ĐANG GIAO
                // Chỉ được báo Thành công (4) hoặc Thất bại (5)
                if ($new_status === 4 || $new_status === 5) $is_valid_transition = true;
                break;
                
            case 4: // GIAO HÀNG THÀNH CÔNG
                // Chuyển sang Hoàn thành (6) (Thường khách hàng bấm hoặc hệ thống tự chạy cronjob sau 3 ngày)
                if ($new_status === 6) $is_valid_transition = true;
                break;
                
            // Trạng thái 5 (Thất bại), 6 (Hoàn thành), 7 (Đã hủy) là các trạng thái cuối, 
            // Admin không được phép tự đổi sang trạng thái khác nữa.
        }

        if (!$is_valid_transition) {
            // Trả về thông báo lỗi hoặc redirect lại kèm báo lỗi
            echo "Lỗi: Không được phép chuyển đổi trạng thái này!";
            return;
        }

        // BƯỚC 2: THỰC THI CẬP NHẬT
        if ($new_status === 7) {
            // Xử lý trường hợp "ĐÃ HỦY" - Bắt buộc kiểm tra lý do
            if (empty($cancel_reason)) {
                echo "Lỗi: Bắt buộc phải nhập lý do khi hủy đơn hàng!";
                return;
            }
            $orderModel->cancelOrder($order_id, $cancel_reason);
        } else {
            // Các trạng thái bình thường
            $orderModel->updateOrderStatus($order_id, $new_status);
        }

        // BƯỚC 3: LOGIC CẬP NHẬT THANH TOÁN (Dựa theo flowchart #2)
        // Lưu ý: "Đổi sang trạng thái đơn hàng thành Giao Hàng Thành Công -> Đã thanh toán"
        if ($new_status === 4) {
            $orderModel->updatePaymentStatus($order_id, 1); // 1 = Đã thanh toán
        }

        // Thành công: Điều hướng (Redirect) trở lại trang chi tiết đơn hàng
        header("Location: ?role=admin&act=order_detail&id=" . $order_id);
        exit;
    }
}
<?php
class AdminOrderController {
    
    // Hiển thị danh sách đơn hàng
    public function list() {
        $orderModel = new OrderModel();
        // Lấy toàn bộ đơn hàng (Bạn cần đảm bảo OrderModel có hàm getAllOrders)
        $orders = $orderModel->getAllOrders(); 
        
        // Gọi file View và truyền biến $orders sang
        require_once 'views/order/list.php';
    }

    // Hiển thị chi tiết 1 đơn hàng
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $orderModel = new OrderModel();
        
        $order = $orderModel->getOrderById($id);
        // Lấy danh sách sản phẩm trong đơn (Bạn cần đảm bảo OrderModel có hàm getOrderDetails)
        $orderDetails = $orderModel->getOrderDetails($id); 

        if (!$order) {
            die("Không tìm thấy đơn hàng!");
        }

        // Gọi file View và truyền biến $order, $orderDetails sang
        require_once 'views/order/detail.php';
    }

    // ... (Giữ nguyên hàm updateStatus() đã viết ở phần trước) ...
}
?>
?>
<?php

class AdminOrderController
{
    private OrderModel $orderModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Chỉ cho phép admin truy cập
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '?action=/login');
            exit;
        }

        $this->orderModel = new OrderModel();
    }

    // Hiển thị danh sách đơn hàng
    public function list()
    {
        $keyword = trim($_GET['q'] ?? '');
        $statusFilter = $_GET['status'] ?? '';

        $allOrders = $this->orderModel->getAllOrders();

        // Lọc theo từ khóa và trạng thái nếu có
        $orders = array_filter($allOrders, function ($order) use ($keyword, $statusFilter) {
            $matchKey = true;
            if ($keyword !== '') {
                $searchable = ($order['id'] ?? '') . ' ' .
                              ($order['customer_name'] ?? '') . ' ' .
                              ($order['email'] ?? '') . ' ' .
                              ($order['phone'] ?? '') . ' ' .
                              ($order['address'] ?? '');
                $matchKey = mb_stripos($searchable, $keyword) !== false;
            }

            $matchStatus = true;
            if ($statusFilter !== '') {
                $matchStatus = ((int)($order['order_status'] ?? 0) === (int)$statusFilter);
            }

            return $matchKey && $matchStatus;
        });

        // Thống kê số lượng đơn hàng theo trạng thái
        $stats = [
            'total'     => count($allOrders),
            'pending'   => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 1) === 1)),
            'confirmed' => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 0) === 2)),
            'shipping'  => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 0) === 3)),
            'delivered' => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 0) === 4)),
            'completed' => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 0) === 6)),
            'cancelled' => count(array_filter($allOrders, fn($o) => (int)($o['order_status'] ?? 0) === 7)),
        ];

        $pageTitle  = 'Quản lý đơn hàng';
        $activeMenu = 'orders';

        $flashSuccess = $_SESSION['admin_order_success'] ?? null;
        $flashError   = $_SESSION['admin_order_error'] ?? null;
        unset($_SESSION['admin_order_success'], $_SESSION['admin_order_error']);

        require_once __DIR__ . '/../views/order/list.php';
    }

    // Hiển thị chi tiết 1 đơn hàng
    public function detail()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header("Location: index.php?action=orders");
            exit;
        }

        $order = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);

        if (!$order) {
            $_SESSION['admin_order_error'] = 'Không tìm thấy đơn hàng #' . $id;
            header("Location: index.php?action=orders");
            exit;
        }

        $pageTitle  = 'Chi tiết đơn hàng #' . $id;
        $activeMenu = 'orders';

        $flashSuccess = $_SESSION['admin_order_success'] ?? null;
        $flashError   = $_SESSION['admin_order_error'] ?? null;
        unset($_SESSION['admin_order_success'], $_SESSION['admin_order_error']);

        require_once __DIR__ . '/../views/order/detail.php';
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=orders");
            exit;
        }

        $order_id = (int)($_POST['order_id'] ?? 0);
        $new_status = (int)($_POST['new_status'] ?? 0);
        $cancel_reason = trim($_POST['cancel_reason'] ?? '');

        $current_order = $this->orderModel->getOrderById($order_id);

        if (!$current_order) {
            $_SESSION['admin_order_error'] = "Đơn hàng không tồn tại!";
            header("Location: index.php?action=orders");
            exit;
        }

        $current_status = (int)($current_order['order_status'] ?? 1);
        $is_valid_transition = false;

        // KIỂM TRA LOGIC CHUYỂN TRẠNG THÁI
        switch ($current_status) {
            case 1: // CHỜ XÁC NHẬN
                if (in_array($new_status, [2, 3, 7], true)) $is_valid_transition = true;
                break;

            case 2: // ĐÃ XÁC NHẬN
                if (in_array($new_status, [3, 7], true)) $is_valid_transition = true;
                break;

            case 3: // ĐANG GIAO
                if (in_array($new_status, [4, 5, 6, 7], true)) $is_valid_transition = true;
                break;

            case 4: // ĐÃ GIAO HÀNG
                if (in_array($new_status, [6], true)) $is_valid_transition = true;
                break;
                
            case 5: // GIAO THẤT BẠI
                if (in_array($new_status, [3, 7], true)) $is_valid_transition = true;
                break;
        }

        if (!$is_valid_transition) {
            $_SESSION['admin_order_error'] = "Không được phép chuyển đổi trực tiếp trạng thái này!";
            header("Location: index.php?action=order_detail&id=" . $order_id);
            exit;
        }

        // THỰC THI CẬP NHẬT
        if ($new_status === 7) {
            if (empty($cancel_reason)) {
                $_SESSION['admin_order_error'] = "Bắt buộc phải nhập lý do khi hủy đơn hàng!";
                header("Location: index.php?action=order_detail&id=" . $order_id);
                exit;
            }
            $this->orderModel->cancelOrder($order_id, $cancel_reason);
            $_SESSION['admin_order_success'] = "Đã hủy đơn hàng #{$order_id} thành công.";
        } else {
            $this->orderModel->updateOrderStatus($order_id, $new_status);
            $_SESSION['admin_order_success'] = "Đã cập nhật trạng thái đơn hàng #{$order_id} thành công!";
        }

        // CẬP NHẬT THANH TOÁN (Tự động chuyển sang Đã thanh toán khi Giao thành công hoặc Hoàn thành)
        if ($new_status === 4 || $new_status === 6) {
            $this->orderModel->updatePaymentStatus($order_id, 1);
        }

        header("Location: index.php?action=order_detail&id=" . $order_id);
        exit;
    }
}

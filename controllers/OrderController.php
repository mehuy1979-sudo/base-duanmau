<?php

class OrderController
{
    private OrderModel $orderModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->orderModel = new OrderModel();
    }

    /**
     * Danh sách lịch sử mua hàng
     */
    public function index()
    {
        $currentUser = $_SESSION['user'] ?? null;
        $userId      = $currentUser['id'] ?? ($_SESSION['user_id'] ?? null);
        $userEmail   = $currentUser['email'] ?? '';

        if (!$currentUser && empty($userId)) {
            $_SESSION['login_error'] = 'Vui lòng đăng nhập để xem lịch sử mua hàng của bạn.';
            header('Location: ' . BASE_URL . '?action=/login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUser($userId, $userEmail);
        $title  = "Lịch sử mua hàng - Bunny Wear";

        $flashSuccess = $_SESSION['order_success_msg'] ?? null;
        $flashError   = $_SESSION['order_error_msg'] ?? null;
        unset($_SESSION['order_success_msg'], $_SESSION['order_error_msg']);

        require_once PATH_VIEW . 'order-history.php';
    }

    /**
     * Chi tiết một đơn hàng cụ thể
     */
    public function detail()
    {
        $currentUser = $_SESSION['user'] ?? null;
        $userId      = $currentUser['id'] ?? ($_SESSION['user_id'] ?? null);
        $userEmail   = $currentUser['email'] ?? '';

        if (!$currentUser && empty($userId)) {
            $_SESSION['login_error'] = 'Vui lòng đăng nhập để xem chi tiết đơn hàng.';
            header('Location: ' . BASE_URL . '?action=/login');
            exit;
        }

        $orderId = intval($_GET['id'] ?? 0);
        if ($orderId <= 0) {
            header('Location: ' . BASE_URL . '?action=/order-history');
            exit;
        }

        $order = $this->orderModel->getOrderDetail($orderId, $userId, $userEmail);
        if (!$order) {
            $_SESSION['order_error_msg'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này.';
            header('Location: ' . BASE_URL . '?action=/order-history');
            exit;
        }

        $title = "Chi tiết đơn hàng #DH" . str_pad($orderId, 5, '0', STR_PAD_LEFT) . " - Bunny Wear";

        $flashSuccess = $_SESSION['order_success_msg'] ?? null;
        $flashError   = $_SESSION['order_error_msg'] ?? null;
        unset($_SESSION['order_success_msg'], $_SESSION['order_error_msg']);

        require_once PATH_VIEW . 'order-detail.php';
    }

    /**
     * Hủy đơn hàng đang chờ xử lý
     */
    public function cancel()
    {
        $currentUser = $_SESSION['user'] ?? null;
        $userId      = $currentUser['id'] ?? ($_SESSION['user_id'] ?? null);
        $userEmail   = $currentUser['email'] ?? '';

        if (!$currentUser && empty($userId)) {
            if (isset($_GET['ajax'])) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
                exit;
            }
            header('Location: ' . BASE_URL . '?action=/login');
            exit;
        }

        $orderId = intval($_POST['order_id'] ?? ($_GET['id'] ?? 0));
        $res = $this->orderModel->cancelOrder($orderId, $userId, $userEmail);

        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($res);
            exit;
        }

        if ($res['success']) {
            $_SESSION['order_success_msg'] = $res['message'];
        } else {
            $_SESSION['order_error_msg'] = $res['message'];
        }

        $redirect = $_SERVER['HTTP_REFERER'] ?? (BASE_URL . '?action=/order-history');
        header('Location: ' . $redirect);
        exit;
    }
}

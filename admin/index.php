<?php

session_start();

require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/helper.php';
require_once __DIR__ . '/../configs/database.php';

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

require_once __DIR__ . '/controllers/AccountController.php';
require_once __DIR__ . '/controllers/PageController.php';
require_once __DIR__ . '/controllers/AdminOrderController.php';

// Chỉ cho phép tài khoản có quyền "admin" và đã đăng nhập truy cập trang quản trị
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '?action=/login');
    exit;
}

$action = $_GET['action'] ?? 'dashboard';

match ($action) {
    'dashboard' => (new PageController)->dashboard(),
    'stats'     => (new PageController)->stats(),
    'settings'  => (new PageController)->settings(),

    'account/list'        => (new AccountController)->index(),
    'account/detail'      => (new AccountController)->detail(),
    'account/toggle-lock' => (new AccountController)->toggleLock(),
    'account/change-role' => (new AccountController)->changeRole(),

    // Quản lý đơn hàng (ghép từ base nguyenanhhuy)
    'orders'              => (new AdminOrderController)->list(),
    'order_detail'        => (new AdminOrderController)->detail(),
    'update_order_status' => (new AdminOrderController)->updateStatus(),

    default => (new PageController)->dashboard(),
};

// Lưu ý: "Quản lý sản phẩm" (AdminProductController, ghép từ base CongChese) chạy qua
// router công khai ở gốc site: ?action=/admin/products (xem routes/index.php),
// vì view products.php gọi AJAX theo đường dẫn đó. Trang này tự kiểm tra quyền admin riêng.

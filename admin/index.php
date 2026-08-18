<?php

session_start();

require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/helper.php';
require_once __DIR__ . '/../configs/database.php';

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/AccountModel.php';

require_once __DIR__ . '/controllers/AccountController.php';
require_once __DIR__ . '/controllers/PageController.php';

// Chỉ cho phép tài khoản có quyền "admin" và đã đăng nhập truy cập trang quản trị
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '?action=/login');
    exit;
}



$action = $_GET['action'] ?? 'account/list';

match ($action) {
    'account/list'        => (new AccountController)->index(),
    'account/detail'      => (new AccountController)->detail(),
    'account/toggle-lock' => (new AccountController)->toggleLock(),
    'account/change-role' => (new AccountController)->changeRole(),

    default => (new AccountController)->index(),
};

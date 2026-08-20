<?php

if (!defined('PATH_ROOT')) {
    define('PATH_ROOT', __DIR__ . '/../');
}

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = rtrim($scriptDir, '/') . '/';
if (!defined('BASE_URL')) {
    define('BASE_URL', $baseUrl);
}

// Cấu hình đường dẫn thư mục
if (!defined('PATH_MODEL')) {
    define('PATH_MODEL', PATH_ROOT . 'models/');
}
if (!defined('PATH_CONTROLLER')) {
    define('PATH_CONTROLLER', PATH_ROOT . 'controllers/');
}
if (!defined('PATH_VIEW')) {
    define('PATH_VIEW', PATH_ROOT . 'views/');
}
if (!defined('PATH_VIEW_MAIN')) {
    define('PATH_VIEW_MAIN', PATH_ROOT . 'views/main.php');
}
if (!defined('BASE_ASSETS_UPLOADS')) {
    define('BASE_ASSETS_UPLOADS', BASE_URL . 'assets/uploads/');
}
if (!defined('PATH_ASSETS_UPLOADS')) {
    define('PATH_ASSETS_UPLOADS', PATH_ROOT . 'assets/uploads/');
}

// Cấu hình Kết nối CSDL
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', '3306');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '123456');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'shop_quanao');
}
if (!defined('DB_OPTIONS')) {
    define('DB_OPTIONS', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

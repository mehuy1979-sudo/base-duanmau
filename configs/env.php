<?php

// Đường dẫn trang web
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/base-duanmau/');
}

// Cấu hình đường dẫn thư mục
if (!defined('PATH_MODEL')) {
    define('PATH_MODEL', __DIR__ . '/../models/');
}
if (!defined('PATH_CONTROLLER')) {
    define('PATH_CONTROLLER', __DIR__ . '/../controllers/');
}
if (!defined('PATH_VIEW')) {
    define('PATH_VIEW', __DIR__ . '/../views/');
}

// Cấu hình Kết nối CSDL (Thay 'ten_database_cua_ban' bằng tên DB thực tế trong Laragon)
if (!defined('DB_HOST')) {
    define('DB_HOST', '127.0.0.1');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', '3306');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'shop_quanao'); 
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}
if (!defined('DB_OPTIONS')) {
    define('DB_OPTIONS', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
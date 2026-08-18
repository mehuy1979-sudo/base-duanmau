<?php 

session_start();

// 1. Nạp các tệp cấu hình và hằng số môi trường trước
require_once './configs/env.php';
require_once __DIR__ . '/configs/database.php';
require_once './configs/helper.php';

// 2. Đăng ký Autoload để tự động nạp Controller và Model khi được gọi
spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel      = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

// 3. Nạp Router để xử lý điều hướng (Được gọi cuối cùng)
require_once './routes/index.php';
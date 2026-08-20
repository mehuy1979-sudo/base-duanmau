<?php 

session_start();

require_once __DIR__ . '/configs/env.php';
require_once __DIR__ . '/configs/helper.php';
if (file_exists(__DIR__ . '/configs/database.php')) {
    require_once __DIR__ . '/configs/database.php';
}

spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel              = PATH_MODEL . $fileName;
    $fileController         = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

// Điều hướng
require_once __DIR__ . '/routes/index.php';

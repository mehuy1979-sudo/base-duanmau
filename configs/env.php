<?php

<<<<<<< HEAD
define('BASE_URL',          'http://localhost/base-duanmau/');
=======
define('BASE_URL',          'http://localhost/base-duanmau-master/');
>>>>>>> origin/hhbach305

define('PATH_ROOT',         __DIR__ . '/../');

define('PATH_VIEW',         PATH_ROOT . 'views/');

define('PATH_VIEW_MAIN',    PATH_ROOT . 'views/main.php');

define('BASE_ASSETS_UPLOADS',   BASE_URL . 'assets/uploads/');

define('PATH_ASSETS_UPLOADS',   PATH_ROOT . 'assets/uploads/');

define('PATH_CONTROLLER',       PATH_ROOT . 'controllers/');

define('PATH_MODEL',            PATH_ROOT . 'models/');

<<<<<<< HEAD
=======

>>>>>>> origin/hhbach305
define('DB_HOST',     'localhost');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
<<<<<<< HEAD
define('DB_NAME',     'shop_quanao');
=======
define('DB_NAME',     '');
>>>>>>> origin/hhbach305
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

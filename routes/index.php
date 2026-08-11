<?php

$action = trim(strtolower($_GET['action'] ?? '/'));

match ($action) {
    '/'               => (new HomeController)->index(),
    'product-detail'  => (new ProductController())->detail(),
    'register' => (new UserController())->register(),
    'login' => (new UserController())->login(),
    default           => (new HomeController)->index(),
};
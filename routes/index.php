<?php

$action = trim(strtolower($_GET['action'] ?? '/'));

match ($action) {
    '/'               => (new HomeController)->index(),
    'product-detail'  => (new ProductController())->detail(),
    default           => (new HomeController)->index(),
};
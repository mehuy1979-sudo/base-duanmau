<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
     '/product'         => (new HomeController)->index(),
    '/product' => (new ProductController)->index(),
     }; 



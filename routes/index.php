
<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'        => (new HomeController)->index(),
    'product' => (new ProductController)->index(),
    
    default     => (new HomeController)->index(),
};

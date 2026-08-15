
<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'        => (new HomeController)->index(),
    'product' => (new ProductController)->index(),
    'search' => (new ProductController)->search(),
    'keyword' => (new ProductController)->searchByKey(),
    default     => (new HomeController)->index(),

};

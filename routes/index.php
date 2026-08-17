
<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'        => (new HomeController)->index(),
    'product' => (new ProductController)->index(),
    'search' => (new ProductController)->search(),
    'keyword' => (new ProductController)->searchByKey(),
    'orders'              => (new AdminOrderController)->list(),
    'order_detail'        => (new AdminOrderController)->detail(),
    'update_order_status' => (new AdminOrderController)->updateStatus(),
    default     => (new HomeController)->index(),

};

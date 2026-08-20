<?php

$action = $_GET['action'] ?? '/';
$ajax   = $_GET['ajax']   ?? '';

// Admin product AJAX sub-routes
if ($action === '/admin/products' && $ajax !== '') {
    $ctrl = new AdminProductController();
    match ($ajax) {
        'store'  => $ctrl->store(),
        'edit'   => $ctrl->edit(),
        'update' => $ctrl->update(),
        'delete' => $ctrl->destroy(),
        default  => http_response_code(404),
    };
    exit;
}

// Wishlist / Danh mục yêu thích AJAX sub-routes
if (($action === '/wishlist' || $action === 'wishlist' || $action === '/favorite-categories' || $action === 'favorite-categories') && $ajax !== '') {
    $ctrl = new WishlistController();
    match ($ajax) {
        'toggle' => $ctrl->toggle(),
        'remove' => $ctrl->remove(),
        'clear'  => $ctrl->clear(),
        'count'  => $ctrl->count(),
        default  => http_response_code(404),
    };
    exit;
}

match ($action) {
    '/'                     => (new HomeController)->index(),
    '/product'              => (new ProductController)->index(),
    'product'               => (new ProductController)->index(),
    '/product-detail'       => (new ProductController)->detail(),
    'product-detail'        => (new ProductController)->detail(),
    '/compare'              => (new ProductController)->compare(),
    'compare'               => (new ProductController)->compare(),
    '/wishlist'             => (new WishlistController)->index(),
    'wishlist'              => (new WishlistController)->index(),
    '/favorite-categories'  => (new WishlistController)->index(),
    'favorite-categories'   => (new WishlistController)->index(),
    '/admin/products'       => (new AdminProductController)->index(),
    'admin/products'        => (new AdminProductController)->index(),
    default                 => (new HomeController)->index(),
};


<?php

$action = $_GET['action'] ?? '/';
$ajax   = $_GET['ajax']   ?? '';

// Admin product AJAX sub-routes
if (($action === '/admin/products' || $action === 'admin/products') && $ajax !== '') {
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
    // Trang chủ
    '/'                     => (new HomeController)->index(),

    // Sản phẩm & Cửa hàng
    '/product', 'product'   => (new ProductController)->index(),
    '/product-detail', 'product-detail' => (new ProductController)->detail(),
    '/compare', 'compare'   => (new ProductController)->compare(),

    // Yêu thích & Danh mục yêu thích
    '/wishlist', 'wishlist' => (new WishlistController)->index(),
    '/favorite-categories', 'favorite-categories' => (new WishlistController)->index(),

    // Giỏ hàng & Thanh toán
    '/cart', 'cart'                 => (new CartController)->index(),
    '/cart/add', 'cart/add'         => (new CartController)->addToCart(),
    '/cart/remove', 'cart/remove'   => (new CartController)->removeFromCart(),
    '/cart/update', 'cart/update'   => (new CartController)->updateCart(),
    '/checkout', 'checkout'         => (new CartController)->checkout(),
    '/place-order', 'place-order'   => (new CartController)->placeOrder(),
    '/order-success', 'order-success' => (new CartController)->orderSuccess(),

    // Xác thực người dùng (Auth)
    '/login', 'login'                       => (new AuthController)->showLogin(),
    '/login/submit', 'login/submit'         => (new AuthController)->login(),
    '/register', 'register'                 => (new AuthController)->showRegister(),
    '/register/submit', 'register/submit'   => (new AuthController)->register(),
    '/logout', 'logout'                     => (new AuthController)->logout(),

    // Lịch sử đơn hàng & Chi tiết đơn
    '/order-history', 'order-history',
    '/my-orders', 'my-orders'               => (new OrderController)->index(),
    '/order-detail', 'order-detail'         => (new OrderController)->detail(),
    '/order-cancel', 'order-cancel'         => (new OrderController)->cancel(),

    // Quản trị sản phẩm
    '/admin/products', 'admin/products'     => (new AdminProductController)->index(),

    default => (new HomeController)->index(),
};

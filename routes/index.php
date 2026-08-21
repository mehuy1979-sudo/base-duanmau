<?php

$action = $_GET['action'] ?? '/';
$ajax   = $_GET['ajax']   ?? '';

// Sub-route AJAX cho quản lý sản phẩm ở admin (thêm/sửa/xóa) — từ base CongChese
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

// Wishlist / Danh mục yêu thích AJAX sub-routes — từ base CongChese
if (($action === '/wishlist' || $action === '/favorite-categories') && $ajax !== '') {
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
    '/'         => (new HomeController)->index(),

    '/product'        => (new ProductController)->index(),
    '/wishlist'       => (new WishlistController)->index(),
    '/product-detail' => (new ProductController)->detail(),
    '/compare'        => (new ProductController)->compare(),

    '/cart'        => (new CartController)->index(),
    '/cart/add'    => (new CartController)->addToCart(),
    '/cart/remove' => (new CartController)->removeFromCart(),
    '/cart/update' => (new CartController)->updateCart(),

    '/checkout'      => (new CartController)->checkout(),
    '/place-order'   => (new CartController)->placeOrder(),
    '/order-success' => (new CartController)->orderSuccess(),

    '/order-history' => (new CartController)->orderHistory(),
    '/order-detail'  => (new CartController)->orderDetail(),

    '/login'         => (new AuthController)->showLogin(),
    '/login/submit'  => (new AuthController)->login(),
    '/register'      => (new AuthController)->showRegister(),
    '/register/submit' => (new AuthController)->register(),
    '/logout'        => (new AuthController)->logout(),

    // Quản lý sản phẩm ở admin (trang chính) — từ base CongChese
    '/admin/products' => (new AdminProductController)->index(),

    default => (new HomeController)->index(),
};

<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                   => (new HomeController)->index(),
    'product'             => (new ProductController)->index(),
    'search'              => (new ProductController)->search(),
    'keyword'             => (new ProductController)->searchByKey(),
    'orders'              => (new AdminOrderController)->list(),
    'order_detail'        => (new AdminOrderController)->detail(),
    'update_order_status' => (new AdminOrderController)->updateStatus(),
    '/cart'               => (new CartController)->index(),
    '/cart/add'           => (new CartController)->addToCart(),
    '/cart/remove'        => (new CartController)->removeFromCart(),
    '/cart/update'        => (new CartController)->updateCart(),
    '/checkout'           => (new CartController)->checkout(),
    '/place-order'        => (new CartController)->placeOrder(),
    '/order-success'      => (new CartController)->orderSuccess(),
    '/login'              => (new AuthController)->showLogin(),
    '/login/submit'       => (new AuthController)->login(),
    '/register'           => (new AuthController)->showRegister(),
    '/register/submit'    => (new AuthController)->register(),
    '/logout'             => (new AuthController)->logout(),
    '/account'       => (new AccountController)->index(),
'/account/edit'  => (new AccountController)->edit(),
'/account/update'=> (new AccountController)->update(),
    default               => (new HomeController)->index(),
};

<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new HomeController)->index(),

    '/product' => (new ProductController)->index(),

    '/cart' => (new CartController)->index(),

    '/cart/add' => (new CartController)->addToCart(),

    '/cart/remove' => (new CartController)->removeFromCart(),

    '/cart/update' => (new CartController)->updateCart(),

    '/checkout' => (new CartController)->checkout(),

    '/order-success' => (new CartController)->orderSuccess(),

    default => (new HomeController)->index(),
    '/checkout' => (new CartController)->checkout(),

'/place-order' => (new CartController)->placeOrder(),

'/order-success' => (new CartController)->orderSuccess(),
};


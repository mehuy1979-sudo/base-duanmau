<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'           => (new HomeController)->index(),
    '/cart'       => (new CartController)->index(),
    '/cart/add'   => (new CartController)->addToCart(),
    '/cart/remove' => (new CartController)->removeFromCart(),
    '/cart/update' => (new CartController)->updateCart(),
};
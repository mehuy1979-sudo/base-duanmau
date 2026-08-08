<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'            => (new HomeController)->index(),
    'cart'         => (new CartController)->index(),
    'add-cart'     => (new CartController)->add(),
    'cart-update'  => (new CartController)->update(),
    'cart-delete', 'delete-cart' => (new CartController)->delete(),
    'cart-clear'   => (new CartController)->clear(),
    default        => (new HomeController)->index(),
};

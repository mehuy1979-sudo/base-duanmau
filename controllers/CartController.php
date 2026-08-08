<?php

class CartController
{
    private function initCart(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [[
            'id' => 1,
            'name' => 'Tiger Hoody',
            'price' => 1600000,
            'quantity' => 1,
            'image' => 'product-01.jpg',
            'size' => 'L',
            'total' => 1600000,
        ]];

        foreach ($cart as $index => $item) {
            $cart[$index]['total'] = (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
        }

        $_SESSION['cart'] = $cart;

        return $cart;
    }

    public function index()
    {
        $cart = $this->initCart();
        $subtotal = array_sum(array_column($cart, 'total'));
        $shipping = 0;
        $total = $subtotal + $shipping;

        require_once PATH_VIEW . 'cart.php';
    }

    public function checkout()
    {
        $cart = $this->initCart();
        $subtotal = array_sum(array_column($cart, 'total'));
        $shipping = 0;
        $total = $subtotal + $shipping;

        require_once PATH_VIEW . 'checkout.php';
    }

    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($product_id) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $_SESSION['cart'][] = [
                'id' => $product_id,
                'quantity' => $quantity,
                'name' => 'Sản phẩm mới',
                'price' => 0,
                'total' => 0,
            ];

            header('Location: ?action=/cart');
            exit;
        }
    }

    public function removeFromCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $product_id = $_GET['id'] ?? null;

        if ($product_id && isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
                return ($item['id'] ?? null) != $product_id;
            });

            header('Location: ?action=/cart');
            exit;
        }
    }

    public function updateCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
            $quantities = $_POST['quantities'] ?? [];

            foreach ($_SESSION['cart'] as &$item) {
                if (isset($quantities[$item['id']])) {
                    $item['quantity'] = max(1, (int) $quantities[$item['id']]);
                    $item['total'] = (float) ($item['price'] ?? 0) * (int) $item['quantity'];
                }
            }

            header('Location: ?action=/cart');
            exit;
        }
    }
}

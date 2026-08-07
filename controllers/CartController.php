<?php

class CartController
{
    public function index() 
    {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy dữ liệu giỏ hàng từ session (mẫu)
        $cart = $_SESSION['cart'] ?? [
            [
                'id' => 1,
                'name' => 'Áo khoác nhẹ',
                'price' => 36.00,
                'quantity' => 2,
                'image' => 'jacket.png',
                'total' => 72.00
            ],
            [
                'id' => 2,
                'name' => 'Dâu tây tươi',
                'price' => 16.00,
                'quantity' => 1,
                'image' => 'strawberry.png',
                'total' => 16.00
            ]
        ];

        $subtotal = array_sum(array_column($cart, 'total'));
        $shipping = 0;
        $total = $subtotal + $shipping;

        require_once PATH_VIEW . 'cart.php';
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

            // Thêm vào giỏ hàng
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'quantity' => $quantity
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
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
                return $item['id'] != $product_id;
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
                    $item['quantity'] = max(1, (int)$quantities[$item['id']]);
                }
            }

            header('Location: ?action=/cart');
            exit;
        }
    }
}

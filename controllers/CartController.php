<?php

class CartController
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];

        require_once PATH_VIEW . 'cart.php';
    }

    public function add()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: ?action=cart');
            exit;
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            // Tạm thời dữ liệu mẫu (sau này lấy từ DB)
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => 'Sản phẩm ' . $id,
                'price' => 100000,
                'quantity' => 1,
                'image' => 'product-' . str_pad((string) (($id - 1) % 5 + 1), 2, '0', STR_PAD_LEFT) . '.jpg',
            ];
        }

        header('Location: ?action=cart');
        exit;
    }

    public function update()
    {
        if (!empty($_POST['quantity']) && is_array($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $id => $qty) {
                $id = (int) $id;
                $qty = (int) $qty;

                if (!isset($_SESSION['cart'][$id])) {
                    continue;
                }

                if ($qty <= 0) {
                    unset($_SESSION['cart'][$id]);
                } else {
                    $_SESSION['cart'][$id]['quantity'] = $qty;
                }
            }
        }

        header('Location: ?action=cart');
        exit;
    }

    public function delete()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            unset($_SESSION['cart'][$id]);
        }

        header('Location: ?action=cart');
        exit;
    }

    public function clear()
    {
        unset($_SESSION['cart']);

        header('Location: ?action=cart');
        exit;
    }
}

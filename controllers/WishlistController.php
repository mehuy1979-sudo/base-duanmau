<?php

class WishlistController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['wishlist']) || !is_array($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = [];
        }
    }

    public function index()
    {
        $title = "Danh Mục Yêu Thích - Bunny Wear";
        $wishlistIds = $_SESSION['wishlist'] ?? [];
        $products = [];
        $categories = [];

        if (!empty($wishlistIds)) {
            $products = $this->productModel->getByIds($wishlistIds);
            
            // Extract unique categories present in favorites
            $catMap = [];
            foreach ($products as $p) {
                $catName = $p['category_name'] ?? 'Khác';
                if (!isset($catMap[$catName])) {
                    $catMap[$catName] = [
                        'name'  => $catName,
                        'slug'  => str_slug($catName),
                        'count' => 0
                    ];
                }
                $catMap[$catName]['count']++;
            }
            $categories = array_values($catMap);
        }

        require_once PATH_VIEW . 'wishlist.php';
    }

    public function toggle()
    {
        header('Content-Type: application/json; charset=utf-8');

        $productId = intval($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
        if ($productId <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Mã sản phẩm không hợp lệ.'
            ]);
            exit;
        }

        $product = $this->productModel->getOne($productId);
        if (!$product) {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại.'
            ]);
            exit;
        }

        $wishlist = $_SESSION['wishlist'] ?? [];
        $key = array_search($productId, $wishlist);

        if ($key !== false) {
            unset($wishlist[$key]);
            $_SESSION['wishlist'] = array_values($wishlist);
            $action = 'removed';
            $message = 'Đã bỏ sản phẩm khỏi Danh Mục Yêu Thích!';
        } else {
            $wishlist[] = $productId;
            $_SESSION['wishlist'] = array_values(array_unique($wishlist));
            $action = 'added';
            $message = 'Đã thêm "' . htmlspecialchars($product['product_name'] ?? 'sản phẩm') . '" vào Danh Mục Yêu Thích!';
        }

        echo json_encode([
            'success' => true,
            'action'  => $action,
            'count'   => count($_SESSION['wishlist']),
            'message' => $message,
            'product' => [
                'id'           => $product['id'],
                'product_name' => $product['product_name'] ?? '',
                'price'        => $product['price'] ?? 0,
                'image'        => $product['image'] ?? ''
            ]
        ]);
        exit;
    }

    public function remove()
    {
        header('Content-Type: application/json; charset=utf-8');

        $productId = intval($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
        if ($productId <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Mã sản phẩm không hợp lệ.'
            ]);
            exit;
        }

        $wishlist = $_SESSION['wishlist'] ?? [];
        $key = array_search($productId, $wishlist);

        if ($key !== false) {
            unset($wishlist[$key]);
            $_SESSION['wishlist'] = array_values($wishlist);
        }

        echo json_encode([
            'success' => true,
            'count'   => count($_SESSION['wishlist']),
            'message' => 'Đã xóa sản phẩm khỏi Danh Mục Yêu Thích!'
        ]);
        exit;
    }

    public function clear()
    {
        header('Content-Type: application/json; charset=utf-8');

        $_SESSION['wishlist'] = [];

        echo json_encode([
            'success' => true,
            'count'   => 0,
            'message' => 'Đã xóa toàn bộ Danh Mục Yêu Thích!'
        ]);
        exit;
    }

    public function count()
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'success' => true,
            'count'   => count($_SESSION['wishlist'] ?? [])
        ]);
        exit;
    }
}

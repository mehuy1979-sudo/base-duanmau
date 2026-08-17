<?php

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $title = "Cửa hàng - Bunny Wear";
        $products = $this->productModel->getAll();
        $categories = $this->productModel->getCategories();

        require_once PATH_VIEW . 'main.php';
    }

    public function detail()
    {
        $id = intval($_GET['id'] ?? 0);
        $product = $this->productModel->getOne($id);

        if (!$product) {
            header('Location: ' . BASE_URL . '?action=/product');
            exit;
        }

        $title = htmlspecialchars($product['product_name']) . " - Bunny Wear";
        $categories = $this->productModel->getCategories();
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'] ?? 0, $id, 4);

        require_once PATH_VIEW . 'product-detail.php';
    }

    public function compare()
    {
        // AJAX endpoint to fetch single product for comparison
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_product') {
            header('Content-Type: application/json; charset=utf-8');
            $id = intval($_GET['id'] ?? 0);
            $product = $this->productModel->getOne($id);
            if ($product) {
                echo json_encode(['success' => true, 'product' => $product]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
            }
            exit;
        }

        $title = "So sánh sản phẩm - Bunny Wear";
        $products = $this->productModel->getAll();

        $p1_id = intval($_GET['p1'] ?? 0);
        $p2_id = intval($_GET['p2'] ?? 0);

        // Pick default first 2 products if not provided
        if ($p1_id === 0 && !empty($products)) {
            $p1_id = $products[0]['id'];
        }
        if ($p2_id === 0 && count($products) > 1) {
            $p2_id = $products[1]['id'];
        } elseif ($p2_id === 0 && !empty($products)) {
            $p2_id = $products[0]['id'];
        }

        $product1 = $p1_id ? $this->productModel->getOne($p1_id) : null;
        $product2 = $p2_id ? $this->productModel->getOne($p2_id) : null;

        require_once PATH_VIEW . 'compare.php';
    }
}
<?php

class ProductController
{
    private $productModel;
    private $reviewModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->reviewModel  = class_exists('ReviewModel') ? new ReviewModel() : null;
    }

    public function index()
    {
        $title = "Cửa hàng - Bunny Wear";
        $products = $this->productModel->getAll();
        $categories = $this->productModel->getCategories();
        $view = 'product';

        require_once PATH_VIEW . 'main.php';
    }

    public function detail()
    {
        $id = intval($_GET['id'] ?? 0);

        // AJAX: Add review endpoint
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'add_review') {
            header('Content-Type: application/json; charset=utf-8');

            $productId = intval($_POST['product_id'] ?? $id);
            $userName  = trim($_POST['user_name'] ?? '');
            $userEmail = trim($_POST['user_email'] ?? '');
            $rating    = intval($_POST['rating'] ?? 5);
            $comment   = trim($_POST['comment'] ?? '');

            if ($productId <= 0 || empty($userName) || empty($comment)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng điền đầy đủ Họ tên và Nội dung đánh giá.'
                ]);
                exit;
            }

            if (!$this->reviewModel) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Hệ thống đánh giá tạm thời gián đoạn.'
                ]);
                exit;
            }

            $newId = $this->reviewModel->createReview([
                'product_id' => $productId,
                'user_name'  => $userName,
                'user_email' => $userEmail,
                'rating'     => $rating,
                'comment'    => $comment
            ]);

            if ($newId) {
                $summary = $this->reviewModel->getRatingSummary($productId);
                echo json_encode([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã gửi đánh giá sản phẩm!',
                    'review'  => [
                        'id'         => $newId,
                        'user_name'  => htmlspecialchars($userName),
                        'rating'     => $rating,
                        'comment'    => htmlspecialchars($comment),
                        'created_at' => date('d/m/Y H:i')
                    ],
                    'summary' => $summary
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Không thể lưu đánh giá. Vui lòng thử lại sau!'
                ]);
            }
            exit;
        }

        $product = $this->productModel->getOne($id);

        if (!$product) {
            header('Location: ' . BASE_URL . '?action=/product');
            exit;
        }

        $title = htmlspecialchars($product['product_name'] ?? 'Sản phẩm') . " - Bunny Wear";
        $categories = $this->productModel->getCategories();
        $variants = $this->productModel->getVariants($id);
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'] ?? 0, $id, 4);

        // Fetch reviews and rating breakdown
        $reviews = $this->reviewModel ? $this->reviewModel->getByProductId($id) : [];
        $ratingSummary = $this->reviewModel ? $this->reviewModel->getRatingSummary($id) : [
            'count' => 0, 'avg' => 5.0, 'breakdown' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
        ];

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
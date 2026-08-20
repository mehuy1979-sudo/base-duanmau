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
        
        // Tổng hợp tất cả các tham số lọc từ phương thức GET
        $filters = [
            'category' => $_GET['category'] ?? null,
            'sort'     => $_GET['sort'] ?? ($_GET['sort_price'] ?? null),
            'keyword'  => trim($_GET['keyword'] ?? ($_GET['search-product'] ?? ''))
        ];
        
        if (!empty($filters['category']) || !empty($filters['sort']) || !empty($filters['keyword'])) {
            $products = $this->productModel->getFilteredProducts($filters);
        } else {
            $products = $this->productModel->getAll();
        }

        $categories = $this->productModel->getCategories();
        $view = 'product';

        require_once PATH_VIEW . 'main.php';
    }

    public function search()
    {
        $view = 'search';
        $orderBy = $_POST['sort_price'] ?? ($_GET['sort_price'] ?? 'asc');
        $keyword = $_POST['keyword'] ?? ($_GET['keyword'] ?? '');

        $listproduct = [];
        if ($keyword !== '') {
            $listproduct = $this->productModel->getproductByKey($keyword, $orderBy);
        } else {
            $listproduct = $this->productModel->getAll();
        }

        require_once PATH_VIEW . 'search.php';
    }

    public function searchByKey()
    {
        $this->search();
    }

    public function detail()
    {
        $id = intval($_GET['id'] ?? 0);

        // AJAX: Add review endpoint
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'add_review') {
            header('Content-Type: application/json; charset=utf-8');

            $currentUser = $_SESSION['user'] ?? null;
            $userId      = $currentUser['id'] ?? ($_SESSION['user_id'] ?? null);
            $userEmail   = $currentUser['email'] ?? trim($_POST['user_email'] ?? '');

            if (!$currentUser && empty($userId)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập tài khoản đã mua sản phẩm này để gửi đánh giá.'
                ]);
                exit;
            }

            $productId = intval($_POST['product_id'] ?? $id);
            $userName  = trim($_POST['user_name'] ?? ($currentUser['fullname'] ?? ''));
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

            // Kiểm tra điều kiện: chỉ customer đã mua hàng mới được đánh giá
            $hasPurchased = $this->reviewModel->hasPurchasedProduct($userId, $userEmail, $productId);
            if (!$hasPurchased) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Bạn chỉ có thể đánh giá và chấm sao sau khi đã mua sản phẩm này!'
                ]);
                exit;
            }

            $newId = $this->reviewModel->createReview([
                'product_id'           => $productId,
                'user_id'              => $userId,
                'user_name'            => $userName,
                'user_email'           => $userEmail,
                'rating'               => $rating,
                'comment'              => $comment,
                'is_verified_purchase' => 1
            ]);

            if ($newId) {
                $summary = $this->reviewModel->getRatingSummary($productId);
                echo json_encode([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã gửi đánh giá! Đánh giá đã được xác thực mua hàng thành công.',
                    'review'  => [
                        'id'                   => $newId,
                        'user_name'            => htmlspecialchars($userName),
                        'rating'               => $rating,
                        'comment'              => htmlspecialchars($comment),
                        'is_verified_purchase' => 1,
                        'created_at'           => date('d/m/Y H:i')
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
            'total' => 0, 'average' => 5.0, 'breakdown' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0], 'percentages' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
        ];

        // Kiểm tra quyền đánh giá của người dùng hiện tại
        $currentUser = $_SESSION['user'] ?? null;
        $userId      = $currentUser['id'] ?? ($_SESSION['user_id'] ?? null);
        $userEmail   = $currentUser['email'] ?? '';

        $canReview = $this->reviewModel ? $this->reviewModel->canUserReview($userId, $userEmail, $id) : [
            'can_review'    => false,
            'is_logged_in'  => false,
            'has_purchased' => false,
            'reason'        => 'Hệ thống đánh giá tạm thời gián đoạn.'
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

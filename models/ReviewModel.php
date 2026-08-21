<?php

class ReviewModel extends BaseModel
{
    protected $table = "product_reviews";

    public function __construct()
    {
        parent::__construct();
        $this->ensureTableExists();
    }

    private function ensureTableExists()
    {
        if (!$this->pdo) return;
        try {
            $sql = "CREATE TABLE IF NOT EXISTS product_reviews (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                user_id INT NULL,
                user_name VARCHAR(100) NOT NULL,
                user_email VARCHAR(150) NULL,
                user_avatar VARCHAR(255) NULL,
                rating TINYINT NOT NULL DEFAULT 5,
                comment TEXT NOT NULL,
                is_verified_purchase TINYINT(1) NOT NULL DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_product_id (product_id),
                INDEX idx_user_id (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->pdo->exec($sql);

            // Add columns if table existed previously without them
            $existingCols = $this->pdo->query("SHOW COLUMNS FROM product_reviews")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('user_id', $existingCols)) {
                $this->pdo->exec("ALTER TABLE product_reviews ADD COLUMN user_id INT NULL AFTER product_id");
            }
            if (!in_array('is_verified_purchase', $existingCols)) {
                $this->pdo->exec("ALTER TABLE product_reviews ADD COLUMN is_verified_purchase TINYINT(1) NOT NULL DEFAULT 1 AFTER comment");
            }

            // Seed sample reviews if empty
            $countStmt = $this->pdo->query("SELECT COUNT(*) FROM product_reviews");
            if ($countStmt && $countStmt->fetchColumn() == 0) {
                $this->seedSampleReviews();
            }
        } catch (\PDOException $e) {
            // Silently ignore
        }
    }

    private function seedSampleReviews()
    {
        if (!$this->pdo) return;
        try {
            $samples = [
                [
                    'product_id'           => 1,
                    'user_name'            => 'Nguyễn Hoàng Long',
                    'user_email'           => 'longnguyen@gmail.com',
                    'rating'               => 5,
                    'comment'              => 'Áo form rộng mặc rất thoải mái, chất vải cotton 100% dày dặn không bị xù lông khi giặt. Rất ưng ý!',
                    'is_verified_purchase' => 1,
                    'created_at'           => date('Y-m-d H:i:s', strtotime('-2 days'))
                ],
                [
                    'product_id'           => 1,
                    'user_name'            => 'Trần Thu Trang',
                    'user_email'           => 'trangtran@gmail.com',
                    'rating'               => 5,
                    'comment'              => 'Giao hàng siêu nhanh, đóng gói hộp Bunny Wear rất sang trọng. Mình mua tặng bạn mà ai cũng khen đẹp.',
                    'is_verified_purchase' => 1,
                    'created_at'           => date('Y-m-d H:i:s', strtotime('-5 days'))
                ],
                [
                    'product_id'           => 1,
                    'user_name'            => 'Lê Minh Tuấn',
                    'user_email'           => 'tuanle@gmail.com',
                    'rating'               => 4,
                    'comment'              => 'Đúng size chuẩn, màu sắc bên ngoài đẹp hơn trong ảnh mẫu chụp một chút. 4 sao cho chất lượng phục vụ!',
                    'is_verified_purchase' => 1,
                    'created_at'           => date('Y-m-d H:i:s', strtotime('-10 days'))
                ],
                [
                    'product_id'           => 2,
                    'user_name'            => 'Phạm Hải Đăng',
                    'user_email'           => 'dangpham@gmail.com',
                    'rating'               => 5,
                    'comment'              => 'Chất vải co giãn nhẹ, đường may tỉ mỉ. Đáng tiền mua nha mọi người.',
                    'is_verified_purchase' => 1,
                    'created_at'           => date('Y-m-d H:i:s', strtotime('-1 days'))
                ],
                [
                    'product_id'           => 3,
                    'user_name'            => 'Vũ Thị Ngọc',
                    'user_email'           => 'ngocvu@gmail.com',
                    'rating'               => 5,
                    'comment'              => 'Áo đẹp đỉnh chóp, mặc đi chơi đi dạo phố mùa thu đông là hết bài luôn.',
                    'is_verified_purchase' => 1,
                    'created_at'           => date('Y-m-d H:i:s', strtotime('-3 days'))
                ]
            ];

            $sql = "INSERT INTO product_reviews (product_id, user_name, user_email, rating, comment, is_verified_purchase, created_at) 
                    VALUES (:product_id, :user_name, :user_email, :rating, :comment, :is_verified_purchase, :created_at)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($samples as $sample) {
                $stmt->execute($sample);
            }
        } catch (\PDOException $e) {
            // Ignore seeding errors
        }
    }

    /**
     * Kiểm tra người dùng đã mua sản phẩm này hay chưa
     */
    public function hasPurchasedProduct($userId = null, $userEmail = '', $productId = 0): bool
    {
        if (!$this->pdo || empty($productId)) return false;
        $productId = (int)$productId;

        $conditions = [];
        $params = [':pid' => $productId];

        if (!empty($userId)) {
            $conditions[] = "o.user_id = :uid";
            $params[':uid'] = (int)$userId;
        }

        $cleanEmail = trim($userEmail);
        if (!empty($cleanEmail)) {
            $conditions[] = "LOWER(o.email) = :email";
            $params[':email'] = strtolower($cleanEmail);
        }

        if (empty($conditions)) {
            return false;
        }

        $userCond = '(' . implode(' OR ', $conditions) . ')';

        try {
            $sql = "SELECT COUNT(*) FROM orders o
                    INNER JOIN order_details od ON o.id = od.order_id
                    WHERE od.product_id = :pid AND {$userCond} 
                      AND (o.order_status != 7 AND o.status NOT IN ('Đã hủy', 'cancelled', 'hủy'))";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int)$stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Đánh giá quyền được review của người dùng đối với sản phẩm
     */
    public function canUserReview($userId = null, $userEmail = '', $productId = 0): array
    {
        $isLoggedIn = !empty($userId) || !empty($userEmail);

        if (!$isLoggedIn) {
            return [
                'can_review'   => false,
                'is_logged_in' => false,
                'has_purchased'=> false,
                'reason'       => 'Vui lòng đăng nhập bằng tài khoản đã mua hàng để đánh giá sản phẩm.'
            ];
        }

        $hasPurchased = $this->hasPurchasedProduct($userId, $userEmail, $productId);

        if (!$hasPurchased) {
            return [
                'can_review'   => false,
                'is_logged_in' => true,
                'has_purchased'=> false,
                'reason'       => 'Bạn chỉ có thể đánh giá và chấm sao sau khi đã mua sản phẩm này.'
            ];
        }

        return [
            'can_review'   => true,
            'is_logged_in' => true,
            'has_purchased'=> true,
            'reason'       => 'Bạn đã mua sản phẩm này và đủ điều kiện gửi đánh giá.'
        ];
    }

    /**
     * Lấy danh sách đánh giá theo sản phẩm
     */
    public function getByProductId($productId)
    {
        if (!$this->pdo || empty($productId)) return [];
        try {
            $sql = "SELECT * FROM product_reviews WHERE product_id = :pid ORDER BY id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['pid' => (int)$productId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Tính toán tổng quan số sao & tỷ lệ phần trăm đánh giá
     */
    public function getRatingSummary($productId)
    {
        $reviews = $this->getByProductId($productId);
        $total = count($reviews);

        $breakdown = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];

        $sum = 0;
        foreach ($reviews as $r) {
            $score = max(1, min(5, intval($r['rating'])));
            $breakdown[$score]++;
            $sum += $score;
        }

        $average = $total > 0 ? round($sum / $total, 1) : 5.0;

        $percentages = [];
        foreach ($breakdown as $star => $count) {
            $percentages[$star] = $total > 0 ? round(($count / $total) * 100) : 0;
        }

        return [
            'total'       => $total,
            'average'     => $average,
            'breakdown'   => $breakdown,
            'percentages' => $percentages
        ];
    }

    /**
     * Thêm đánh giá mới
     */
    public function createReview($data)
    {
        if (!$this->pdo || empty($data['product_id']) || empty($data['user_name']) || empty($data['comment'])) {
            return false;
        }

        try {
            $sql = "INSERT INTO product_reviews (product_id, user_id, user_name, user_email, rating, comment, is_verified_purchase) 
                    VALUES (:product_id, :user_id, :user_name, :user_email, :rating, :comment, :is_verified_purchase)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                'product_id'           => (int)$data['product_id'],
                'user_id'              => !empty($data['user_id']) ? (int)$data['user_id'] : null,
                'user_name'            => htmlspecialchars(trim($data['user_name'])),
                'user_email'           => !empty($data['user_email']) ? htmlspecialchars(trim($data['user_email'])) : null,
                'rating'               => max(1, min(5, intval($data['rating'] ?? 5))),
                'comment'              => htmlspecialchars(trim($data['comment'])),
                'is_verified_purchase' => !empty($data['is_verified_purchase']) ? 1 : 0
            ]);

            if ($ok) {
                return (int)$this->pdo->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }
}

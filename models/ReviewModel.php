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
                user_name VARCHAR(100) NOT NULL,
                user_email VARCHAR(150) NULL,
                user_avatar VARCHAR(255) NULL,
                rating TINYINT NOT NULL DEFAULT 5,
                comment TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_product_id (product_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->pdo->exec($sql);

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
                    'product_id' => 1,
                    'user_name'  => 'Nguyễn Hoàng Long',
                    'user_email' => 'longnguyen@gmail.com',
                    'rating'     => 5,
                    'comment'    => 'Áo form rộng mặc rất thoải mái, chất vải cotton 100% dày dặn không bị xù lông khi giặt. Rất ưng ý!',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                ],
                [
                    'product_id' => 1,
                    'user_name'  => 'Trần Thu Trang',
                    'user_email' => 'trangtran@gmail.com',
                    'rating'     => 5,
                    'comment'    => 'Giao hàng siêu nhanh, đóng gói hộp Bunny Wear rất sang trọng. Mình mua tặng người yêu mà ai cũng khen đẹp.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
                ],
                [
                    'product_id' => 1,
                    'user_name'  => 'Lê Minh Tuấn',
                    'user_email' => 'tuanle@gmail.com',
                    'rating'     => 4,
                    'comment'    => 'Đúng size chuẩn, màu sắc bên ngoài đẹp hơn trong ảnh mẫu chụp một chút. 4 sao cho chất lượng dịch vụ!',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
                ],
                [
                    'product_id' => 2,
                    'user_name'  => 'Phạm Hải Đăng',
                    'user_email' => 'dangpham@gmail.com',
                    'rating'     => 5,
                    'comment'    => 'Chất vải co giãn nhẹ, đường may tỉ mỉ. Đáng tiền mua nha mọi người.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 days'))
                ],
                [
                    'product_id' => 3,
                    'user_name'  => 'Vũ Thị Ngọc',
                    'user_email' => 'ngocvu@gmail.com',
                    'rating'     => 5,
                    'comment'    => 'Áo đẹp đỉnh chóp, mặc đi chơi đi dạo phố mùa thu đông là hết bài luôn.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
                ]
            ];

            $sql = "INSERT INTO product_reviews (product_id, user_name, user_email, rating, comment, created_at) 
                    VALUES (:product_id, :user_name, :user_email, :rating, :comment, :created_at)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($samples as $sample) {
                $stmt->execute($sample);
            }
        } catch (\PDOException $e) {
            // Ignore seeding errors
        }
    }

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

    public function createReview($data)
    {
        if (!$this->pdo || empty($data['product_id']) || empty($data['user_name']) || empty($data['comment'])) {
            return false;
        }

        try {
            $sql = "INSERT INTO product_reviews (product_id, user_name, user_email, rating, comment) 
                    VALUES (:product_id, :user_name, :user_email, :rating, :comment)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                'product_id' => (int)$data['product_id'],
                'user_name'  => htmlspecialchars(trim($data['user_name'])),
                'user_email' => !empty($data['user_email']) ? htmlspecialchars(trim($data['user_email'])) : null,
                'rating'     => max(1, min(5, intval($data['rating'] ?? 5))),
                'comment'    => htmlspecialchars(trim($data['comment']))
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

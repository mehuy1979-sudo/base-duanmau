-- =========================================================
-- Cập nhật bảng product_reviews và orders để hỗ trợ
-- tính năng: Khách hàng chỉ được bình luận và chấm sao khi đã mua hàng
-- =========================================================

-- 1. Bảng product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id`                   INT AUTO_INCREMENT PRIMARY KEY,
  `product_id`           INT NOT NULL,
  `user_id`              INT NULL,
  `user_name`            VARCHAR(100) NOT NULL,
  `user_email`           VARCHAR(150) NULL,
  `user_avatar`          VARCHAR(255) NULL,
  `rating`               TINYINT NOT NULL DEFAULT 5,
  `comment`              TEXT NOT NULL,
  `is_verified_purchase` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`           DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_product_id` (`product_id`),
  INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm các cột nếu bảng đã tồn tại từ trước:
-- ALTER TABLE `product_reviews` ADD COLUMN `user_id` INT NULL AFTER `product_id`;
-- ALTER TABLE `product_reviews` ADD COLUMN `is_verified_purchase` TINYINT(1) NOT NULL DEFAULT 1 AFTER `comment`;

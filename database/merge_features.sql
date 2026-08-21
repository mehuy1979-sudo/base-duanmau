-- =========================================================
-- MIGRATION: ghép chức năng từ các base khác vào base-duanmau-master
-- Chạy toàn bộ file này trên database "shop_quanao"
-- (Sau auth_users.sql và add_status_column.sql đã chạy trước đó)
-- =========================================================

-- ---------------------------------------------------------
-- 1) SO SÁNH + QUẢN LÝ SẢN PHẨM NÂNG CAO (từ base CongChese)
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categories` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(150) NOT NULL,
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mở rộng bảng products (bỏ qua dòng nào báo lỗi "Duplicate column" nếu cột đã có sẵn)
ALTER TABLE `products` ADD COLUMN `category_id`     INT NULL AFTER `id`;
ALTER TABLE `products` ADD COLUMN `sku`             VARCHAR(100) NULL;
ALTER TABLE `products` ADD COLUMN `brand`           VARCHAR(100) NULL;
ALTER TABLE `products` ADD COLUMN `gender`          VARCHAR(50)  NULL;
ALTER TABLE `products` ADD COLUMN `original_price`  DECIMAL(12,0) NULL;
ALTER TABLE `products` ADD COLUMN `quantity`        INT NOT NULL DEFAULT 0;
ALTER TABLE `products` ADD COLUMN `sizes`           VARCHAR(255) NULL;
ALTER TABLE `products` ADD COLUMN `colors`          VARCHAR(255) NULL;
ALTER TABLE `products` ADD COLUMN `description`     TEXT NULL;
ALTER TABLE `products` ADD COLUMN `status`          ENUM('active','out','hidden') NOT NULL DEFAULT 'active';

CREATE TABLE IF NOT EXISTS `product_variants` (
  `id`              INT AUTO_INCREMENT PRIMARY KEY,
  `product_id`      INT NOT NULL,
  `size`            VARCHAR(50)  NULL,
  `color`           VARCHAR(50)  NULL,
  `original_price`  DECIMAL(12,0) NULL,
  `sale_price`      DECIMAL(12,0) NULL,
  `quantity`        INT NOT NULL DEFAULT 0,
  `sku`             VARCHAR(100) NULL,
  KEY `idx_pv_product` (`product_id`),
  CONSTRAINT `fk_pv_product` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `product_images` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `image`      VARCHAR(255) NOT NULL,
  KEY `idx_pi_product` (`product_id`),
  CONSTRAINT `fk_pi_product` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 2) QUẢN LÝ ĐƠN HÀNG ADMIN (từ base nguyenanhhuy)
-- ---------------------------------------------------------
-- orders.status (text, "Đang xử lý"...) vẫn giữ nguyên cho phần checkout hiện có.
-- Thêm order_status dạng số để trang quản trị đơn hàng dùng (1..7, xem OrderModel).
ALTER TABLE `orders` ADD COLUMN `order_status`   TINYINT NOT NULL DEFAULT 1 AFTER `status`;
ALTER TABLE `orders` ADD COLUMN `payment_status` TINYINT NOT NULL DEFAULT 0 AFTER `order_status`;
ALTER TABLE `orders` ADD COLUMN `cancel_reason`  VARCHAR(255) NULL;
ALTER TABLE `orders` ADD COLUMN `updated_at`     DATETIME NULL;

-- ---------------------------------------------------------
-- 3) BÌNH LUẬN SẢN PHẨM (từ base tuananh03)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comments` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`    INT NULL,
  `product_id` INT NULL,
  `content`    TEXT NOT NULL,
  `rating`     TINYINT NULL DEFAULT NULL,
  `is_locked`  TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LƯU Ý: Nếu chạy ALTER TABLE mà báo lỗi "Duplicate column name",
-- nghĩa là cột đó đã tồn tại rồi -> bỏ qua dòng đó, chạy tiếp các dòng còn lại.

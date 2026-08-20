-- =========================================================
-- Bảng tài khoản người dùng (đăng ký / đăng nhập)
-- Chạy file này trên database "shop_quanao" (xem configs/database.php)
-- =========================================================

CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `fullname`   VARCHAR(150)  NOT NULL,
  `email`      VARCHAR(150)  NOT NULL UNIQUE,
  `password`   VARCHAR(255)  NOT NULL,
  `phone`      VARCHAR(20)   DEFAULT NULL,
  `role`       ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  `status`     ENUM('active','locked')  NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Nếu bảng `users` của bạn đã tồn tại từ trước nhưng thiếu cột `phone`,
-- hãy chạy thêm câu lệnh dưới đây (bỏ qua nếu cột đã có sẵn):
-- ALTER TABLE `users` ADD COLUMN `phone` VARCHAR(20) DEFAULT NULL AFTER `password`;

-- Nếu bảng `users` chưa có cột `status` (khóa/mở tài khoản), chạy:
-- ALTER TABLE `users` ADD COLUMN `status` ENUM('active','locked') NOT NULL DEFAULT 'active' AFTER `role`;

-- LƯU Ý VỀ TÀI KHOẢN ADMIN ĐẦU TIÊN:
-- Bạn KHÔNG cần insert admin thủ công. Tài khoản đầu tiên đăng ký qua
-- trang "Đăng ký" của website sẽ tự động được gán quyền admin
-- (xem AuthController::register()). Các tài khoản đăng ký sau đó sẽ là
-- "customer". Sau khi có admin, bạn có thể vào trang quản trị
-- (Quản lý tài khoản) để đổi quyền cho tài khoản khác nếu cần.

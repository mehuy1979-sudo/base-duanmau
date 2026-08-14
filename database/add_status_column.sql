-- Chỉ cần chạy file này (bảng users của bạn đã có sẵn id, fullname, email, password, role, created_at)
ALTER TABLE `users`
  ADD COLUMN `status` ENUM('active','locked') NOT NULL DEFAULT 'active' AFTER `role`;

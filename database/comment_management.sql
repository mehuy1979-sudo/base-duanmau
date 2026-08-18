-- Chạy file này trong phpMyAdmin > shop_quanao > SQL
-- Bảng hiện tại của bạn: id, user_id, product_id, content, created_at

ALTER TABLE comments
    ADD COLUMN rating TINYINT NULL DEFAULT NULL AFTER content,
    ADD COLUMN is_locked TINYINT(1) NOT NULL DEFAULT 0 AFTER rating;

-- Nếu muốn dữ liệu mẫu có số sao, có thể chạy thêm:
-- UPDATE comments SET rating = 5 WHERE id = 1;
-- UPDATE comments SET rating = 4 WHERE id = 2;
-- UPDATE comments SET rating = 5 WHERE id = 3;
-- UPDATE comments SET rating = 4 WHERE id = 4;
-- UPDATE comments SET rating = 5 WHERE id = 5;

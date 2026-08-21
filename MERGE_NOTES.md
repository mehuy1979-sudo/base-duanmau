# Ghi chú ghép chức năng (từ base-duanmau-fixed)

Đã ghép 5 nhóm chức năng từ các base khác vào base này (giữ nguyên Auth + Cart + Quản lý tài khoản admin sẵn có).

## 1. Việc đầu tiên cần làm: chạy SQL

Mở phpMyAdmin (hoặc công cụ SQL bạn dùng), chọn database `shop_quanao`, chạy toàn bộ file:

```
database/merge_features.sql
```

File này tạo các bảng mới (`categories`, `product_variants`, `product_images`, `comments`) và thêm cột mới vào `products`, `orders`. Nếu dòng `ALTER TABLE` nào báo lỗi "Duplicate column" nghĩa là cột đã có sẵn — bỏ qua dòng đó, chạy tiếp các dòng còn lại.

## 2. So sánh + Quản lý sản phẩm nâng cao (từ base CongChese)

- Trang chi tiết sản phẩm: `?action=/product-detail&id=X`
- Trang so sánh 2 sản phẩm: `?action=/compare&p1=X&p2=Y`
- Trang quản trị sản phẩm (thêm/sửa/xóa, biến thể size/màu, upload ảnh, album ảnh): `?action=/admin/products` (cần đăng nhập tài khoản role `admin`)
- `models/ProductModel.php` đã được thay bằng bản đầy đủ (join category, biến thể, ảnh) — vẫn tương thích các hàm cũ (`getAll`, `getOne`, `insert`, `updateProduct`, `deleteProduct`) nên không phá vỡ chỗ nào đang dùng ProductModel trước đó.
- `configs/helper.php` được thay bằng bản có thêm `upload_multiple_files()`, `str_slug()` (vẫn giữ `debug()` và `upload_file()` cũ, chỉ nâng cấp thêm tự tạo thư mục + làm sạch tên file).

## 3. Quản lý đơn hàng admin (từ base nguyenanhhuy)

- Danh sách đơn: vào trang quản trị → "Quản lý đơn hàng" (`admin/index.php?action=orders`)
- Chi tiết + đổi trạng thái đơn: `admin/index.php?action=order_detail&id=X`
- Đơn hàng mới đặt từ trang checkout sẽ mặc định `order_status = 1` (Chờ xác nhận) nhờ giá trị `DEFAULT` trong SQL, không cần sửa `CartController`.
- Lưu ý: cột `status` (text, "Đang xử lý"...) dùng cho trang order-success của khách vẫn giữ nguyên; cột `order_status` (số 1-7) là cột **mới**, riêng cho khu quản trị. Hai cột này độc lập, chưa đồng bộ 2 chiều — nếu cần đồng bộ, có thể sửa thêm sau.

## 4. Bình luận sản phẩm (từ base tuananh03)

- Trang quản trị bình luận: `admin/comments.php` (đã thêm chốt chặn chỉ cho admin đã đăng nhập vào)
- **Không** lấy phần `UserController`/`UserModel` của base tuananh03 vì nó là một hệ thống đăng nhập/đăng ký khác, trùng chức năng và xung đột với `AuthController`/`AccountModel` đã có sẵn (khác cách lưu session, không có khóa tài khoản/phân quyền). Bình luận vẫn dùng chung bảng `users` hiện tại của bạn qua join `user_id`.
- Trang này hiện chưa có form để khách để lại bình luận (base tuananh03 mới chỉ làm phần quản trị) — nếu cần, đây là việc tiếp theo.

## 5. Danh Mục Yêu Thích (Wishlist) + Đánh giá sản phẩm (Reviews) — từ base CongChese

- **Wishlist** (lưu trong session, không cần đăng nhập):
  - Trang danh sách: `?action=/wishlist`
  - Nút "Yêu thích" trên trang chi tiết sản phẩm (`?action=/product-detail&id=X`) đổi màu khi đã thêm.
  - Icon trái tim ở header (`main.php`, cả bản desktop/mobile) đã trỏ về `?action=/wishlist` và hiện số lượng đang lưu.
  - `WishlistController.php` (mới) xử lý toggle/remove/clear/count qua AJAX (`?action=/wishlist&ajax=...`).
  - `ProductModel::getByIds()` (mới) — lấy nhiều sản phẩm theo danh sách id, phục vụ trang wishlist.
  - Lưu ý: các icon trái tim tĩnh trong khối "sản phẩm nổi bật" ở trang chủ (`main.php`, mục demo 12 sản phẩm) vẫn chưa nối AJAX vì khối đó vốn là HTML mẫu tĩnh của theme, chưa lấy dữ liệu từ DB — không thuộc phạm vi merge lần này.
- **Reviews** (lưu DB, bảng `product_reviews` tự tạo khi chạy lần đầu — không cần chạy SQL thủ công):
  - `ReviewModel.php` (mới) — tự tạo bảng `product_reviews` (INNODB) nếu chưa có, có sẵn vài đánh giá mẫu để demo.
  - Tab "Đánh giá" ở trang chi tiết sản phẩm giờ hiển thị điểm trung bình + danh sách đánh giá thật từ DB, kèm form gửi đánh giá mới (AJAX `?action=/product-detail&id=X&ajax=add_review`).
  - Đây là hệ thống **riêng biệt** với `CommentModel`/`admin/comments.php` đã có sẵn trong base (bảng `comments` dùng cho bình luận quản trị duyệt) — hai hệ thống không đụng nhau.

## Việc chưa ghép (theo lựa chọn của bạn)

- Giỏ hàng đơn giản từ base taquan-giohang: không lấy vì base của bạn đã có giỏ hàng đầy đủ hơn (mã giảm giá, đặt hàng lưu DB...).
- Trang tìm kiếm sản phẩm (`search.php`) từ base nguyenanhhuy: bản gốc mới chỉ là khung sườn (bạn ấy chưa code phần truy vấn DB thật), nên không ghép vào — nếu cần, đây có thể làm tiếp riêng.

## Kiểm tra nhanh sau khi merge

Chưa cài được PHP CLI trong môi trường này nên chưa chạy `php -l`/test thực tế được — hãy mở thử từng trang trên XAMPP/Laragon của bạn trước khi dùng chính thức, đặc biệt là:
- `?action=/admin/products` (phần AJAX thêm/sửa/xóa)
- `admin/index.php?action=orders`
- `?action=/wishlist` và nút "Yêu thích" ở trang chi tiết sản phẩm
- Tab "Đánh giá" + form gửi đánh giá ở trang chi tiết sản phẩm (bảng `product_reviews` sẽ tự tạo trong lần chạy đầu tiên, cần quyền `CREATE TABLE` cho user DB của bạn)

# TÀI LIỆU HỆ THỐNG QUẢN TRỊ (ADMIN DASHBOARD) - BUNNY WEAR

Hệ thống quản trị **Bunny Wear Admin** được xây dựng theo mô hình MVC, cung cấp đầy đủ các công cụ quản lý toàn diện cho cửa hàng thương mại điện tử.

---

## 1. Truy cập & Phân quyền bảo mật
- **Đường dẫn truy cập**: `http://localhost/base-duanmau-master/admin/index.php`
- **Cơ chế xác thực**:
  - Tự động kiểm tra phiên đăng nhập `$_SESSION['user']`.
  - Chỉ cho phép tài khoản có vai trò `role = 'admin'` truy cập.
  - Nếu chưa đăng nhập hoặc không phải admin, hệ thống tự động chuyển hướng về trang đăng nhập `?action=/login`.
- **Tài khoản Admin mặc định**:
  - **Email**: `admin@bunnywear.vn`
  - **Mật khẩu**: `123456`

---

## 2. Các Chức Năng Chính Trong Hệ Thống Admin

### 📊 1. Bảng điều khiển (Dashboard & Thống kê)
- **Tổng quan số liệu**:
  - Tổng doanh thu theo ngày / tuần / tháng / năm.
  - Tổng số đơn hàng mới và đơn hàng đang xử lý.
  - Tổng số lượng sản phẩm đang kinh doanh và tồn kho.
  - Tổng số lượng khách hàng đã đăng ký.
- **Biểu đồ trực quan**:
  - Biểu đồ tăng trưởng doanh thu.
  - Thống kê sản phẩm bán chạy nhất (Top Best Sellers).
  - Tỷ lệ trạng thái đơn hàng (Chờ xác nhận, Đang giao, Hoàn thành, Đã hủy).

---

### 👗 2. Quản lý Sản phẩm & Danh mục (`admin/views/products.php`, `AdminProductController.php`)
- **Danh sách sản phẩm**:
  - Hiển thị danh sách sản phẩm với hình ảnh, tên, danh mục, giá bán và số lượng biến thể.
  - Tìm kiếm sản phẩm theo tên, mã SKU hoặc lọc theo danh mục.
- **Thêm mới & Cập nhật sản phẩm**:
  - Thêm tên, mô tả, danh mục, giá gốc, giá khuyến mãi và ảnh đại diện chính.
  - **Quản lý biến thể đa thuộc tính (Variants)**: Quản lý kích cỡ (Size: S, M, L, XL), màu sắc (Color), số lượng tồn và SKU từng biến thể.
  - **Thư viện ảnh (Gallery Images)**: Upload nhiều ảnh chi tiết cho sản phẩm.
- **Xóa sản phẩm**:
  - Tự động dọn dẹp biến thể liên quan và ảnh đính kèm khi xóa.

---

### 📦 3. Quản lý Đơn hàng (`AdminOrderController.php`, `views/order/`)
- **Danh sách đơn hàng**:
  - Hiển thị mã đơn hàng, ngày đặt, thông tin người nhận (Tên, SĐT, Địa chỉ), tổng tiền và phương thức thanh toán.
  - Lọc đơn hàng theo trạng thái: *Chờ xác nhận*, *Đã xác nhận*, *Đang giao hàng*, *Đã giao hàng*, *Đã hủy*.
- **Chi tiết đơn hàng (`?action=/admin/order_detail&id={id}`)**:
  - Danh sách từng món hàng đã đặt, số lượng, đơn giá, thành tiền, size và màu sắc.
  - Thông tin giao hàng và ghi chú của khách.
- **Cập nhật trạng thái**:
  - Chuyển đổi trạng thái xử lý đơn hàng nhanh chóng.

---

### 💬 4. Quản lý Đánh giá & Bình luận (`admin/comments.php`, `CommentModel.php`)
- **Theo dõi phản hồi khách hàng**:
  - Xem danh sách bình luận, số sao đánh giá (1 - 5 sao) và nội dung nhận xét của khách hàng theo từng sản phẩm.
  - Nhận diện huy hiệu **Xác nhận đã mua hàng (Verified Purchase)**.
- **Duyệt & Kiểm duyệt**:
  - Ẩn / Hiện bình luận hoặc xóa các đánh giá vi phạm tiêu chuẩn cộng đồng.

---

### 👥 5. Quản lý Tài khoản & Khách hàng (`AccountController.php`, `admin/views/account/`)
- **Danh sách người dùng**:
  - Hiển thị danh sách tất cả tài khoản gồm: Họ tên, Email, Số điện thoại, Vai trò (`admin` / `customer`), Trạng thái hoạt động.
- **Phân quyền & Khóa tài khoản**:
  - Đổi vai trò tài khoản (`customer` $\leftrightarrow$ `admin`).
  - Khóa tài khoản (`toggle-lock`) đối với tài khoản gian lận hoặc mở khóa khi cần.
  - Xem chi tiết lịch sử mua hàng của từng tài khoản.

---

### ⚙️ 6. Cấu hình Hệ thống (`settings.php`)
- Cấu hình thông tin thương hiệu Bunny Wear (Logo, Hotline, Email hỗ trợ, Địa chỉ shop).
- Cấu hình phí vận chuyển và liên kết mạng xã hội (Facebook, Instagram).

---

## 3. Cấu trúc Thư mục Admin

```
admin/
├── index.php                 # Entry point điều hướng admin
├── comments.php              # Module quản lý bình luận & đánh giá
├── controllers/
│   ├── PageController.php    # Điều khiển Dashboard, Thống kê, Cài đặt
│   └── AccountController.php # Điều khiển Quản lý tài khoản & phân quyền
├── views/
│   ├── dashboard.php         # Giao diện tổng quan số liệu
│   ├── stats.php             # Giao diện báo cáo thống kê chuyên sâu
│   ├── settings.php          # Giao diện cài đặt hệ thống
│   ├── products.php          # Giao diện CRUD sản phẩm, biến thể & gallery
│   └── account/              # Giao diện danh sách & chi tiết tài khoản
└── assets/                   # CSS, JS, Fonts & Icons dành riêng cho Admin
```

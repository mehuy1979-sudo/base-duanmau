# BÁO CÁO TÌNH TRẠNG LỖI XUNG ĐỘT GIT MERGE (MERGE CONFLICTS)

**Dự án:** `base-duanmau-master`  
**Thời gian lập báo cáo:** 17/08/2026  
**Trạng thái hiện tại:** `MERGE IN PROGRESS` (Đang bị kẹt ở quá trình gộp nhánh do xung đột)

---

## 1. TỔNG QUAN HIỆN TRẠNG

Khi bạn thực hiện lệnh:
```bash
git merge CongChese
```
Hệ thống Git phát hiện có nhiều tệp được chỉnh sửa hoặc tạo mới ở cả 2 nhánh (`master` và `CongChese`) với nội dung khác nhau, dẫn đến thông báo:
> **Automatic merge failed; fix conflicts and then commit the result.**

Vì chưa giải quyết (resolve) xung đột và chưa tạo commit merge hoàn tất, lệnh `git push origin master` không thể đẩy code mới lên (báo `Everything up-to-date` do commit master chưa dịch chuyển). Đồng thời, các file mã nguồn PHP bị chèn các ký tự `<<<<<<< HEAD`, `=======`, `>>>>>>>` khiến website bị lỗi cú pháp không chạy được.

---

## 2. NGUYÊN NHÂN PHÁT SINH LỖI

1. **Xung đột cấu hình điều hướng (`routes/index.php` & `index.php`)**:
   - Ở nhánh `HEAD` (master hiện tại) đang gọi hàm `HomeController->index()` và `ProductController->index()`.
   - Ở nhánh `CongChese` bổ sung thêm các route `/product-detail`, `product-detail`, `/compare`, `compare`, `/admin/products`.

2. **Xung đột tệp trùng lặp giữa thư mục gốc và thư mục chuẩn MVC (`add/add`)**:
   - Cả 2 nhánh cùng tạo các file trùng tên nhưng khác vị trí:
     - `ProductController.php` (ở thư mục gốc) **VS** `controllers/ProductController.php`
     - `ProductModel.php` (ở thư mục gốc) **VS** `models/ProductModel.php`
     - `product.php` (ở thư mục gốc) **VS** `views/product.php`
     - `main.php` (ở thư mục gốc) **VS** `views/main.php`

3. **Xung đột hàng loạt template tĩnh trong `admin/html/`**:
   - 14 tệp HTML trong `admin/html/` bị xung đột do 2 nhánh cùng thêm/chỉnh sửa mã HTML.

---

## 3. DANH SÁCH CHI TIẾT 23 TỆP BỊ XUNG ĐỘT (UNMERGED)

### Nhóm 1: Các tệp Core & Routing (Ưu tiên xử lý cấp 1)
| STT | Đường dẫn tệp | Loại xung đột | Mô tả lỗi |
|:---:|:---|:---:|:---|
| 1 | `routes/index.php` | `both modified` | Trùng match route `/product` và thiếu các route mới |
| 2 | `index.php` | `both modified` | Xung đột phần import controller / model |

### Nhóm 2: Controller & Model theo chuẩn MVC (Ưu tiên xử lý cấp 1)
| STT | Đường dẫn tệp | Loại xung đột | Mô tả lỗi |
|:---:|:---|:---:|:---|
| 3 | `controllers/ProductController.php` | `both added` | Khác biệt phương thức `detail()`, `compare()` |
| 4 | `models/ProductModel.php` | `both added` | Khác biệt giữa các hàm xử lý variants, getOne, getRelated |

### Nhóm 3: Các tệp thừa ở thư mục gốc (Cần chọn phiên bản chuẩn rồi xóa file thừa)
| STT | Đường dẫn tệp | Loại xung đột | Hướng xử lý đề xuất |
|:---:|:---|:---:|:---|
| 5 | `ProductController.php` (root) | `both added` | Xóa (dùng file trong `controllers/`) |
| 6 | `ProductModel.php` (root) | `both added` | Xóa (dùng file trong `models/`) |
| 7 | `product.php` (root) | `both added` | Xóa (dùng `views/product-detail.php` hoặc `views/product.php`) |
| 8 | `main.php` (root) | `both added` | Xóa (dùng `views/main.php`) |

### Nhóm 4: Giao diện Views & Admin HTML
| STT | Đường dẫn tệp | Loại xung đột | Mô tả |
|:---:|:---|:---:|:---|
| 9 | `views/product.php` | `both added` | Giao diện danh sách/chi tiết sản phẩm |
| 10 | `admin/html/add-user.html` | `both added` | Template thêm user |
| 11 | `admin/html/alerts.html` | `both added` | Template alerts |
| 12 | `admin/html/blank.html` | `both added` | Template trang trắng |
| 13 | `admin/html/charts.html` | `both added` | Template biểu đồ |
| 14 | `admin/html/components.html` | `both added` | Template UI components |
| 15 | `admin/html/create-agent.html`| `both added` | Template đại lý |
| 16 | `admin/html/forms.html` | `both added` | Template forms |
| 17 | `admin/html/index.html` | `both added` | Template dashboard |
| 18 | `admin/html/modals.html` | `both added` | Template modals |
| 19 | `admin/html/profile.html` | `both added` | Template profile |
| 20 | `admin/html/settings.html` | `both added` | Template cài đặt |
| 21 | `admin/html/tables.html` | `both added` | Template bảng dữ liệu |
| 22 | `admin/html/user-details.html`| `both added` | Template chi tiết user |
| 23 | `admin/html/users.html` | `both added` | Template danh sách user |

---

## 4. HƯỚNG DẪN CÁC BƯỚC GIẢI QUYẾT (KẾ HOẠCH FIX)

### Bước 1: Giữ lại code chuẩn MVC và tính năng mới nhất
- Giữ các tính năng mới vừa hoàn thiện:
  - Multi-select màu sắc theo size trong `controllers/AdminProductController.php` và `admin/views/products.php`.
  - Các route chuẩn trong `routes/index.php`:
    ```php
    match ($action) {
        '/'                 => (new HomeController)->index(),
        '/product'          => (new ProductController)->index(),
        '/product-detail'   => (new ProductController)->detail(),
        'product-detail'    => (new ProductController)->detail(),
        '/compare'          => (new ProductController)->compare(),
        'compare'           => (new ProductController)->compare(),
        '/admin/products'   => (new AdminProductController)->index(),
        default             => http_response_code(404),
    };
    ```
- Xóa các file thừa ở thư mục gốc (`ProductController.php`, `ProductModel.php`, `product.php`, `main.php`).

### Bước 2: Resolve xung đột các file Admin HTML
- Chọn phiên bản HTML hoàn chỉnh nhất từ nhánh `CongChese` / `master` và xóa sạch các dấu đánh dấu conflict `<<<<<<<`, `=======`, `>>>>>>>`.

### Bước 3: Đánh dấu đã giải quyết và hoàn tất Merge Commit
Chạy các lệnh:
```bash
git add .
git commit -m "Resolve merge conflicts between master and CongChese"
git push origin master
```

---
*Báo cáo được khởi tạo tự động để phục vụ rà soát trước khi xử lý conflict.*

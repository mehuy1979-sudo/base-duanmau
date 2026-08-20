<?php
// ==============================================================================
// BƯỚC QUAN TRỌNG: ĐẶT CODE TRUY VẤN DATABASE CỦA BẠN Ở ĐÂY
// ==============================================================================
// Lấy dữ liệu từ form POST của bạn
$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
$sort_price = isset($_POST['sort_price']) ? $_POST['sort_price'] : '';

// 1. Kết nối CSDL và truy vấn dữ liệu của bạn ở dưới dòng này.
// LƯU Ý: NHỚ LỌC CẢ THEO KEYWORD VÀ SẮP XẾP ORDER BY THEO $sort_price NẾU CÓ.
// XÓA HOẶC ẨN (//) CÁC DÒNG var_dump(), print_r() ĐANG IN RA MÀN HÌNH

/* 
Ví dụ code của bạn:
$sql = "SELECT * FROM products WHERE product_name LIKE '%$keyword%'";
if ($sort_price == 'asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort_price == 'desc') {
    $sql .= " ORDER BY price DESC";
}
// ... thực thi $sql và gán vào mảng $products ...
*/

// Giả sử dữ liệu được gán vào biến $products. 
if (!isset($products)) {
    $products = []; 
}
// ==============================================================================
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm <?= $keyword ? '- ' . htmlspecialchars($keyword) : '' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ----- CSS CƠ BẢN ----- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ----- HEADER ----- */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .logo img { height: 24px; }
        .main-menu { list-style: none; display: flex; gap: 30px; }
        .main-menu li { position: relative; }
        .main-menu a {
            text-decoration: none; color: #333; font-size: 15px;
            font-weight: 500; transition: color 0.3s;
        }
        .main-menu a:hover { color: #5580ff; }
        .badge-hot {
            position: absolute; top: -15px; right: -20px;
            background-color: #ff4757; color: white; font-size: 10px;
            padding: 2px 6px; border-radius: 10px; font-weight: bold;
        }
        .header-icons { display: flex; gap: 20px; align-items: center; }
        .icon-item { position: relative; cursor: pointer; font-size: 20px; color: #333; }
        .icon-badge {
            position: absolute; top: -8px; right: -10px; background-color: #5580ff;
            color: white; font-size: 10px; width: 16px; height: 16px;
            display: flex; justify-content: center; align-items: center; border-radius: 50%;
        }

        /* ----- SEARCH SECTION ----- */
        .search-overview { margin-bottom: 60px; }
        .search-overview h2 {
            font-size: 30px; font-weight: 800; margin-bottom: 10px;
            text-transform: uppercase;
        }
        .search-info { color: #888; margin-bottom: 30px; }

        /* ----- CSS BỔ SUNG CHO FORM CỦA BẠN ----- */
        .filter-tope-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e6e6e6;
            margin-bottom: 40px;
        }
        
        .form-control {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            width: 250px;
            max-width: 100%;
        }

        .form-control:focus {
            border-color: #5580ff;
        }

        button[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #5580ff;
        }

        /* Nút xóa có thể cho màu khác một chút */
        button[type="submit"]:last-child {
            background-color: #888;
        }
        button[type="submit"]:last-child:hover {
            background-color: #ff4757;
        }

        /* ----- PRODUCT GRID ----- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px 20px;
        }
        .product-item { text-align: center; transition: transform 0.3s; }
        .product-item:hover { transform: translateY(-5px); }
        .product-item img {
            width: 100%; height: 300px; object-fit: cover;
            border: 1px solid #f0f0f0; margin-bottom: 15px;
        }
        .product-item h4 {
            font-size: 16px; color: #333; font-weight: normal; margin-bottom: 8px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .product-item p.price { color: #5580ff; font-size: 16px; font-weight: bold; }
        .no-result {
            grid-column: 1 / -1; text-align: center; color: #888;
            font-size: 16px; padding: 40px 0; background-color: #fafafa; border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <header>
        <div class="logo">
            <a href="<?= BASE_URL ?? 'index.php' ?>"><img src="https://via.placeholder.com/100x30/ffffff/5580ff?text=IMG-LOGO" alt="Logo"></a>
        </div>
        
        <ul class="main-menu">
            <li><a href="<?= BASE_URL ?? 'index.php' ?>">Trang chủ</a></li>
            <li><a href="#">Sản Phẩm</a></li>
            <li>
                <a href="#">Giỏ hàng</a>
                <span class="badge-hot">HOT</span>
            </li>
            <li><a href="#">Danh Mục Yêu Thích</a></li>
            <li><a href="#">Liên Hệ</a></li>
        </ul>

        <div class="header-icons">
            <div class="icon-item"><i class="fas fa-search"></i></div>
            <div class="icon-item">
                <i class="fas fa-shopping-cart"></i>
                <span class="icon-badge">2</span>
            </div>
            <div class="icon-item">
                <i class="far fa-heart"></i>
                <span class="icon-badge">0</span>
            </div>
        </div>
    </header>

    <!-- Content: Tìm kiếm -->
    <section class="search-overview">
        
        <!-- BẮT ĐẦU: FORM CỦA BẠN (GIỮ NGUYÊN 100%) -->
        <form action="<?=BASE_URL.'?action=search'?> "method="POST" class="flex-w flex-l-m filter-tope-group m-tb-10" style="width: 100%;margin-top:100px;">
            <div class="m-r-20 m-tb-5">
                <input type="text" name="keyword" value="<?= htmlspecialchars($_POST['keyword'] ?? '') ?>" 
                        placeholder="Tên sản phẩm..." class="form-control">
            </div>

            <div class="m-r-20 m-tb-5">
                <select name="sort_price" class="form-control">
                    <option value="">-- Giá --</option>
                    <option value="asc" <?= (($_POST['sort_price'] ?? '') == 'asc') ? 'selected' : '' ?>>Tăng dần</option>
                    <option value="desc" <?= (($_POST['sort_price'] ?? '') == 'desc') ? 'selected' : '' ?>>Giảm dần</option>
                </select>
            </div>
            <button type="submit" class="flex-c-m stext-106 cl6 hov1 bor3 trans-04 m-r-10 m-tb-5">Lọc</button>
            <button type="submit" class="flex-c-m stext-106 cl6 hov1 bor3 trans-04 m-tb-5" onclick="this.form.reset();">Xóa</button>
        </form>
        <!-- KẾT THÚC: FORM CỦA BẠN -->

        <h2>KẾT QUẢ TÌM KIẾM</h2>
        <p class="search-info">
            <?php if(!empty($keyword)): ?>
                Đang hiển thị kết quả cho: <strong>"<?= htmlspecialchars($keyword) ?>"</strong>
            <?php else: ?>
                Tất cả sản phẩm
            <?php endif; ?>
        </p>

        <!-- Danh sách Sản phẩm -->
        <div class="product-grid">
            <?php 
            if(!empty($listproduct) && is_array($listproduct)): 
                foreach($listproduct as $product):
            ?>
                <div class="product-item">
                    <!-- Ảnh sản phẩm: Điều chỉnh đường dẫn thư mục ảnh -->
                    <img src="<?= BASE_ASSETS_UPLOADS .$product['image']?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    
                    <!-- Tên sản phẩm -->
                    <h4><?= htmlspecialchars($product['product_name']) ?></h4>
                    
                    <!-- Giá sản phẩm -->
                    <p class="price"><?= number_format((float)$product['price'], 0, ',', '.') ?> VNĐ</p>
                </div>
            <?php 
                endforeach;
            else: 
            ?>
                <!-- Báo lỗi nếu không có sản phẩm -->
                <div class="no-result">
                    <p><i class="fas fa-box-open" style="font-size: 30px; margin-bottom: 15px; color: #ccc;"></i></p>
                    <p>Không tìm thấy sản phẩm nào phù hợp với bộ lọc của bạn.</p>
                </div>
            <?php 
            endif; 
            ?>
        </div>
    </section>
</div>

</body>
</html>
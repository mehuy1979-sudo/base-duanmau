<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?= $title ?? 'So sánh sản phẩm - Bunny Wear' ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animate/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">
    <style>
        .compare-header-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            padding: 24px;
            margin-bottom: 30px;
        }
        .compare-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        }
        .compare-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            width: 20%;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
        }
        .compare-table td {
            width: 40%;
            vertical-align: middle;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 14.5px;
        }
        .compare-img {
            width: 100%;
            max-width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin: 0 auto;
            display: block;
        }
        .compare-price {
            font-size: 20px;
            font-weight: 800;
            color: #e11d48;
        }
        .compare-orig-price {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 14px;
            margin-left: 8px;
        }
        .tag-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin: 2px;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
        }
        .select-compare-box {
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            width: 100%;
        }
        .select-compare-box:focus {
            border-color: #717fe0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(113, 127, 224, 0.2);
        }
    </style>
</head>
<body class="animsition">

    <!-- Header -->
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">Khuyến mại hè giảm tới 20%</div>
                    <div class="right-top-bar flex-w h-full">
                        <a href="#" class="flex-c-m trans-04 p-lr-25">Trợ giúp & FAQs</a>
                        <a href="#" class="flex-c-m trans-04 p-lr-25">Tài khoản</a>
                        <a href="#" class="flex-c-m trans-04 p-lr-25">VI</a>
                        <a href="#" class="flex-c-m trans-04 p-lr-25">VND</a>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop how-shadow1">
                <nav class="limiter-menu-desktop container">
                    <a href="<?= BASE_URL ?>" class="logo">
                        <img src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg" alt="IMG-LOGO">
                    </a>

                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/product">Cửa hàng</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/wishlist">Danh Mục Yêu Thích</a></li>
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/compare">So sánh</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/admin/products">Admin</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <a href="<?= BASE_URL ?>?action=/product" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" title="Cửa hàng">
                            <i class="zmdi zmdi-search"></i>
                        </a>

                        <a href="<?= BASE_URL ?>?action=/wishlist" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-wishlist-noti" data-notify="<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>" title="Danh Mục Yêu Thích">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="container m-t-20">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                So sánh sản phẩm
            </span>
        </div>
    </div>

    <!-- Main Content: Product Comparison -->
    <section class="bg0 p-t-30 p-b-80">
        <div class="container">
            <div class="text-center p-b-30">
                <h1 class="ltext-105 cl5 font-weight-bold">SO SÁNH SẢN PHẨM</h1>
                <p class="stext-107 cl6 m-t-8">Chọn 2 sản phẩm để so sánh chi tiết về thông số, giá bán, biến thể và đặc điểm.</p>
            </div>

            <!-- Product Selection Bar -->
            <div class="compare-header-card">
                <div class="row align-items-center">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label class="font-weight-bold text-muted small d-block mb-1">SẢN PHẨM 1:</label>
                        <select class="select-compare-box" id="selectProduct1" onchange="changeCompareProduct()">
                            <?php foreach ($products as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= ($product1 && $product1['id'] == $p['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['product_name']) ?> (<?= number_format($p['price']) ?>đ)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        <span class="badge badge-pill badge-primary p-2 px-3 font-weight-bold" style="background: #717fe0; font-size: 14px;">VS</span>
                    </div>

                    <div class="col-md-5">
                        <label class="font-weight-bold text-muted small d-block mb-1">SẢN PHẨM 2:</label>
                        <select class="select-compare-box" id="selectProduct2" onchange="changeCompareProduct()">
                            <?php foreach ($products as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= ($product2 && $product2['id'] == $p['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['product_name']) ?> (<?= number_format($p['price']) ?>đ)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <?php if ($product1 && $product2): 
                $p1Img = !empty($product1['image']) ? BASE_URL . 'assets/uploads/' . $product1['image'] : BASE_URL . 'views/images/product-01.jpg';
                $p2Img = !empty($product2['image']) ? BASE_URL . 'assets/uploads/' . $product2['image'] : BASE_URL . 'views/images/product-02.jpg';
            ?>
            <div class="table-responsive">
                <table class="table compare-table mb-0">
                    <tbody>
                        <!-- Image Row -->
                        <tr>
                            <th>Hình ảnh</th>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product1['id'] ?>">
                                    <img src="<?= $p1Img ?>" class="compare-img" alt="<?= htmlspecialchars($product1['product_name']) ?>">
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product2['id'] ?>">
                                    <img src="<?= $p2Img ?>" class="compare-img" alt="<?= htmlspecialchars($product2['product_name']) ?>">
                                </a>
                            </td>
                        </tr>

                        <!-- Title Row -->
                        <tr>
                            <th>Tên sản phẩm</th>
                            <td>
                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product1['id'] ?>" class="mtext-105 cl2 font-weight-bold text-primary">
                                    <?= htmlspecialchars($product1['product_name']) ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product2['id'] ?>" class="mtext-105 cl2 font-weight-bold text-primary">
                                    <?= htmlspecialchars($product2['product_name']) ?>
                                </a>
                            </td>
                        </tr>

                        <!-- Price Row -->
                        <tr>
                            <th>Giá bán</th>
                            <td>
                                <span class="compare-price"><?= number_format($product1['price'] ?? 0, 0, ',', '.') ?> VND</span>
                                <?php if (!empty($product1['original_price']) && $product1['original_price'] > $product1['price']): ?>
                                <span class="compare-orig-price"><?= number_format($product1['original_price'], 0, ',', '.') ?> VND</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="compare-price"><?= number_format($product2['price'] ?? 0, 0, ',', '.') ?> VND</span>
                                <?php if (!empty($product2['original_price']) && $product2['original_price'] > $product2['price']): ?>
                                <span class="compare-orig-price"><?= number_format($product2['original_price'], 0, ',', '.') ?> VND</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Category & Brand -->
                        <tr>
                            <th>Danh mục</th>
                            <td><span class="badge text-bg-primary bg-primary text-white p-2"><?= htmlspecialchars($product1['category_name'] ?? 'Thời trang') ?></span></td>
                            <td><span class="badge text-bg-primary bg-primary text-white p-2"><?= htmlspecialchars($product2['category_name'] ?? 'Thời trang') ?></span></td>
                        </tr>
                        <tr>
                            <th>Thương hiệu</th>
                            <td><strong><?= htmlspecialchars($product1['brand'] ?? 'Chính hãng') ?></strong></td>
                            <td><strong><?= htmlspecialchars($product2['brand'] ?? 'Chính hãng') ?></strong></td>
                        </tr>
                        <tr>
                            <th>Mã SKU</th>
                            <td><code><?= htmlspecialchars($product1['sku'] ?? 'N/A') ?></code></td>
                            <td><code><?= htmlspecialchars($product2['sku'] ?? 'N/A') ?></code></td>
                        </tr>

                        <!-- Sizes -->
                        <tr>
                            <th>Kích cỡ (Sizes)</th>
                            <td>
                                <?php 
                                    $p1Sizes = array_filter(array_map('trim', explode(',', $product1['sizes'] ?? '')));
                                    if (!empty($p1Sizes)):
                                        foreach ($p1Sizes as $s): ?>
                                            <span class="tag-pill"><?= htmlspecialchars($s) ?></span>
                                        <?php endforeach;
                                    else: ?>
                                        <span class="text-muted">Tiêu chuẩn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $p2Sizes = array_filter(array_map('trim', explode(',', $product2['sizes'] ?? '')));
                                    if (!empty($p2Sizes)):
                                        foreach ($p2Sizes as $s): ?>
                                            <span class="tag-pill"><?= htmlspecialchars($s) ?></span>
                                        <?php endforeach;
                                    else: ?>
                                        <span class="text-muted">Tiêu chuẩn</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Colors -->
                        <tr>
                            <th>Màu sắc (Colors)</th>
                            <td>
                                <?php 
                                    $p1Colors = array_filter(array_map('trim', explode(',', $product1['colors'] ?? '')));
                                    if (!empty($p1Colors)):
                                        foreach ($p1Colors as $c): ?>
                                            <span class="tag-pill"><i class="fa fa-circle text-primary m-r-4"></i><?= htmlspecialchars($c) ?></span>
                                        <?php endforeach;
                                    else: ?>
                                        <span class="text-muted">Tiêu chuẩn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $p2Colors = array_filter(array_map('trim', explode(',', $product2['colors'] ?? '')));
                                    if (!empty($p2Colors)):
                                        foreach ($p2Colors as $c): ?>
                                            <span class="tag-pill"><i class="fa fa-circle text-primary m-r-4"></i><?= htmlspecialchars($c) ?></span>
                                        <?php endforeach;
                                    else: ?>
                                        <span class="text-muted">Tiêu chuẩn</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Stock -->
                        <tr>
                            <th>Tồn kho</th>
                            <td>
                                <span class="badge <?= ($product1['quantity'] ?? 0) > 0 ? 'badge-success bg-success' : 'badge-danger bg-danger' ?> text-white p-2">
                                    <?= ($product1['quantity'] ?? 0) > 0 ? 'Còn ' . intval($product1['quantity']) . ' sản phẩm' : 'Hết hàng' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= ($product2['quantity'] ?? 0) > 0 ? 'badge-success bg-success' : 'badge-danger bg-danger' ?> text-white p-2">
                                    <?= ($product2['quantity'] ?? 0) > 0 ? 'Còn ' . intval($product2['quantity']) . ' sản phẩm' : 'Hết hàng' ?>
                                </span>
                            </td>
                        </tr>

                        <!-- Description -->
                        <tr>
                            <th>Mô tả chi tiết</th>
                            <td>
                                <div class="stext-102 cl6" style="max-height: 200px; overflow-y: auto; line-height: 1.6;">
                                    <?= !empty($product1['description']) ? $product1['description'] : '<p class="text-muted">Chưa có mô tả chi tiết.</p>' ?>
                                </div>
                            </td>
                            <td>
                                <div class="stext-102 cl6" style="max-height: 200px; overflow-y: auto; line-height: 1.6;">
                                    <?= !empty($product2['description']) ? $product2['description'] : '<p class="text-muted">Chưa có mô tả chi tiết.</p>' ?>
                                </div>
                            </td>
                        </tr>

                        <!-- Action Buttons -->
                        <tr>
                            <th>Thao tác</th>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product1['id'] ?>" class="btn btn-sm btn-primary px-3 font-weight-bold">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product2['id'] ?>" class="btn btn-sm btn-primary px-3 font-weight-bold">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center p-t-50 p-b-50">
                <p class="stext-107 cl6">Vui lòng chọn 2 sản phẩm để bắt đầu so sánh.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container text-center">
            <p class="stext-107 cl6">&copy; <?= date('Y') ?> Bunny Wear. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>
    <script>
        function changeCompareProduct() {
            const p1 = document.getElementById('selectProduct1').value;
            const p2 = document.getElementById('selectProduct2').value;
            window.location.href = `<?= BASE_URL ?>?action=/compare&p1=${p1}&p2=${p2}`;
        }
    </script>
</body>
</html>

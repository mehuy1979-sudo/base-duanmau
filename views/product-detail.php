<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?= $title ?? 'Chi tiết sản phẩm - Bunny Wear' ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animate/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/slick/slick.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/MagnificPopup/magnific-popup.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">
    <style>
        .product-gallery-main img {
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            border-radius: 8px;
        }
        .gallery-thumb-item {
            cursor: pointer;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: all .2s;
        }
        .gallery-thumb-item.active, .gallery-thumb-item:hover {
            border-color: #717fe0;
        }
        .gallery-thumb-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
        .variant-pill {
            display: inline-block;
            padding: 6px 14px;
            margin: 0 6px 6px 0;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .16s ease;
            background: #fff;
            color: #333;
        }
        .variant-pill:hover {
            border-color: #717fe0;
            color: #717fe0;
        }
        .variant-pill.active {
            border-color: #717fe0;
            background: #717fe0;
            color: #fff;
        }
        .original-price-tag {
            text-decoration: line-through;
            color: #888;
            font-size: 16px;
            margin-left: 10px;
        }
        .stock-badge {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>
<body class="animsition">

    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
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
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/product">Cửa hàng</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/compare&p1=<?= $product['id'] ?? 0 ?>">So sánh</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/admin/products">Admin</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
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
            <a href="<?= BASE_URL ?>?action=/product" class="stext-109 cl8 hov-cl1 trans-04">
                <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                <?= htmlspecialchars($product['product_name'] ?? 'Chi tiết') ?>
            </span>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="sec-product-detail bg0 p-t-40 p-b-60">
        <div class="container">
            <div class="row">
                <!-- Gallery Col -->
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="product-gallery-main mb-3">
                            <?php 
                                $mainImg = !empty($product['image']) ? BASE_URL . 'assets/uploads/' . $product['image'] : BASE_URL . 'views/images/product-01.jpg';
                            ?>
                            <a href="<?= $mainImg ?>" class="gallery-lb-item">
                                <img id="productMainDisplayImg" src="<?= $mainImg ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            </a>
                        </div>

                        <!-- Thumbnails list -->
                        <div class="d-flex flex-wrap gap-2" id="galleryThumbList">
                            <div class="gallery-thumb-item active" onclick="changeMainImage('<?= $mainImg ?>', this)">
                                <img src="<?= $mainImg ?>" alt="Main Thumb">
                            </div>
                            <?php if (!empty($product['images'])): ?>
                                <?php foreach ($product['images'] as $img): 
                                    $thumbSrc = BASE_URL . 'assets/uploads/' . $img['image'];
                                ?>
                                <div class="gallery-thumb-item" onclick="changeMainImage('<?= $thumbSrc ?>', this)">
                                    <img src="<?= $thumbSrc ?>" alt="Gallery Thumb">
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Info Col -->
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h1 class="mtext-105 cl2 js-name-detail p-b-14" style="font-size: 26px;">
                            <?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm') ?>
                        </h1>

                        <!-- Price Section -->
                        <div class="p-b-14">
                            <span class="mtext-106 cl2 text-danger font-weight-bold" id="displayProductPrice" style="font-size: 22px;">
                                <?= number_format($product['price'] ?? 0, 0, ',', '.') ?> VND
                            </span>
                            <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                            <span class="original-price-tag" id="displayOriginalPrice">
                                <?= number_format($product['original_price'], 0, ',', '.') ?> VND
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="stext-102 cl3 p-b-14">
                            <p class="mb-1"><strong>Mã sản phẩm:</strong> <?= htmlspecialchars($product['sku'] ?? 'N/A') ?></p>
                            <p class="mb-1"><strong>Thương hiệu:</strong> <?= htmlspecialchars($product['brand'] ?? 'Chính hãng') ?></p>
                            <p class="mb-1"><strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Thời trang') ?></p>
                            <p class="mb-1">
                                <strong>Tình trạng:</strong> 
                                <span class="badge badge-success bg-success text-white" id="displayStockStatus">
                                    Còn <?= intval($product['quantity'] ?? 0) ?> sản phẩm
                                </span>
                            </p>
                        </div>

                        <!-- Variant Selectors from DB -->
                        <div class="p-t-20 border-top">
                            <?php 
                                $variants = $product['variants'] ?? [];
                                $sizes = [];
                                $colors = [];
                                foreach ($variants as $v) {
                                    if (!empty($v['size']) && !in_array($v['size'], $sizes)) $sizes[] = $v['size'];
                                    if (!empty($v['color']) && !in_array($v['color'], $colors)) $colors[] = $v['color'];
                                }
                            ?>

                            <!-- Size selection -->
                            <?php if (!empty($sizes)): ?>
                            <div class="p-b-15">
                                <label class="stext-102 cl3 font-weight-bold d-block mb-2">Chọn kích cỡ (Size):</label>
                                <div id="sizeOptionsGroup">
                                    <?php foreach ($sizes as $idx => $s): ?>
                                    <span class="variant-pill <?= $idx === 0 ? 'active' : '' ?>" data-size="<?= htmlspecialchars($s) ?>" onclick="selectSize('<?= htmlspecialchars($s) ?>', this)">
                                        <?= htmlspecialchars($s) ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Color selection -->
                            <?php if (!empty($colors)): ?>
                            <div class="p-b-15">
                                <label class="stext-102 cl3 font-weight-bold d-block mb-2">Chọn màu sắc (Color):</label>
                                <div id="colorOptionsGroup">
                                    <?php foreach ($colors as $idx => $c): ?>
                                    <span class="variant-pill <?= $idx === 0 ? 'active' : '' ?>" data-color="<?= htmlspecialchars($c) ?>" onclick="selectColor('<?= htmlspecialchars($c) ?>', this)">
                                        <?= htmlspecialchars($c) ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Quantity and Add to Cart -->
                            <form id="addToCartForm" method="POST" action="<?= BASE_URL ?>?action=/cart/add" class="flex-w flex-m p-t-15">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?? 0 ?>">
                                <input type="hidden" name="size" id="cartSizeInput" value="<?= htmlspecialchars($sizes[0] ?? '') ?>">
                                <input type="hidden" name="color" id="cartColorInput" value="<?= htmlspecialchars($colors[0] ?? '') ?>">

                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>
                                    <input class="mtext-104 cl3 txt-center num-product" type="number" id="cartQuantity" name="quantity" value="1" min="1" max="<?= max(1, intval($product['quantity'] ?? 10)) ?>">
                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Thêm vào giỏ
                                </button>

                                <a href="<?= BASE_URL ?>?action=/compare&p1=<?= $product['id'] ?>" class="flex-c-m stext-101 cl2 size-101 bg0 bor1 hov-btn1 p-lr-15 trans-04 m-l-10" style="border: 1px solid #717fe0; color: #717fe0;">
                                    <i class="fa fa-columns m-r-6"></i> So sánh
                                </a>

                                <button type="button" id="btnToggleWishlistDetail" onclick="toggleWishlistDetail(<?= $product['id'] ?? 0 ?>)" class="flex-c-m stext-101 size-101 bor1 hov-btn1 p-lr-15 trans-04 m-l-10 <?= !empty($isFav) ? 'bg-danger text-white' : 'bg0 text-danger' ?>" style="border: 1px solid #e11d48;" title="Thêm vào Danh Mục Yêu Thích">
                                    <i class="zmdi zmdi-favorite m-r-6"></i> <span id="wishlistBtnLabel"><?= !empty($isFav) ? 'Đã yêu thích' : 'Yêu thích' ?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs: Description & Specifications -->
            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả sản phẩm</a>
                        </li>
                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Bảng biến thể & Tồn kho</a>
                        </li>
                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá (<?= $ratingSummary['total'] ?? 0 ?>)</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-30">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <div class="stext-102 cl6" style="line-height: 1.8; font-size: 15px;">
                                    <?php if (!empty($product['description'])): ?>
                                        <?= $product['description'] ?>
                                    <?php else: ?>
                                        <p>Sản phẩm thời trang cao cấp từ Bunny Wear với chất liệu bền đẹp, form dáng hiện đại, phù hợp cho mọi phong cách thường ngày và sự kiện.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Variant Table Tab -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-7 m-lr-auto">
                                    <?php if (!empty($variants)): ?>
                                    <table class="table table-bordered table-striped text-center">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Kích cỡ</th>
                                                <th>Màu sắc</th>
                                                <th>Giá gốc</th>
                                                <th>Giá khuyến mãi</th>
                                                <th>Tồn kho</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($variants as $v): ?>
                                            <tr>
                                                <td class="font-weight-bold"><?= htmlspecialchars($v['size'] ?: 'Tiêu chuẩn') ?></td>
                                                <td><?= htmlspecialchars($v['color'] ?: 'Tiêu chuẩn') ?></td>
                                                <td><?= number_format($v['original_price'] ?? 0, 0, ',', '.') ?>đ</td>
                                                <td class="text-danger font-weight-bold"><?= number_format($v['sale_price'] ?? 0, 0, ',', '.') ?>đ</td>
                                                <td><span class="badge badge-info bg-primary text-white"><?= intval($v['quantity'] ?? 0) ?></span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                    <p class="text-center text-muted">Sản phẩm có 1 phân loại chuẩn với tổng tồn kho <?= intval($product['quantity'] ?? 0) ?>.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-7 m-lr-auto">
                                    <!-- Rating summary -->
                                    <div class="p-b-20 flex-w flex-m">
                                        <span class="mtext-105 cl2 font-weight-bold m-r-15" style="font-size: 32px;"><?= $ratingSummary['average'] ?? 5.0 ?></span>
                                        <div>
                                            <div class="fs-18 cl11">
                                                <?php
                                                    $avgStars = round($ratingSummary['average'] ?? 5);
                                                    for ($s = 1; $s <= 5; $s++):
                                                ?>
                                                    <i class="zmdi zmdi-star <?= $s <= $avgStars ? 'text-warning' : 'cl8' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="stext-107 cl6"><?= $ratingSummary['total'] ?? 0 ?> đánh giá</span>
                                        </div>
                                    </div>

                                    <!-- Existing reviews -->
                                    <div class="p-b-30" id="productReviewsList">
                                        <?php if (!empty($reviews)): ?>
                                            <?php foreach ($reviews as $r): ?>
                                            <div class="flex-w flex-t p-b-20 border-bottom">
                                                <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                    <img src="<?= BASE_URL ?>views/images/avatar-01.jpg" alt="AVATAR">
                                                </div>
                                                <div class="size-207">
                                                    <div class="flex-w flex-sb-m p-b-5">
                                                        <span class="mtext-107 cl2 p-r-20"><?= htmlspecialchars($r['user_name']) ?></span>
                                                        <span class="fs-18 cl11">
                                                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                                                <i class="zmdi zmdi-star <?= $s <= intval($r['rating']) ? 'text-warning' : 'cl8' ?>"></i>
                                                            <?php endfor; ?>
                                                        </span>
                                                    </div>
                                                    <p class="stext-102 cl6"><?= htmlspecialchars($r['comment']) ?></p>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="stext-102 cl6">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Add review form -->
                                    <div class="p-t-20 border-top">
                                        <h4 class="mtext-105 cl2 p-b-20">Viết đánh giá của bạn</h4>
                                        <div class="row">
                                            <div class="col-sm-6 p-b-15">
                                                <label class="stext-102 cl3 d-block mb-2">Họ tên</label>
                                                <input type="text" id="reviewUserName" class="form-control" placeholder="Họ tên của bạn">
                                            </div>
                                            <div class="col-sm-6 p-b-15">
                                                <label class="stext-102 cl3 d-block mb-2">Email (không bắt buộc)</label>
                                                <input type="email" id="reviewUserEmail" class="form-control" placeholder="email@example.com">
                                            </div>
                                            <div class="col-sm-4 p-b-15">
                                                <label class="stext-102 cl3 d-block mb-2">Số sao</label>
                                                <select id="reviewRating" class="form-control">
                                                    <option value="5">5 - Tuyệt vời</option>
                                                    <option value="4">4 - Tốt</option>
                                                    <option value="3">3 - Bình thường</option>
                                                    <option value="2">2 - Không hài lòng</option>
                                                    <option value="1">1 - Rất tệ</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 p-b-15">
                                                <label class="stext-102 cl3 d-block mb-2">Nội dung đánh giá</label>
                                                <textarea id="reviewComment" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" onclick="submitProductReview(<?= $product['id'] ?>)">
                                                    Gửi đánh giá
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <?php if (!empty($relatedProducts)): ?>
            <div class="p-t-50">
                <div class="sec-banner bg0 p-t-20 p-b-20">
                    <h3 class="ltext-105 cl5 txt-center respon1 p-b-30">
                        Sản phẩm liên quan
                    </h3>
                    <div class="row">
                        <?php foreach ($relatedProducts as $rel): 
                            $relImg = !empty($rel['image']) ? BASE_URL . 'assets/uploads/' . $rel['image'] : BASE_URL . 'views/images/product-01.jpg';
                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="<?= $relImg ?>" alt="<?= htmlspecialchars($rel['product_name']) ?>" style="height: 280px; object-fit: cover;">
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $rel['id'] ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                        Xem chi tiết
                                    </a>
                                </div>
                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l">
                                        <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $rel['id'] ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            <?= htmlspecialchars($rel['product_name']) ?>
                                        </a>
                                        <span class="stext-105 cl3 text-danger font-weight-bold">
                                            <?= number_format($rel['price'] ?? 0, 0, ',', '.') ?> VND
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">Danh Mục</h4>
                    <ul>
                        <li class="p-b-10"><a href="<?= BASE_URL ?>?action=/product" class="stext-107 cl7 hov-cl1 trans-04">Áo Nam / Nữ</a></li>
                        <li class="p-b-10"><a href="<?= BASE_URL ?>?action=/product" class="stext-107 cl7 hov-cl1 trans-04">Quần & Phụ Kiện</a></li>
                        <li class="p-b-10"><a href="<?= BASE_URL ?>?action=/product" class="stext-107 cl7 hov-cl1 trans-04">Giày Dép</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">Hỗ trợ</h4>
                    <ul>
                        <li class="p-b-10"><a href="#" class="stext-107 cl7 hov-cl1 trans-04">Tra cứu đơn hàng</a></li>
                        <li class="p-b-10"><a href="#" class="stext-107 cl7 hov-cl1 trans-04">Chính sách đổi trả</a></li>
                        <li class="p-b-10"><a href="#" class="stext-107 cl7 hov-cl1 trans-04">Vận chuyển & Giao nhận</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">Admin</h4>
                    <p class="stext-107 cl7"><a href="<?= BASE_URL ?>?action=/admin/products" class="text-white">Quản trị viên & Kho hàng</a></p>
                </div>
            </div>
            <div class="p-t-40">
                <p class="stext-107 cl6 txt-center">&copy; <?= date('Y') ?> Bunny Wear. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top"><i class="zmdi zmdi-chevron-up"></i></span>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/select2/select2.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/sweetalert/sweetalert.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>

    <script>
        const PRODUCT_VARIANTS = <?= json_encode($product['variants'] ?? []) ?>;
        let selectedSize = '<?= $sizes[0] ?? '' ?>';
        let selectedColor = '<?= $colors[0] ?? '' ?>';

        function changeMainImage(src, element) {
            document.getElementById('productMainDisplayImg').src = src;
            document.querySelectorAll('.gallery-thumb-item').forEach(el => el.classList.remove('active'));
            if (element) element.classList.add('active');
        }

        function selectSize(size, element) {
            selectedSize = size;
            const sizeInput = document.getElementById('cartSizeInput');
            if (sizeInput) sizeInput.value = size;
            document.querySelectorAll('#sizeOptionsGroup .variant-pill').forEach(el => el.classList.remove('active'));
            element.classList.add('active');

            if (PRODUCT_VARIANTS && PRODUCT_VARIANTS.length > 0) {
                const validColorsForSize = PRODUCT_VARIANTS
                    .filter(v => !size || v.size === size)
                    .map(v => v.color)
                    .filter(Boolean);

                const colorPills = document.querySelectorAll('#colorOptionsGroup .variant-pill');
                let hasActive = false;
                colorPills.forEach(pill => {
                    const c = pill.dataset.color;
                    if (validColorsForSize.length > 0 && !validColorsForSize.includes(c)) {
                        pill.style.opacity = '0.35';
                        pill.style.pointerEvents = 'none';
                        pill.classList.remove('active');
                    } else {
                        pill.style.opacity = '1';
                        pill.style.pointerEvents = 'auto';
                        if (c === selectedColor) {
                            pill.classList.add('active');
                            hasActive = true;
                        }
                    }
                });

                if (!hasActive && validColorsForSize.length > 0) {
                    const firstValidPill = Array.from(colorPills).find(p => validColorsForSize.includes(p.dataset.color));
                    if (firstValidPill) {
                        selectedColor = firstValidPill.dataset.color;
                        firstValidPill.classList.add('active');
                    }
                }
            }

            const colorInput = document.getElementById('cartColorInput');
            if (colorInput) colorInput.value = selectedColor;

            updateVariantInfo();
        }

        function selectColor(color, element) {
            selectedColor = color;
            const colorInput = document.getElementById('cartColorInput');
            if (colorInput) colorInput.value = color;
            document.querySelectorAll('#colorOptionsGroup .variant-pill').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
            updateVariantInfo();
        }

        function updateVariantInfo() {
            if (!PRODUCT_VARIANTS || PRODUCT_VARIANTS.length === 0) return;
            const matched = PRODUCT_VARIANTS.find(v => 
                (!selectedSize || v.size === selectedSize) && 
                (!selectedColor || v.color === selectedColor)
            );

            if (matched) {
                const sale = parseFloat(matched.sale_price) || 0;
                const orig = parseFloat(matched.original_price) || 0;
                const qty  = parseInt(matched.quantity) || 0;

                document.getElementById('displayProductPrice').textContent = sale.toLocaleString('vi-VN') + ' VND';
                const origEl = document.getElementById('displayOriginalPrice');
                if (origEl) {
                    if (orig > sale) {
                        origEl.textContent = orig.toLocaleString('vi-VN') + ' VND';
                        origEl.style.display = 'inline';
                    } else {
                        origEl.style.display = 'none';
                    }
                }
                const stockEl = document.getElementById('displayStockStatus');
                if (stockEl) {
                    if (qty > 0) {
                        stockEl.className = 'badge badge-success bg-success text-white';
                        stockEl.textContent = `Còn ${qty} sản phẩm`;
                    } else {
                        stockEl.className = 'badge badge-danger bg-danger text-white';
                        stockEl.textContent = 'Tạm hết hàng';
                    }
                }
                document.getElementById('cartQuantity').max = qty > 0 ? qty : 1;
            }
        }

        // Initialize variant display
        updateVariantInfo();

        // Wishlist toggle (từ base CongChese)
        function toggleWishlistDetail(productId) {
            $.ajax({
                url: '<?= BASE_URL ?>?action=/wishlist&ajax=toggle',
                type: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const $btn = $('#btnToggleWishlistDetail');
                        if (res.action === 'added') {
                            $btn.removeClass('bg0 text-danger').addClass('bg-danger text-white');
                            $('#wishlistBtnLabel').text('Đã yêu thích');
                        } else {
                            $btn.removeClass('bg-danger text-white').addClass('bg0 text-danger');
                            $('#wishlistBtnLabel').text('Yêu thích');
                        }
                        $('.js-wishlist-noti').attr('data-notify', res.count);
                        swal("Danh Mục Yêu Thích", res.message, "success");
                    }
                },
                error: function() {
                    swal("Lỗi", "Không thể cập nhật Danh Mục Yêu Thích. Vui lòng thử lại!", "error");
                }
            });
        }

        // Đánh giá sản phẩm (từ base CongChese)
        function submitProductReview(productId) {
            const userName = $('#reviewUserName').val().trim();
            const userEmail = $('#reviewUserEmail').val().trim();
            const rating = $('#reviewRating').val();
            const comment = $('#reviewComment').val().trim();

            if (!userName || !comment) {
                swal("Thiếu thông tin", "Vui lòng điền đầy đủ Họ tên và Nội dung đánh giá.", "warning");
                return;
            }

            $.ajax({
                url: '<?= BASE_URL ?>?action=/product-detail&id=' + productId + '&ajax=add_review',
                type: 'POST',
                data: {
                    product_id: productId,
                    user_name: userName,
                    user_email: userEmail,
                    rating: rating,
                    comment: comment
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const stars = '<i class="zmdi zmdi-star text-warning"></i>'.repeat(res.review.rating);
                        const reviewHtml = `
                            <div class="flex-w flex-t p-b-20 border-bottom">
                                <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                    <img src="<?= BASE_URL ?>views/images/avatar-01.jpg" alt="AVATAR">
                                </div>
                                <div class="size-207">
                                    <div class="flex-w flex-sb-m p-b-5">
                                        <span class="mtext-107 cl2 p-r-20">${res.review.user_name}</span>
                                        <span class="fs-18 cl11">${stars}</span>
                                    </div>
                                    <p class="stext-102 cl6">${res.review.comment}</p>
                                </div>
                            </div>
                        `;
                        $('#productReviewsList').prepend(reviewHtml);
                        $('#reviewUserName, #reviewUserEmail, #reviewComment').val('');
                        swal("Cảm ơn bạn!", res.message, "success");
                    } else {
                        swal("Không thành công", res.message, "error");
                    }
                },
                error: function() {
                    swal("Lỗi", "Không thể gửi đánh giá. Vui lòng thử lại!", "error");
                }
            });
        }
    </script>
</body>
</html>

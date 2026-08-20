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
        /* Review and Rating Styles */
        .rating-overview-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }
        .big-rating-number {
            font-size: 48px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }
        .star-rating-select {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 4px;
        }
        .star-rating-select input {
            display: none;
        }
        .star-rating-select label {
            font-size: 28px;
            color: #cbd5e1;
            cursor: pointer;
            transition: color 0.15s ease;
            margin-bottom: 0;
        }
        .star-rating-select label:hover,
        .star-rating-select label:hover ~ label,
        .star-rating-select input:checked ~ label {
            color: #f59e0b;
        }
        .user-initial-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #717fe0, #a855f7);
            color: #fff;
            font-weight: 700;
            font-size: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(113, 127, 224, 0.3);
        }
        .review-item-card {
            padding: 18px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .review-item-card:last-child {
            border-bottom: none;
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
                            <li><a href="<?= BASE_URL ?>?action=/wishlist">Danh Mục Yêu Thích</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/compare&p1=<?= $product['id'] ?? 0 ?>">So sánh</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/admin/products">Admin</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <a href="<?= BASE_URL ?>?action=/product" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" title="Tìm kiếm / Cửa hàng">
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
                            <div class="flex-w flex-m p-t-15">
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>
                                    <input class="mtext-104 cl3 txt-center num-product" type="number" id="cartQuantity" name="num-product" value="1" min="1" max="<?= max(1, intval($product['quantity'] ?? 10)) ?>">
                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail" onclick="handleAddToCart()">
                                    Thêm vào giỏ
                                </button>

                                <a href="<?= BASE_URL ?>?action=/compare&p1=<?= $product['id'] ?>" class="flex-c-m stext-101 cl2 size-101 bg0 bor1 hov-btn1 p-lr-15 trans-04 m-l-10" style="border: 1px solid #717fe0; color: #717fe0;" title="So sánh sản phẩm">
                                    <i class="fa fa-columns m-r-6"></i> So sánh
                                </a>

                                <?php $isFav = in_array($product['id'] ?? 0, $_SESSION['wishlist'] ?? []); ?>
                                <button type="button" id="btnToggleWishlistDetail" onclick="toggleWishlistDetail(<?= $product['id'] ?? 0 ?>)" class="flex-c-m stext-101 size-101 bor1 hov-btn1 p-lr-15 trans-04 m-l-10 <?= $isFav ? 'bg-danger text-white' : 'bg0 text-danger' ?>" style="border: 1px solid #e11d48;" title="Thêm vào Danh Mục Yêu Thích">
                                    <i class="zmdi <?= $isFav ? 'zmdi-favorite' : 'zmdi-favorite-outline' ?> m-r-6"></i> <span id="wishlistDetailText"><?= $isFav ? 'Đã yêu thích' : 'Yêu thích' ?></span>
                                </button>
                            </div>
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
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá (<span id="totalReviewsCount"><?= $ratingSummary['total'] ?? count($reviews ?? []) ?></span>)</a>
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
                                <div class="col-sm-10 col-md-8 col-lg-8 m-lr-auto">
                                    
                                    <!-- Rating Overview -->
                                    <?php 
                                        $avgScore = $ratingSummary['average'] ?? 5.0;
                                        $totalReviews = $ratingSummary['total'] ?? count($reviews ?? []);
                                        $breakdown = $ratingSummary['breakdown'] ?? [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
                                        $pcts = $ratingSummary['percentages'] ?? [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
                                    ?>
                                    <div class="rating-overview-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 text-center border-right-md mb-4 mb-md-0">
                                                <div class="big-rating-number text-primary" id="avgScoreDisplay"><?= number_format($avgScore, 1) ?></div>
                                                <div class="fs-18 text-warning m-tb-6">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fa <?= $i <= round($avgScore) ? 'fa-star text-warning' : 'fa-star-o text-muted' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <div class="stext-107 cl6">
                                                    Dựa trên <strong id="totalReviewsCountText"><?= $totalReviews ?></strong> lượt đánh giá
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <?php for ($s = 5; $s >= 1; $s--): ?>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="stext-108 cl6 font-weight-bold" style="width: 35px;"><?= $s ?> <i class="fa fa-star text-warning"></i></span>
                                                    <div class="progress flex-grow-1 mx-2" style="height: 8px; border-radius: 4px; background: #e2e8f0;">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pcts[$s] ?? 0 ?>%;"></div>
                                                    </div>
                                                    <span class="stext-108 text-muted" style="width: 35px; text-align: right;"><?= $breakdown[$s] ?? 0 ?></span>
                                                </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reviews List -->
                                    <div class="p-b-30">
                                        <h4 class="mtext-109 cl2 p-b-20 font-weight-bold" style="font-size: 19px;">
                                            Khách hàng nhận xét
                                        </h4>

                                        <div id="reviewsListContainer">
                                            <?php if (!empty($reviews)): ?>
                                                <?php foreach ($reviews as $rev): ?>
                                                <?php 
                                                    $rInitial = mb_substr($rev['user_name'] ?? 'K', 0, 1, 'UTF-8');
                                                    $rScore = intval($rev['rating'] ?? 5);
                                                ?>
                                                <div class="review-item-card d-flex">
                                                    <div class="user-initial-avatar m-r-16 flex-shrink-0">
                                                        <?= $rInitial ?>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                                                            <strong class="mtext-107 cl2"><?= htmlspecialchars($rev['user_name']) ?></strong>
                                                            <span class="text-warning fs-14">
                                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                                    <i class="fa <?= $j <= $rScore ? 'fa-star text-warning' : 'fa-star-o text-muted' ?>"></i>
                                                                <?php endfor; ?>
                                                            </span>
                                                        </div>
                                                        <small class="text-muted d-block mb-2">
                                                            <i class="fa fa-clock-o m-r-4"></i> <?= date('d/m/Y H:i', strtotime($rev['created_at'])) ?>
                                                        </small>
                                                        <p class="stext-102 cl6 mb-0" style="font-size: 14.5px; line-height: 1.6;">
                                                            <?= nl2br(htmlspecialchars($rev['comment'])) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-4 text-muted" id="noReviewsNotice">
                                                    <i class="fa fa-commenting-o fa-2x mb-2 d-block text-muted"></i>
                                                    Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên nhận xét!
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Add Review Form -->
                                    <div class="bor10 p-all-25 bg-light" style="border-radius: 12px;">
                                        <h5 class="mtext-108 cl2 p-b-15 font-weight-bold">
                                            Viết đánh giá của bạn
                                        </h5>

                                        <form id="formAddReview" onsubmit="handleReviewSubmit(event)">
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?? 0 ?>">
                                            
                                            <!-- Star Picker -->
                                            <div class="flex-w flex-m p-b-15 align-items-center">
                                                <span class="stext-102 cl3 m-r-16 font-weight-bold">Đánh giá sao:</span>
                                                <div class="star-rating-select">
                                                    <input type="radio" id="star5" name="rating" value="5" checked />
                                                    <label for="star5" title="5 sao"><i class="fa fa-star"></i></label>
                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label for="star4" title="4 sao"><i class="fa fa-star"></i></label>
                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label for="star3" title="3 sao"><i class="fa fa-star"></i></label>
                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label for="star2" title="2 sao"><i class="fa fa-star"></i></label>
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label for="star1" title="1 sao"><i class="fa fa-star"></i></label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6 p-b-15">
                                                    <label class="stext-102 cl3 font-weight-bold" for="reviewName">Họ và tên <span class="text-danger">*</span></label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-15 bg0 w-full" id="reviewName" type="text" name="user_name" placeholder="Nhập tên của bạn..." required>
                                                </div>

                                                <div class="col-sm-6 p-b-15">
                                                    <label class="stext-102 cl3 font-weight-bold" for="reviewEmail">Email</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-15 bg0 w-full" id="reviewEmail" type="email" name="user_email" placeholder="example@email.com">
                                                </div>

                                                <div class="col-12 p-b-20">
                                                    <label class="stext-102 cl3 font-weight-bold" for="reviewComment">Nội dung đánh giá <span class="text-danger">*</span></label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-all-15 bg0 w-full" id="reviewComment" name="comment" rows="4" placeholder="Chia sẻ cảm nhận về chất lượng sản phẩm, form dáng, dịch vụ giao hàng..." required></textarea>
                                                </div>
                                            </div>

                                            <button type="submit" id="btnSubmitReview" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 font-weight-bold">
                                                <i class="fa fa-paper-plane m-r-8"></i> Gửi đánh giá ngay
                                            </button>
                                        </form>
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

            updateVariantInfo();
        }

        function selectColor(color, element) {
            selectedColor = color;
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

        function handleAddToCart() {
            const productName = <?= json_encode($product['product_name'] ?? 'Sản phẩm') ?>;
            const qty = document.getElementById('cartQuantity').value;
            const variantText = (selectedSize ? 'Size: ' + selectedSize : '') + (selectedColor ? ' - Màu: ' + selectedColor : '');
            swal(productName, "Đã thêm " + qty + " sản phẩm (" + variantText + ") vào giỏ hàng thành công!", "success");
        }

        function toggleWishlistDetail(productId) {
            if (!productId) return;
            const productName = <?= json_encode($product['product_name'] ?? 'Sản phẩm') ?>;

            $.ajax({
                url: '<?= BASE_URL ?>?action=/wishlist&ajax=toggle',
                type: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const $btn = $('#btnToggleWishlistDetail');
                        const $icon = $btn.find('i');
                        const $text = $('#wishlistDetailText');

                        if (res.action === 'added') {
                            $btn.removeClass('bg0 text-danger').addClass('bg-danger text-white');
                            $icon.removeClass('zmdi-favorite-outline').addClass('zmdi-favorite');
                            $text.text('Đã yêu thích');
                            swal(productName, "Đã thêm vào Danh Mục Yêu Thích!", "success");
                        } else {
                            $btn.removeClass('bg-danger text-white').addClass('bg0 text-danger');
                            $icon.removeClass('zmdi-favorite').addClass('zmdi-favorite-outline');
                            $text.text('Yêu thích');
                            swal(productName, "Đã bỏ khỏi Danh Mục Yêu Thích!", "info");
                        }
                        $('.js-wishlist-noti').attr('data-notify', res.count);
                    }
                },
                error: function() {
                    swal("Lỗi", "Không thể kết nối máy chủ.", "error");
                }
            });
        }

        function handleReviewSubmit(e) {
            e.preventDefault();
            const $form = $('#formAddReview');
            const $btn = $('#btnSubmitReview');
            const formData = $form.serialize();

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin m-r-8"></i> Đang gửi...');

            $.ajax({
                url: '<?= BASE_URL ?>?action=/product-detail&id=<?= $product['id'] ?? 0 ?>&ajax=add_review',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-8"></i> Gửi đánh giá ngay');
                    if (res.success) {
                        $('#noReviewsNotice').remove();
                        const r = res.review;
                        const initial = r.user_name ? r.user_name.charAt(0).toUpperCase() : 'K';
                        
                        let starsHtml = '';
                        for (let j = 1; j <= 5; j++) {
                            starsHtml += `<i class="fa ${j <= r.rating ? 'fa-star text-warning' : 'fa-star-o text-muted'}"></i> `;
                        }

                        const newReviewHtml = `
                            <div class="review-item-card d-flex animate__animated animate__fadeIn">
                                <div class="user-initial-avatar m-r-16 flex-shrink-0">
                                    ${initial}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                                        <strong class="mtext-107 cl2">${r.user_name}</strong>
                                        <span class="text-warning fs-14">
                                            ${starsHtml}
                                        </span>
                                    </div>
                                    <small class="text-muted d-block mb-2">
                                        <i class="fa fa-clock-o m-r-4"></i> ${r.created_at}
                                    </small>
                                    <p class="stext-102 cl6 mb-0" style="font-size: 14.5px; line-height: 1.6;">
                                        ${r.comment.replace(/\n/g, '<br>')}
                                    </p>
                                </div>
                            </div>
                        `;

                        $('#reviewsListContainer').prepend(newReviewHtml);

                        if (res.summary) {
                            $('#totalReviewsCount').text(res.summary.total);
                            $('#totalReviewsCountText').text(res.summary.total);
                            $('#avgScoreDisplay').text(Number(res.summary.average).toFixed(1));
                        }

                        $form[0].reset();
                        $('#star5').prop('checked', true);

                        swal("Cảm ơn bạn!", res.message, "success");
                    } else {
                        swal("Thông báo", res.message || "Không thể gửi đánh giá.", "warning");
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-8"></i> Gửi đánh giá ngay');
                    swal("Lỗi", "Không thể kết nối máy chủ.", "error");
                }
            });
        }

        // Initialize variant display
        updateVariantInfo();
    </script>
</body>
</html>

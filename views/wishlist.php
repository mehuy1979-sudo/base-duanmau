<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?= $title ?? 'Danh Mục Yêu Thích - Bunny Wear' ?></title>
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
        .wishlist-container-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .wishlist-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 13.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
        }
        .wishlist-table td {
            vertical-align: middle;
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 14.5px;
        }
        .wishlist-img {
            width: 80px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: transform 0.3s;
        }
        .wishlist-img:hover {
            transform: scale(1.05);
        }
        .wishlist-price {
            font-size: 16px;
            font-weight: 700;
            color: #e11d48;
        }
        .wishlist-orig-price {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 13px;
            margin-left: 6px;
        }
        .stock-badge-in {
            background: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            display: inline-block;
        }
        .stock-badge-out {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            display: inline-block;
        }
        .btn-remove-wishlist {
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 50%;
            transition: all 0.2s;
            font-size: 18px;
        }
        .btn-remove-wishlist:hover {
            color: #ef4444;
            background: #fee2e2;
        }
        .empty-wishlist-box {
            padding: 70px 20px;
            text-align: center;
        }
        .empty-wishlist-icon {
            width: 90px;
            height: 90px;
            line-height: 90px;
            background: #fdf2f8;
            color: #ec4899;
            border-radius: 50%;
            font-size: 42px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cat-filter-pill {
            padding: 7px 18px;
            border-radius: 20px;
            font-size: 13.5px;
            font-weight: 600;
            margin: 4px;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            transition: all 0.2s;
            display: inline-block;
        }
        .cat-filter-pill:hover,
        .cat-filter-pill.active {
            background: #717fe0;
            color: #fff;
            border-color: #717fe0;
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
                            <li><a href="<?= BASE_URL ?>?action=/product">Cửa hàng</a></li>
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/wishlist">Danh Mục Yêu Thích</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/compare">So sánh</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/admin/products">Admin</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=/wishlist" class="dis-block icon-header-item cl1 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-wishlist-noti" data-notify="<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>" title="Danh Mục Yêu Thích">
                            <i class="zmdi zmdi-favorite"></i>
                        </a>
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <div class="logo-mobile">
                <a href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg" alt="IMG-LOGO">
                </a>
            </div>
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <a href="<?= BASE_URL ?>?action=/wishlist" class="dis-block icon-header-item cl1 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-wishlist-noti" data-notify="<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>">
                    <i class="zmdi zmdi-favorite"></i>
                </a>
            </div>
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box"><span class="hamburger-inner"></span></span>
            </div>
        </div>

        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li><div class="left-top-bar">Khuyến mại hè giảm tới 20%</div></li>
            </ul>
            <ul class="main-menu-m">
                <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                <li><a href="<?= BASE_URL ?>?action=/product">Cửa hàng</a></li>
                <li><a href="<?= BASE_URL ?>?action=/wishlist">Danh Mục Yêu Thích</a></li>
                <li><a href="<?= BASE_URL ?>?action=/compare">So sánh</a></li>
                <li><a href="<?= BASE_URL ?>?action=/admin/products">Admin</a></li>
            </ul>
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
                Danh Mục Yêu Thích
            </span>
        </div>
    </div>

    <!-- Wishlist Content -->
    <section class="bg0 p-t-30 p-b-80">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap p-b-25">
                <div>
                    <h1 class="ltext-105 cl5 font-weight-bold" style="font-size: 26px;">
                        <i class="zmdi zmdi-favorite text-danger m-r-8"></i>DANH MỤC YÊU THÍCH
                    </h1>
                    <p class="stext-107 cl6 m-t-4">
                        Tất cả các sản phẩm bạn đã thả tim lưu lại.
                    </p>
                </div>
                <?php if (!empty($products)): ?>
                <div class="m-t-10 m-t-0-md">
                    <button class="btn btn-outline-danger btn-sm px-3 py-2" id="btnClearWishlist" onclick="clearAllWishlist()">
                        <i class="fa fa-trash-o m-r-5"></i> Xóa tất cả
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <!-- Categories in Favorites Filter -->
            <?php if (!empty($categories) && count($categories) > 1): ?>
            <div class="p-b-20">
                <span class="stext-102 cl3 font-weight-bold m-r-10"><i class="fa fa-tags m-r-4"></i> Lọc danh mục:</span>
                <span class="cat-filter-pill active" onclick="filterFavoriteCategory('all', this)">
                    Tất cả (<?= count($products) ?>)
                </span>
                <?php foreach ($categories as $cat): ?>
                <span class="cat-filter-pill" onclick="filterFavoriteCategory('<?= $cat['slug'] ?>', this)">
                    <?= htmlspecialchars($cat['name']) ?> (<?= $cat['count'] ?>)
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Wishlist Box -->
            <div class="wishlist-container-card" id="wishlistContentWrapper">
                <?php if (!empty($products)): ?>
                <div class="table-responsive">
                    <table class="table wishlist-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Hình ảnh</th>
                                <th>Sản phẩm & Danh mục</th>
                                <th style="width: 180px;">Đơn giá</th>
                                <th style="width: 150px;">Tình trạng</th>
                                <th style="width: 220px;" class="text-center">Thao tác</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="wishlistTableBody">
                            <?php foreach ($products as $p): ?>
                            <?php
                                $imgSrc = !empty($p['image']) ? BASE_ASSETS_UPLOADS . htmlspecialchars($p['image']) : BASE_URL . 'views/images/product-01.jpg';
                                $qty = intval($p['quantity'] ?? 0);
                                $catSlug = str_slug($p['category_name'] ?? '');
                            ?>
                            <tr id="wishlist-row-<?= $p['id'] ?>" class="wishlist-product-row" data-cat="<?= $catSlug ?>">
                                <td>
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $p['id'] ?>">
                                        <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" class="wishlist-img" onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg'">
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $p['id'] ?>" class="stext-104 cl4 hov-cl1 font-weight-bold trans-04 d-block mb-1">
                                        <?= htmlspecialchars($p['product_name'] ?? 'Sản phẩm') ?>
                                    </a>
                                    <div class="stext-108 cl6">
                                        <?php if (!empty($p['category_name'])): ?>
                                        <span class="badge badge-light border mr-1"><i class="fa fa-folder-open-o m-r-3"></i><?= htmlspecialchars($p['category_name']) ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($p['sku'])): ?>
                                        <span class="text-muted">Mã: <?= htmlspecialchars($p['sku']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="wishlist-price">
                                        <?= number_format($p['price'] ?? 0, 0, ',', '.') ?> VND
                                    </span>
                                    <?php if (!empty($p['original_price']) && $p['original_price'] > $p['price']): ?>
                                    <span class="wishlist-orig-price">
                                        <?= number_format($p['original_price'], 0, ',', '.') ?> VND
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($qty > 0): ?>
                                    <span class="stock-badge-in">
                                        <i class="fa fa-check-circle m-r-4"></i> Còn hàng
                                    </span>
                                    <?php else: ?>
                                    <span class="stock-badge-out">
                                        <i class="fa fa-times-circle m-r-4"></i> Tạm hết hàng
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $p['id'] ?>" class="btn btn-sm btn-dark px-3 py-2 m-r-6 font-weight-bold" style="border-radius: 20px;">
                                        Xem chi tiết
                                    </a>
                                    <a href="<?= BASE_URL ?>?action=/compare&p1=<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary px-2 py-2" title="So sánh" style="border-radius: 20px;">
                                        <i class="fa fa-columns"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button class="btn-remove-wishlist" onclick="removeFromWishlist(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['product_name'])) ?>')" title="Xóa khỏi yêu thích">
                                        <i class="zmdi zmdi-close"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center p-all-20 border-top bg-light flex-wrap">
                    <a href="<?= BASE_URL ?>?action=/product" class="stext-101 cl2 hov-cl1 trans-04 font-weight-bold">
                        <i class="fa fa-arrow-left m-r-6"></i> Tiếp tục mua sắm
                    </a>
                </div>

                <?php else: ?>
                <!-- Empty State -->
                <div class="empty-wishlist-box" id="emptyWishlistState">
                    <div class="empty-wishlist-icon">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </div>
                    <h3 class="mtext-105 cl2 font-weight-bold mb-2">Danh Mục Yêu Thích của bạn đang trống</h3>
                    <p class="stext-107 cl6 mb-4">Hãy nhấn biểu tượng trái tim khi xem sản phẩm để lưu lại vào Danh Mục Yêu Thích nhé!</p>
                    <a href="<?= BASE_URL ?>?action=/product" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-25 trans-04 m-lr-auto" style="max-width: 220px;">
                        Khám phá cửa hàng ngay
                    </a>
                </div>
                <?php endif; ?>
            </div>
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
        const WISHLIST_BASE_URL = '<?= BASE_URL ?>';

        function updateWishlistBadge(count) {
            $('.js-wishlist-noti').attr('data-notify', count);
        }

        function filterFavoriteCategory(catSlug, el) {
            $('.cat-filter-pill').removeClass('active');
            $(el).addClass('active');

            if (catSlug === 'all') {
                $('.wishlist-product-row').fadeIn(200);
            } else {
                $('.wishlist-product-row').hide();
                $(`.wishlist-product-row[data-cat="${catSlug}"]`).fadeIn(200);
            }
        }

        function renderEmptyWishlist() {
            const emptyHtml = `
                <div class="empty-wishlist-box" id="emptyWishlistState">
                    <div class="empty-wishlist-icon">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </div>
                    <h3 class="mtext-105 cl2 font-weight-bold mb-2">Danh Mục Yêu Thích của bạn đang trống</h3>
                    <p class="stext-107 cl6 mb-4">Hãy nhấn biểu tượng trái tim khi xem sản phẩm để lưu lại vào Danh Mục Yêu Thích nhé!</p>
                    <a href="${WISHLIST_BASE_URL}?action=/product" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-25 trans-04 m-lr-auto" style="max-width: 220px;">
                        Khám phá cửa hàng ngay
                    </a>
                </div>
            `;
            $('#wishlistContentWrapper').html(emptyHtml);
            $('#btnClearWishlist').hide();
            $('.cat-filter-pill').parent().hide();
        }

        function removeFromWishlist(productId, productName) {
            $.ajax({
                url: WISHLIST_BASE_URL + '?action=/wishlist&ajax=remove',
                type: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#wishlist-row-' + productId).fadeOut(300, function() {
                            $(this).remove();
                            updateWishlistBadge(res.count);
                            if ($('#wishlistTableBody tr').length === 0) {
                                renderEmptyWishlist();
                            }
                        });
                        swal(productName || "Sản phẩm", "Đã xóa khỏi Danh Mục Yêu Thích!", "success");
                    }
                },
                error: function() {
                    swal("Lỗi", "Không thể xóa sản phẩm. Vui lòng thử lại!", "error");
                }
            });
        }

        function clearAllWishlist() {
            swal({
                title: "Xác nhận xóa?",
                text: "Bạn có chắc chắn muốn xóa toàn bộ Danh Mục Yêu Thích không?",
                icon: "warning",
                buttons: ["Hủy", "Đồng ý xóa"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: WISHLIST_BASE_URL + '?action=/wishlist&ajax=clear',
                        type: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                updateWishlistBadge(0);
                                renderEmptyWishlist();
                                swal("Đã xóa!", "Đã xóa toàn bộ Danh Mục Yêu Thích!", "success");
                            }
                        },
                        error: function() {
                            swal("Lỗi", "Không thể xóa danh sách. Vui lòng thử lại!", "error");
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>

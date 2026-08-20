<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?= $title ?? 'Lịch sử mua hàng - Bunny Wear' ?></title>
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
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">

    <style>
        .order-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 24px;
            overflow: hidden;
            transition: all .25s ease;
        }
        .order-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border-color: #cbd5e0;
        }
        .order-header {
            background: #f8fafc;
            padding: 16px 24px;
            border-bottom: 1px solid #edf2f7;
        }
        .order-body {
            padding: 20px 24px;
        }
        .order-footer {
            background: #fff;
            padding: 16px 24px;
            border-top: 1px solid #edf2f7;
        }
        .item-thumb {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #edf2f7;
        }
        .status-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-processing {
            background: #eef2ff;
            color: #4f46e5;
            border: 1px solid #c7d2fe;
        }
        .status-shipping {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        .status-completed {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .status-cancelled {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .order-filter-btn {
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 18px;
            margin-right: 8px;
            margin-bottom: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #4a5568;
            cursor: pointer;
            transition: all .2s;
        }
        .order-filter-btn:hover, .order-filter-btn.active {
            background: #717fe0;
            color: #fff;
            border-color: #717fe0;
        }
        .empty-order-box {
            background: #fff;
            border-radius: 16px;
            padding: 60px 30px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
    </style>
</head>
<body class="animsition bg-light">

    <!-- Header -->
    <header class="header-v4">
        <!-- Topbar -->
        <div class="container-menu-desktop">
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        Khuyến mại hè giảm 20%
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        <?php if (!empty($_SESSION['user'])): ?>
                            <span class="flex-c-m trans-04 p-lr-25 text-white">
                                <i class="fa fa-user-circle mr-1"></i> <?= htmlspecialchars($_SESSION['user']['fullname']) ?>
                            </span>
                            <a href="<?= BASE_URL ?>?action=/order-history" class="flex-c-m trans-04 p-lr-25 font-weight-bold text-white" style="color: #ffc107 !important;">
                                <i class="fa fa-history mr-1"></i> Lịch sử đơn hàng
                            </a>
                            <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                                <a href="<?= BASE_URL ?>admin/index.php" class="flex-c-m trans-04 p-lr-25">
                                    Trang quản trị
                                </a>
                            <?php endif; ?>
                            <a href="<?= BASE_URL ?>?action=/logout" class="flex-c-m trans-04 p-lr-25">
                                Đăng xuất
                            </a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>?action=/login" class="flex-c-m trans-04 p-lr-25">Đăng nhập</a>
                            <a href="<?= BASE_URL ?>?action=/register" class="flex-c-m trans-04 p-lr-25">Đăng ký</a>
                        <?php endif; ?>
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
                            <li><a href="<?= BASE_URL ?>?action=/cart">Giỏ hàng</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/wishlist">Yêu thích</a></li>
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/order-history">Lịch sử mua hàng</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <a href="<?= BASE_URL ?>?action=/cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?action=/wishlist" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-wishlist-noti" data-notify="<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Section -->
    <div class="container p-t-30 p-b-20">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Lịch sử mua hàng
            </span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container p-b-80">
        
        <!-- Flash Alert -->
        <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                <i class="fa fa-check-circle mr-2"></i> <?= htmlspecialchars($flashSuccess) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                <i class="fa fa-exclamation-triangle mr-2"></i> <?= htmlspecialchars($flashError) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center flex-wrap p-b-25">
            <div>
                <h3 class="mtext-105 cl2 font-weight-bold">
                    <i class="fa fa-shopping-bag text-primary mr-2"></i> Lịch Sử Đơn Hàng Của Bạn
                </h3>
                <p class="stext-102 cl6 mt-1">
                    Theo dõi trạng thái đơn hàng, xem chi tiết và đánh giá sản phẩm sau khi mua.
                </p>
            </div>
            <a href="<?= BASE_URL ?>?action=/product" class="btn btn-outline-primary font-weight-bold px-4 py-2" style="border-radius: 25px;">
                <i class="fa fa-plus mr-1"></i> Tiếp tục mua sắm
            </a>
        </div>

        <?php if (!empty($orders)): ?>
            <!-- Filter Tabs -->
            <div class="flex-w flex-m p-b-20">
                <button class="order-filter-btn active" onclick="filterOrders('all')">
                    Tất cả (<?= count($orders) ?>)
                </button>
                <button class="order-filter-btn" onclick="filterOrders('processing')">
                    Đang xử lý
                </button>
                <button class="order-filter-btn" onclick="filterOrders('shipping')">
                    Đang giao
                </button>
                <button class="order-filter-btn" onclick="filterOrders('completed')">
                    Hoàn thành
                </button>
                <button class="order-filter-btn" onclick="filterOrders('cancelled')">
                    Đã hủy
                </button>
            </div>

            <div id="ordersListWrapper">
                <?php foreach ($orders as $order): ?>
                    <?php
                        $st = trim($order['status'] ?? 'Đang xử lý');
                        $stLower = mb_strtolower($st, 'UTF-8');
                        
                        $badgeClass = 'status-processing';
                        $filterCat = 'processing';

                        if (in_array($stLower, ['đang giao', 'đang giao hàng', 'shipping'], true)) {
                            $badgeClass = 'status-shipping';
                            $filterCat = 'shipping';
                        } elseif (in_array($stLower, ['hoàn thành', 'đã giao', 'đã giao hàng', 'completed', 'success'], true)) {
                            $badgeClass = 'status-completed';
                            $filterCat = 'completed';
                        } elseif (in_array($stLower, ['đã hủy', 'hủy', 'cancelled'], true)) {
                            $badgeClass = 'status-cancelled';
                            $filterCat = 'cancelled';
                        }
                        
                        $orderCode = 'DH' . str_pad($order['id'], 5, '0', STR_PAD_LEFT);
                        $canCancel = in_array($stLower, ['đang xử lý', 'chờ xử lý', 'pending', 'processing'], true);
                    ?>
                    <div class="order-card order-item-block" data-status-cat="<?= $filterCat ?>">
                        <!-- Order Card Header -->
                        <div class="order-header d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <span class="font-weight-bold text-dark fs-16">
                                    Đơn hàng #<?= $orderCode ?>
                                </span>
                                <span class="text-muted fs-13 m-l-10">
                                    <i class="fa fa-calendar m-r-4"></i> <?= date('d/m/Y H:i', strtotime($order['formatted_order_date'] ?? $order['order_date'])) ?>
                                </span>
                            </div>
                            <div>
                                <span class="status-badge <?= $badgeClass ?>">
                                    <i class="fa fa-circle fs-9 mr-1"></i> <?= htmlspecialchars($st) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Order Card Body: Items List -->
                        <div class="order-body">
                            <?php if (!empty($order['items'])): ?>
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap py-2 border-bottom-light">
                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                            <img src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars($item['product_image'] ?? 'default.jpg') ?>" 
                                                 alt="<?= htmlspecialchars($item['product_name'] ?? 'Sản phẩm') ?>" 
                                                 class="item-thumb mr-3"
                                                 onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg';">
                                            <div>
                                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $item['product_id'] ?>" class="stext-104 cl4 hov-cl1 font-weight-bold d-block">
                                                    <?= htmlspecialchars($item['product_name'] ?? ('Sản phẩm #' . $item['product_id'])) ?>
                                                </a>
                                                <small class="text-muted d-block mt-1">
                                                    Số lượng: <strong class="text-dark">x<?= intval($item['quantity']) ?></strong> | Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?> VND
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="stext-105 font-weight-bold text-dark">
                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                                            </span>
                                            <div>
                                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $item['product_id'] ?>#reviews" class="btn btn-sm btn-outline-warning mt-1 py-0 px-2 font-weight-bold" style="font-size: 11px; border-radius: 12px;" title="Viết bình luận và chấm sao cho sản phẩm này">
                                                    <i class="fa fa-star text-warning mr-1"></i> Đánh giá sản phẩm
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">Chi tiết sản phẩm đang được cập nhật.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Order Card Footer -->
                        <div class="order-footer d-flex justify-content-between align-items-center flex-wrap">
                            <div class="mb-2 mb-md-0">
                                <span class="stext-102 cl6">
                                    Thanh toán: <strong class="text-dark"><?= strtoupper($order['payment_method'] ?? 'COD') ?></strong>
                                </span>
                                <?php if (!empty($order['discount']) && $order['discount'] > 0): ?>
                                    <span class="text-success ml-2 font-weight-bold">
                                        (Đã giảm <?= number_format($order['discount'], 0, ',', '.') ?>đ)
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="mr-4 mb-2 mb-md-0">
                                    <span class="stext-102 cl6 mr-2">Tổng tiền thanh toán:</span>
                                    <span class="ltext-101 text-danger font-weight-bold" style="font-size: 18px;">
                                        <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> VND
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="<?= BASE_URL ?>?action=/order-detail&id=<?= $order['id'] ?>" class="btn btn-primary btn-sm px-3 py-2 font-weight-bold mr-2" style="border-radius: 20px;">
                                        <i class="fa fa-eye mr-1"></i> Xem chi tiết
                                    </a>
                                    <?php if ($canCancel): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm px-3 py-2 font-weight-bold" style="border-radius: 20px;" onclick="confirmCancelOrder(<?= $order['id'] ?>, '<?= $orderCode ?>')">
                                            <i class="fa fa-times mr-1"></i> Hủy đơn
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty Orders State -->
            <div class="empty-order-box">
                <div class="mb-4">
                    <i class="fa fa-shopping-bag fa-4x text-muted" style="opacity: 0.4;"></i>
                </div>
                <h4 class="mtext-109 cl2 font-weight-bold p-b-10">
                    Bạn chưa có đơn hàng nào
                </h4>
                <p class="stext-102 cl6 p-b-25" style="max-width: 480px; margin: 0 auto;">
                    Khám phá ngay bộ sưu tập thời trang cao cấp mới nhất tại Bunny Wear và tận hưởng nhiều ưu đãi hấp dẫn!
                </p>
                <a href="<?= BASE_URL ?>?action=/product" class="btn btn-primary px-5 py-3 font-weight-bold" style="border-radius: 30px; font-size: 15px;">
                    <i class="fa fa-shopping-cart mr-2"></i> Khám phá sản phẩm ngay
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- Footer -->
    <footer class="bg3 p-t-60 p-b-32 text-white">
        <div class="container text-center">
            <p class="stext-107 cl6 mb-0 text-white">
                © <?= date('Y') ?> Bunny Wear. Bản quyền thuộc về Bunny Wear Shop.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/sweetalert/sweetalert.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>

    <script>
        function filterOrders(status) {
            $('.order-filter-btn').removeClass('active');
            event.target.classList.add('active');

            if (status === 'all') {
                $('.order-item-block').fadeIn(200);
            } else {
                $('.order-item-block').each(function() {
                    if ($(this).data('status-cat') === status) {
                        $(this).fadeIn(200);
                    } else {
                        $(this).fadeOut(150);
                    }
                });
            }
        }

        function confirmCancelOrder(orderId, orderCode) {
            swal({
                title: "Hủy đơn hàng #" + orderCode + "?",
                text: "Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.",
                icon: "warning",
                buttons: ["Không, giữ đơn", "Đúng, hủy đơn"],
                dangerMode: true,
            }).then((willCancel) => {
                if (willCancel) {
                    window.location.href = "<?= BASE_URL ?>?action=/order-cancel&id=" + orderId;
                }
            });
        }
    </script>
</body>
</html>

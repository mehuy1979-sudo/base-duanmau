<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?= $title ?? 'Chi tiết đơn hàng - Bunny Wear' ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animate/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">

    <style>
        .detail-panel {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .item-img-small {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #edf2f7;
        }
        .status-badge-lg {
            font-size: 13px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 25px;
            text-transform: uppercase;
        }
        .step-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 20px 0 35px;
        }
        .step-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 5%;
            right: 5%;
            height: 4px;
            background: #e2e8f0;
            z-index: 1;
        }
        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }
        .step-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #718096;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            border: 3px solid #fff;
            transition: all .3s;
        }
        .step-item.active .step-icon {
            background: #717fe0;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(113, 127, 224, 0.25);
        }
        .step-item.completed .step-icon {
            background: #10b981;
            color: #fff;
        }
        .step-title {
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
        }
        @media print {
            header, footer, .no-print, .bread-crumb {
                display: none !important;
            }
            body {
                background: #fff !important;
            }
            .detail-panel {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="animsition bg-light">

    <!-- Header -->
    <header class="header-v4 no-print">
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
                            <a href="<?= BASE_URL ?>?action=/order-history" class="flex-c-m trans-04 p-lr-25 font-weight-bold text-white">
                                <i class="fa fa-history mr-1"></i> Lịch sử đơn hàng
                            </a>
                            <a href="<?= BASE_URL ?>?action=/logout" class="flex-c-m trans-04 p-lr-25">Đăng xuất</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>?action=/login" class="flex-c-m trans-04 p-lr-25">Đăng nhập</a>
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
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/order-history">Lịch sử mua hàng</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="container p-t-30 p-b-20 no-print">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">Trang chủ <i class="fa fa-angle-right m-l-9 m-r-10"></i></a>
            <a href="<?= BASE_URL ?>?action=/order-history" class="stext-109 cl8 hov-cl1 trans-04">Lịch sử đơn hàng <i class="fa fa-angle-right m-l-9 m-r-10"></i></a>
            <span class="stext-109 cl4">Đơn hàng #DH<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></span>
        </div>
    </div>

    <?php
        $st = trim($order['status'] ?? 'Đang xử lý');
        $stLower = mb_strtolower($st, 'UTF-8');
        $isCancelled = in_array($stLower, ['đã hủy', 'hủy', 'cancelled'], true);
        $isCompleted = in_array($stLower, ['hoàn thành', 'đã giao', 'đã giao hàng', 'completed', 'success'], true);
        $isShipping  = in_array($stLower, ['đang giao', 'đang giao hàng', 'shipping'], true);
        $canCancel   = in_array($stLower, ['đang xử lý', 'chờ xử lý', 'pending', 'processing'], true);
        $orderCode   = 'DH' . str_pad($order['id'], 5, '0', STR_PAD_LEFT);
    ?>

    <!-- Main Container -->
    <div class="container p-b-80">
        
        <!-- Header Info Bar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap p-b-20 no-print">
            <div>
                <a href="<?= BASE_URL ?>?action=/order-history" class="btn btn-outline-secondary btn-sm mb-2" style="border-radius: 20px;">
                    <i class="fa fa-arrow-left mr-1"></i> Quay lại danh sách
                </a>
                <h3 class="mtext-105 cl2 font-weight-bold">
                    Chi Tiết Đơn Hàng #<?= $orderCode ?>
                </h3>
                <span class="text-muted stext-102">
                    Đặt ngày <?= date('d/m/Y H:i', strtotime($order['order_date'] ?? $order['created_at'])) ?>
                </span>
            </div>

            <div class="d-flex align-items-center mt-2 mt-md-0">
                <button type="button" class="btn btn-outline-dark btn-sm px-3 py-2 mr-2 font-weight-bold" style="border-radius: 20px;" onclick="window.print()">
                    <i class="fa fa-print mr-1"></i> In hóa đơn
                </button>
                <?php if ($canCancel): ?>
                    <button type="button" class="btn btn-danger btn-sm px-3 py-2 font-weight-bold" style="border-radius: 20px;" onclick="confirmCancelOrder(<?= $order['id'] ?>, '<?= $orderCode ?>')">
                        <i class="fa fa-times mr-1"></i> Hủy đơn hàng
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Progress Tracker (if not cancelled) -->
        <?php if (!$isCancelled): ?>
            <div class="detail-panel no-print">
                <h5 class="stext-101 cl2 font-weight-bold mb-4">Trạng thái vận chuyển đơn hàng</h5>
                <div class="step-progress">
                    <div class="step-item completed">
                        <div class="step-icon"><i class="fa fa-check"></i></div>
                        <div class="step-title">Đặt hàng thành công</div>
                    </div>
                    <div class="step-item <?= ($isShipping || $isCompleted) ? 'completed' : 'active' ?>">
                        <div class="step-icon"><?= ($isShipping || $isCompleted) ? '<i class="fa fa-check"></i>' : '2' ?></div>
                        <div class="step-title">Đang xử lý & Đóng gói</div>
                    </div>
                    <div class="step-item <?= $isCompleted ? 'completed' : ($isShipping ? 'active' : '') ?>">
                        <div class="step-icon"><?= $isCompleted ? '<i class="fa fa-check"></i>' : '3' ?></div>
                        <div class="step-title">Đang giao hàng</div>
                    </div>
                    <div class="step-item <?= $isCompleted ? 'completed active' : '' ?>">
                        <div class="step-icon"><?= $isCompleted ? '<i class="fa fa-check"></i>' : '4' ?></div>
                        <div class="step-title">Giao thành công</div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger mb-4 p-3" style="border-radius: 10px;">
                <i class="fa fa-ban fa-lg mr-2"></i> <strong>Đơn hàng này đã bị hủy.</strong> Nếu cần hỗ trợ thêm, vui lòng liên hệ hotline Bunny Wear.
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Left Column: Products in order -->
            <div class="col-lg-8">
                <div class="detail-panel">
                    <h5 class="mtext-108 cl2 font-weight-bold p-b-15 border-bottom">
                        Sản phẩm đã mua (<?= count($order['items'] ?? []) ?>)
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted border-bottom" style="font-size: 13px;">
                                    <th>SẢN PHẨM</th>
                                    <th class="text-center">ĐƠN GIÁ</th>
                                    <th class="text-center">SỐ LƯỢNG</th>
                                    <th class="text-right">TẠM TÍNH</th>
                                    <th class="text-center no-print">ĐÁNH GIÁ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($order['items'])): ?>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <tr class="border-bottom-light">
                                            <td style="min-width: 220px;">
                                                <div class="d-flex align-items-center py-2">
                                                    <img src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars($item['product_image'] ?? 'default.jpg') ?>" 
                                                         alt="<?= htmlspecialchars($item['product_name'] ?? 'Sản phẩm') ?>" 
                                                         class="item-img-small mr-3"
                                                         onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg';">
                                                    <div>
                                                        <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $item['product_id'] ?>" class="stext-104 cl4 hov-cl1 font-weight-bold d-block">
                                                            <?= htmlspecialchars($item['product_name'] ?? ('Sản phẩm #' . $item['product_id'])) ?>
                                                        </a>
                                                        <small class="text-muted">Mã SP: #<?= $item['product_id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle font-weight-bold">
                                                <?= number_format($item['price'], 0, ',', '.') ?>đ
                                            </td>
                                            <td class="text-center align-middle">
                                                x<?= intval($item['quantity']) ?>
                                            </td>
                                            <td class="text-right align-middle font-weight-bold text-dark">
                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                            </td>
                                            <td class="text-center align-middle no-print">
                                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $item['product_id'] ?>#reviews" class="btn btn-warning btn-sm py-1 px-2 font-weight-bold" style="font-size: 11px; border-radius: 15px; color: #fff;" title="Chấm sao & Viết cảm nhận">
                                                    <i class="fa fa-star mr-1"></i> Đánh giá
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Financial Summary -->
                    <div class="pt-4 border-top mt-3">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="stext-102 cl6">Tạm tính hàng hóa:</span>
                                    <span class="font-weight-bold text-dark"><?= number_format(($order['total_amount'] ?? 0) + ($order['discount'] ?? 0), 0, ',', '.') ?> VND</span>
                                </div>
                                <?php if (!empty($order['discount']) && $order['discount'] > 0): ?>
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span class="stext-102 font-weight-bold">Giảm giá voucher:</span>
                                        <span class="font-weight-bold">-<?= number_format($order['discount'], 0, ',', '.') ?> VND</span>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="stext-102 cl6">Phí vận chuyển:</span>
                                    <span class="text-success font-weight-bold">Miễn phí giao hàng</span>
                                </div>
                                <div class="d-flex justify-content-between pt-2 border-top">
                                    <span class="mtext-108 cl2 font-weight-bold">Tổng thanh toán:</span>
                                    <span class="ltext-101 text-danger font-weight-bold" style="font-size: 22px;">
                                        <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> VND
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Shipping Info & Actions -->
            <div class="col-lg-4">
                <!-- Shipping Info Card -->
                <div class="detail-panel">
                    <h5 class="mtext-108 cl2 font-weight-bold p-b-15 border-bottom">
                        <i class="fa fa-map-marker text-danger mr-1"></i> Thông Tin Nhận Hàng
                    </h5>
                    
                    <div class="pt-2">
                        <p class="mb-1"><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name'] ?? 'Khách hàng') ?></p>
                        <p class="mb-1"><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? 'Chưa cập nhật') ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '') ?></p>
                        <p class="mb-1"><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? '') ?>, <?= htmlspecialchars($order['district'] ?? '') ?>, <?= htmlspecialchars($order['city'] ?? '') ?></p>
                        <?php if (!empty($order['note'])): ?>
                            <p class="mb-0 mt-2 p-2 bg-light text-muted" style="border-radius: 6px; font-size: 13px;">
                                <strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Payment & Status Card -->
                <div class="detail-panel">
                    <h5 class="mtext-108 cl2 font-weight-bold p-b-15 border-bottom">
                        <i class="fa fa-credit-card text-primary mr-1"></i> Hình Thức Thanh Toán
                    </h5>
                    
                    <div class="pt-2">
                        <p class="mb-2">
                            <strong>Phương thức:</strong> 
                            <?= strtoupper($order['payment_method'] ?? 'COD') === 'COD' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' ?>
                        </p>
                        <p class="mb-0">
                            <strong>Trạng thái đơn:</strong> 
                            <span class="badge <?= $isCompleted ? 'badge-success bg-success' : ($isCancelled ? 'badge-danger bg-danger' : 'badge-primary bg-primary') ?> text-white px-2 py-1">
                                <?= htmlspecialchars($st) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/sweetalert/sweetalert.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>

    <script>
        function confirmCancelOrder(orderId, orderCode) {
            swal({
                title: "Hủy đơn hàng #" + orderCode + "?",
                text: "Bạn có chắc chắn muốn hủy đơn hàng này không?",
                icon: "warning",
                buttons: ["Không, giữ lại", "Đúng, hủy đơn"],
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

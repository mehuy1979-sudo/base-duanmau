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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

    <style>
        .detail-panel {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .item-img-small {
            width: 68px;
            height: 68px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #edf2f7;
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
        .btn-review-item {
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 14px;
            color: #b45309;
            background: #fef3c7;
            border: 1px solid #fde68a;
            transition: all .15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-review-item:hover {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
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
            font-size: 24px;
            color: #d1d5db;
            cursor: pointer;
            margin: 0;
            transition: color .15s;
        }
        .star-rating-select input:checked ~ label,
        .star-rating-select label:hover,
        .star-rating-select label:hover ~ label {
            color: #f59e0b;
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
                            <li><a href="<?= BASE_URL ?>?action=/wishlist">Danh Mục Yêu Thích</a></li>
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

    <!-- Breadcrumb -->
    <div class="container p-t-30 p-b-20 no-print">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">Trang chủ <i class="fa fa-angle-right m-l-9 m-r-10"></i></a>
            <a href="<?= BASE_URL ?>?action=/order-history" class="stext-109 cl8 hov-cl1 trans-04">Lịch sử đơn hàng <i class="fa fa-angle-right m-l-9 m-r-10"></i></a>
            <span class="stext-109 cl4">Đơn hàng #DH<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></span>
        </div>
    </div>

    <?php
        $st = trim($order['status'] ?? 'Chờ xử lý');
        $stLower = mb_strtolower($st, 'UTF-8');
        $orderStatus = (int)($order['order_status'] ?? 1);

        $isCancelled = in_array($orderStatus, [7], true) || in_array($stLower, ['đã hủy', 'hủy', 'cancelled'], true);
        $isCompleted = in_array($orderStatus, [4, 6], true) || in_array($stLower, ['hoàn thành', 'đã giao', 'đã giao hàng', 'completed', 'success'], true);
        $isShipping  = ($orderStatus === 3) || in_array($stLower, ['đang giao', 'đang giao hàng', 'shipping'], true);
        $isConfirmed = in_array($orderStatus, [2, 3, 4, 6], true);
        $canCancel   = ($orderStatus === 1) && in_array($stLower, ['đang xử lý', 'chờ xử lý', 'pending', 'processing'], true);
        $orderCode   = 'DH' . str_pad($order['id'], 5, '0', STR_PAD_LEFT);
        $discount    = (float)($order['discount'] ?? 0);
        $couponCode  = $order['coupon_code'] ?? '';
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
                    Đặt lúc: <?= date('d/m/Y H:i', strtotime($order['order_date'] ?? $order['created_at'])) ?>
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
                <h5 class="stext-101 cl2 font-weight-bold mb-4">Tiến trình vận chuyển đơn hàng</h5>
                <div class="step-progress">
                    <div class="step-item completed">
                        <div class="step-icon"><i class="fa fa-check"></i></div>
                        <div class="step-title">1. Đặt hàng thành công</div>
                    </div>
                    <div class="step-item <?= $isConfirmed ? 'completed' : 'active' ?>">
                        <div class="step-icon"><?= $isConfirmed ? '<i class="fa fa-check"></i>' : '2' ?></div>
                        <div class="step-title">2. Đã xác nhận</div>
                    </div>
                    <div class="step-item <?= ($isShipping || $isCompleted) ? ($isCompleted ? 'completed' : 'active') : '' ?>">
                        <div class="step-icon"><?= $isCompleted ? '<i class="fa fa-check"></i>' : '3' ?></div>
                        <div class="step-title">3. Đang giao hàng</div>
                    </div>
                    <div class="step-item <?= $isCompleted ? 'completed active' : '' ?>">
                        <div class="step-icon"><?= $isCompleted ? '<i class="fa fa-check"></i>' : '4' ?></div>
                        <div class="step-title">4. Hoàn thành</div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger mb-4 p-3" style="border-radius: 10px;">
                <i class="fa fa-ban fa-lg mr-2"></i> <strong>Đơn hàng này đã bị hủy.</strong>
                <?php if (!empty($order['cancel_reason'])): ?>
                    <div class="mt-1 small">Lý do: <em><?= htmlspecialchars($order['cancel_reason']) ?></em></div>
                <?php endif; ?>
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
                                        <?php
                                            $itemImg = !empty($item['product_image']) ? BASE_URL . 'assets/uploads/' . $item['product_image'] : BASE_URL . 'views/images/product-01.jpg';
                                            $pName = $item['product_name'] ?? ('Sản phẩm #' . ($item['product_id'] ?? ''));
                                            $pId = (int)($item['product_id'] ?? 0);
                                        ?>
                                        <tr class="border-bottom-light">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $pId ?>">
                                                        <img src="<?= $itemImg ?>" alt="<?= htmlspecialchars($pName) ?>" class="item-img-small mr-3" onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg';">
                                                    </a>
                                                    <div>
                                                        <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $pId ?>" class="font-weight-bold text-dark text-decoration-none hov-cl1 trans-04">
                                                            <?= htmlspecialchars($pName) ?>
                                                        </a>
                                                        <small class="text-muted d-block">Mã SP: #<?= $pId ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle"><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>
                                            <td class="text-center align-middle"><span class="badge badge-light border px-2 py-1"><?= (int)$item['quantity'] ?></span></td>
                                            <td class="text-right align-middle font-weight-bold"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫</td>
                                            <td class="text-center align-middle no-print">
                                                <?php if ($isCompleted && $pId > 0): ?>
                                                    <button type="button" class="btn-review-item" onclick="openReviewModal(<?= $pId ?>, '<?= htmlspecialchars(addslashes($pName)) ?>', '<?= $itemImg ?>')">
                                                        <i class="fa fa-star text-warning"></i> Viết đánh giá
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted small">—</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Breakdown -->
                    <div class="border-top mt-3 pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="font-weight-bold"><?= number_format($order['total_amount'] + $discount, 0, ',', '.') ?> ₫</span>
                        </div>
                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá (<?= htmlspecialchars($couponCode ?: 'KM') ?>):</span>
                                <span>-<?= number_format($discount, 0, ',', '.') ?> ₫</span>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <span class="text-success font-weight-bold">Miễn phí (0 ₫)</span>
                        </div>
                        <div class="d-flex justify-content-between fs-18 font-weight-bold text-danger border-top pt-2">
                            <span>Tổng tiền thanh toán:</span>
                            <span><?= number_format($order['total_amount'], 0, ',', '.') ?> ₫</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Shipping & Receiver details -->
            <div class="col-lg-4">
                <div class="detail-panel">
                    <h5 class="mtext-108 cl2 font-weight-bold p-b-15 border-bottom">
                        Thông tin giao hàng
                    </h5>
                    <p class="mb-2"><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name'] ?? 'Khách lẻ') ?></p>
                    <p class="mb-2"><strong>Số điện thoại:</strong> <a href="tel:<?= htmlspecialchars($order['phone'] ?? '') ?>"><?= htmlspecialchars($order['phone'] ?? 'N/A') ?></a></p>
                    <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? 'Chưa cung cấp') ?></p>
                    <p class="mb-2"><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? '') ?>, <?= htmlspecialchars($order['district'] ?? '') ?>, <?= htmlspecialchars($order['city'] ?? '') ?></p>
                    <p class="mb-2"><strong>Hình thức thanh toán:</strong> <span class="badge badge-light border"><?= strtoupper($order['payment_method'] ?? 'COD') ?></span></p>
                    <?php if (!empty($order['note'])): ?>
                        <p class="mb-0 text-muted small mt-2"><strong>Ghi chú:</strong> <em>"<?= htmlspecialchars($order['note']) ?>"</em></p>
                    <?php endif; ?>
                </div>

                <!-- Support Box -->
                <div class="detail-panel bg-light no-print text-center">
                    <i class="fa fa-headphones fa-2x text-primary mb-2"></i>
                    <h6 class="font-weight-bold mb-1">Cần hỗ trợ về đơn hàng này?</h6>
                    <p class="stext-102 cl6 small mb-3">Hotline chăm sóc khách hàng Bunny Wear phục vụ 24/7.</p>
                    <a href="tel:19001234" class="btn btn-outline-primary btn-sm font-weight-bold px-4" style="border-radius: 20px;">
                        <i class="fa fa-phone mr-1"></i> Gọi 1900 1234
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Review Modal for Instant Review -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                <div class="modal-header bg-light border-0 py-3 px-4">
                    <h5 class="modal-title font-weight-bold text-dark" id="reviewModalLabel">
                        <i class="fa fa-star text-warning mr-2"></i> Đánh giá sản phẩm đã mua
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modalReviewForm" onsubmit="submitModalReview(event)">
                    <div class="modal-body px-4 py-3">
                        <input type="hidden" id="modalProductId" name="product_id" value="0">

                        <div class="d-flex align-items-center mb-3 p-2 bg-light" style="border-radius: 10px;">
                            <img src="" id="modalProductImg" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;" class="mr-3">
                            <div>
                                <strong id="modalProductName" class="text-dark d-block"></strong>
                                <span class="badge badge-success text-success bg-white border border-success px-2 py-1" style="font-size: 11px; border-radius: 12px;">
                                    <i class="fa fa-check-circle"></i> Đã mua hàng tại Bunny Wear
                                </span>
                            </div>
                        </div>

                        <!-- Star Rating -->
                        <div class="form-group text-center my-3">
                            <label class="d-block font-weight-bold text-muted mb-2">Chất lượng sản phẩm:</label>
                            <div class="star-rating-select justify-content-center">
                                <input type="radio" id="mstar5" name="rating" value="5" checked />
                                <label for="mstar5" title="5 sao"><i class="fa fa-star"></i></label>
                                <input type="radio" id="mstar4" name="rating" value="4" />
                                <label for="mstar4" title="4 sao"><i class="fa fa-star"></i></label>
                                <input type="radio" id="mstar3" name="rating" value="3" />
                                <label for="mstar3" title="3 sao"><i class="fa fa-star"></i></label>
                                <input type="radio" id="mstar2" name="rating" value="2" />
                                <label for="mstar2" title="2 sao"><i class="fa fa-star"></i></label>
                                <input type="radio" id="mstar1" name="rating" value="1" />
                                <label for="mstar1" title="1 sao"><i class="fa fa-star"></i></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modalReviewName" class="font-weight-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modalReviewName" name="user_name" value="<?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="modalReviewComment" class="font-weight-bold">Nhận xét chi tiết <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="modalReviewComment" name="comment" rows="3" placeholder="Chia sẻ cảm nhận về form dáng, chất vải, độ bền, thời gian giao hàng..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" style="border-radius: 20px;">Hủy bỏ</button>
                        <button type="submit" id="btnSubmitModalReview" class="btn btn-primary font-weight-bold px-4" style="border-radius: 20px;">
                            <i class="fa fa-paper-plane mr-1"></i> Gửi đánh giá
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        function confirmCancelOrder(orderId, orderCode) {
            swal({
                title: "Hủy đơn hàng " + orderCode + "?",
                text: "Bạn có chắc chắn muốn hủy đơn hàng này không? Thao tác này không thể hoàn tác.",
                icon: "warning",
                buttons: {
                    cancel: "Giữ lại đơn",
                    confirm: {
                        text: "Xác nhận hủy",
                        value: true,
                        className: "btn-danger"
                    }
                },
                dangerMode: true,
            }).then((willCancel) => {
                if (willCancel) {
                    $.ajax({
                        url: '<?= BASE_URL ?>?action=/order-cancel&ajax=1',
                        type: 'POST',
                        data: { order_id: orderId },
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                swal("Thành công", res.message, "success").then(() => {
                                    window.location.href = '<?= BASE_URL ?>?action=/order-history';
                                });
                            } else {
                                swal("Lỗi", res.message, "error");
                            }
                        },
                        error: function() {
                            swal("Lỗi", "Không thể kết nối máy chủ.", "error");
                        }
                    });
                }
            });
        }

        function openReviewModal(productId, productName, productImg) {
            $('#modalProductId').val(productId);
            $('#modalProductName').text(productName);
            $('#modalProductImg').attr('src', productImg);
            $('#modalReviewComment').val('');
            $('#mstar5').prop('checked', true);
            $('#reviewModal').modal('show');
        }

        function submitModalReview(e) {
            e.preventDefault();
            const productId = $('#modalProductId').val();
            const $btn = $('#btnSubmitModalReview');
            const formData = $('#modalReviewForm').serialize();

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Đang gửi...');

            $.ajax({
                url: '<?= BASE_URL ?>?action=/product-detail&id=' + productId + '&ajax=add_review',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> Gửi đánh giá');
                    if (res.success) {
                        $('#reviewModal').modal('hide');
                        swal({
                            title: "Đánh giá thành công!",
                            text: res.message + "\nBạn có muốn xem đánh giá của mình trên trang sản phẩm?",
                            icon: "success",
                            buttons: {
                                stay: "Ở lại trang này",
                                viewProduct: "Xem sản phẩm"
                            }
                        }).then((choice) => {
                            if (choice === 'viewProduct') {
                                window.location.href = '<?= BASE_URL ?>?action=/product-detail&id=' + productId + '#reviews';
                            }
                        });
                    } else {
                        swal("Thông báo", res.message || "Không thể gửi đánh giá.", "warning");
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> Gửi đánh giá');
                    swal("Lỗi", "Không thể kết nối máy chủ.", "error");
                }
            });
        }
    </script>
</body>
</html>

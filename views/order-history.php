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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

    <style>
        .order-card {
            background: #fff;
            border-radius: 14px;
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
            padding: 5px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-processing {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .status-confirmed {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
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
        /* Star rating in modal */
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
                    Theo dõi trạng thái đơn hàng thời gian thực, xem chi tiết và đánh giá sản phẩm sau khi đơn hoàn tất.
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
                    Chờ xử lý
                </button>
                <button class="order-filter-btn" onclick="filterOrders('shipping')">
                    Đang giao
                </button>
                <button class="order-filter-btn" onclick="filterOrders('completed')">
                    Hoàn thành & Đánh giá
                </button>
                <button class="order-filter-btn" onclick="filterOrders('cancelled')">
                    Đã hủy
                </button>
            </div>

            <div id="ordersListWrapper">
                <?php foreach ($orders as $order): ?>
                    <?php
                        $id = (int)$order['id'];
                        $orderCode = 'DH' . str_pad($id, 5, '0', STR_PAD_LEFT);
                        $orderStatus = (int)($order['order_status'] ?? 1);
                        $statusText = trim($order['status'] ?? 'Chờ xử lý');

                        // Phân loại nhóm bộ lọc
                        $filterCategory = 'processing';
                        $badgeClass = 'status-processing';
                        $badgeIcon = 'fa-hourglass-half';

                        if ($orderStatus === 2) {
                            $filterCategory = 'processing';
                            $badgeClass = 'status-confirmed';
                            $badgeIcon = 'fa-check-square-o';
                        } elseif ($orderStatus === 3) {
                            $filterCategory = 'shipping';
                            $badgeClass = 'status-shipping';
                            $badgeIcon = 'fa-truck';
                        } elseif (in_array($orderStatus, [4, 6], true) || in_array(mb_strtolower($statusText, 'UTF-8'), ['hoàn thành', 'đã giao', 'completed'])) {
                            $filterCategory = 'completed';
                            $badgeClass = 'status-completed';
                            $badgeIcon = 'fa-check-circle';
                        } elseif ($orderStatus === 7 || in_array(mb_strtolower($statusText, 'UTF-8'), ['đã hủy', 'hủy', 'cancelled'])) {
                            $filterCategory = 'cancelled';
                            $badgeClass = 'status-cancelled';
                            $badgeIcon = 'fa-times-circle';
                        }

                        $isCompleted = ($filterCategory === 'completed');
                        $canCancel = ($orderStatus === 1 && $filterCategory === 'processing');
                    ?>
                    <div class="order-card order-item-block" data-status-group="<?= $filterCategory ?>">
                        <!-- Card Header -->
                        <div class="order-header d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <span class="font-weight-bold text-dark fs-16">
                                    Đơn hàng #<?= $orderCode ?>
                                </span>
                                <span class="text-muted stext-107 ml-2">
                                    &bull; <?= date('d/m/Y H:i', strtotime($order['order_date'] ?? $order['created_at'])) ?>
                                </span>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                <span class="status-badge <?= $badgeClass ?>">
                                    <i class="fa <?= $badgeIcon ?>"></i> <?= htmlspecialchars($statusText) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body: Items -->
                        <div class="order-body">
                            <?php if (!empty($order['items'])): ?>
                                <?php foreach ($order['items'] as $item): ?>
                                    <?php
                                        $itemImg = !empty($item['product_image']) ? BASE_URL . 'assets/uploads/' . $item['product_image'] : BASE_URL . 'views/images/product-01.jpg';
                                        $pName = $item['product_name'] ?? ('Sản phẩm #' . ($item['product_id'] ?? ''));
                                        $pId = (int)($item['product_id'] ?? 0);
                                    ?>
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light flex-wrap gap-2">
                                        <div class="d-flex align-items-center">
                                            <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $pId ?>">
                                                <img src="<?= $itemImg ?>" alt="<?= htmlspecialchars($pName) ?>" class="item-thumb mr-3" onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg';">
                                            </a>
                                            <div>
                                                <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $pId ?>" class="font-weight-bold text-dark text-decoration-none hov-cl1 trans-04">
                                                    <?= htmlspecialchars($pName) ?>
                                                </a>
                                                <div class="text-muted stext-107 mt-1">
                                                    Số lượng: <?= (int)$item['quantity'] ?> &times; <?= number_format($item['price'], 0, ',', '.') ?> ₫
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right d-flex align-items-center gap-3">
                                            <span class="font-weight-bold text-dark">
                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫
                                            </span>

                                            <!-- Review button when order is completed -->
                                            <?php if ($isCompleted && $pId > 0): ?>
                                                <button type="button" class="btn-review-item ml-2" onclick="openReviewModal(<?= $pId ?>, '<?= htmlspecialchars(addslashes($pName)) ?>', '<?= $itemImg ?>')">
                                                    <i class="fa fa-star text-warning"></i> Viết đánh giá
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Card Footer -->
                        <div class="order-footer d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <span class="stext-102 text-muted">Tổng tiền thanh toán:</span>
                                <span class="mtext-107 text-danger font-weight-bold ml-2">
                                    <?= number_format($order['total_amount'], 0, ',', '.') ?> ₫
                                </span>
                            </div>

                            <div class="mt-2 mt-sm-0 d-flex align-items-center gap-2">
                                <?php if ($canCancel): ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold px-3 py-1 mr-2" style="border-radius: 20px;" onclick="confirmCancelOrder(<?= $id ?>, '<?= $orderCode ?>')">
                                        <i class="fa fa-times mr-1"></i> Hủy đơn
                                    </button>
                                <?php endif; ?>

                                <a href="<?= BASE_URL ?>?action=/order-detail&id=<?= $id ?>" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-1" style="border-radius: 20px;">
                                    <i class="fa fa-eye mr-1"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-order-box">
                <i class="fa fa-shopping-basket fa-4x text-muted mb-3 d-block"></i>
                <h4 class="mtext-105 cl2 font-weight-bold mb-2">Bạn chưa có đơn hàng nào</h4>
                <p class="stext-102 cl6 mb-4">Khám phá ngay hàng trăm mẫu quần áo thời trang cao cấp tại Bunny Wear!</p>
                <a href="<?= BASE_URL ?>?action=/product" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 25px;">
                    Mua sắm ngay bây giờ
                </a>
            </div>
        <?php endif; ?>

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
        function filterOrders(category) {
            $('.order-filter-btn').removeClass('active');
            $(event.target).addClass('active');

            if (category === 'all') {
                $('.order-item-block').fadeIn(200);
            } else {
                $('.order-item-block').hide();
                $('.order-item-block[data-status-group="' + category + '"]').fadeIn(200);
            }
        }

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
                                    location.reload();
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

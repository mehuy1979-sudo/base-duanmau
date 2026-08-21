<?php
// $orders đã được CartController::orderHistory() chuẩn bị sẵn (lấy từ DB theo user_id)

$statusMap = [
    1 => ['name' => 'Chờ xác nhận',          'color' => '#ffc107'],
    2 => ['name' => 'Đã xác nhận',            'color' => '#17a2b8'],
    3 => ['name' => 'Đang giao',              'color' => '#007bff'],
    4 => ['name' => 'Giao hàng thành công',   'color' => '#28a745'],
    5 => ['name' => 'Giao hàng thất bại',     'color' => '#dc3545'],
    6 => ['name' => 'Hoàn thành',             'color' => '#6c757d'],
    7 => ['name' => 'Đã hủy',                 'color' => '#343a40'],
];

$paymentMap = [
    0 => ['name' => 'Chưa thanh toán', 'color' => '#dc3545'],
    1 => ['name' => 'Đã thanh toán',   'color' => '#28a745'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Lịch Sử Mua Hàng - Bunny Wear</title>
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
        .oh-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .oh-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 13.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
            white-space: nowrap;
        }
        .oh-table td {
            vertical-align: middle;
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 14.5px;
        }
        .oh-badge {
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }
        .oh-total {
            font-weight: 700;
            color: #e11d48;
        }
        .oh-empty-box {
            padding: 70px 20px;
            text-align: center;
        }
        .oh-empty-icon {
            width: 90px;
            height: 90px;
            line-height: 90px;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 50%;
            font-size: 42px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-view-order {
            display: inline-block;
            padding: 7px 16px;
            border-radius: 20px;
            border: 1px solid #111;
            color: #111;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-view-order:hover {
            background: #111;
            color: #fff;
            text-decoration: none;
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

                        <?php if (!empty($_SESSION['user'])): ?>
                            <a href="#" class="flex-c-m trans-04 p-lr-25">
                                Xin chào, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>
                            </a>
                            <a href="?action=/logout" class="flex-c-m trans-04 p-lr-25">Đăng xuất</a>
                        <?php else: ?>
                            <a href="?action=/login" class="flex-c-m trans-04 p-lr-25">Đăng nhập</a>
                        <?php endif; ?>

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
                            <li><a href="<?= BASE_URL ?>?action=/compare">So sánh</a></li>
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/order-history">Lịch Sử Mua Hàng</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=/wishlist" class="dis-block icon-header-item cl1 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-wishlist-noti" data-notify="<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>" title="Danh Mục Yêu Thích">
                            <i class="zmdi zmdi-favorite"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?action=/cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
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
                <a href="<?= BASE_URL ?>?action=/order-history" class="dis-block icon-header-item cl1 hov-cl1 trans-04 p-r-11 p-l-10">
                    <i class="zmdi zmdi-format-list-bulleted"></i>
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
                <li><a href="<?= BASE_URL ?>?action=/order-history">Lịch Sử Mua Hàng</a></li>
                <?php if (!empty($_SESSION['user'])): ?>
                    <li><a href="?action=/logout">Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="?action=/login">Đăng nhập</a></li>
                <?php endif; ?>
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
            <span class="stext-109 cl4">Lịch Sử Mua Hàng</span>
        </div>
    </div>

    <!-- Order history content -->
    <section class="bg0 p-t-30 p-b-80">
        <div class="container">
            <div class="p-b-25">
                <h1 class="ltext-105 cl5 font-weight-bold" style="font-size: 26px;">
                    <i class="zmdi zmdi-format-list-bulleted m-r-8"></i>LỊCH SỬ MUA HÀNG
                </h1>
                <p class="stext-107 cl6 m-t-4">
                    Toàn bộ đơn hàng bạn đã đặt, kèm trạng thái xử lý mới nhất.
                </p>
            </div>

            <?php if (!empty($orders)): ?>
                <div class="oh-card">
                    <div class="table-responsive">
                        <table class="oh-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Ngày đặt</th>
                                    <th>Số lượng SP</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Thanh toán</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <?php
                                        $orderStatus   = (int) ($order['order_status'] ?? 1);
                                        $paymentStatus = (int) ($order['payment_status'] ?? 0);
                                        $createdAt     = $order['order_date'] ?? $order['created_at'] ?? null;
                                    ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars((string) $order['id']) ?></td>
                                        <td><?= $createdAt ? date('d/m/Y H:i', strtotime($createdAt)) : 'Chưa ghi nhận' ?></td>
                                        <td><?= (int) ($order['items_count'] ?? 0) ?></td>
                                        <td class="oh-total">
                                            <?= number_format((float) ($order['total_amount'] ?? 0), 0, ',', '.') ?> VNĐ
                                        </td>
                                        <td>
                                            <span class="oh-badge" style="background-color: <?= $statusMap[$orderStatus]['color'] ?? '#ccc' ?>;">
                                                <?= $statusMap[$orderStatus]['name'] ?? 'Không xác định' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="oh-badge" style="background-color: <?= $paymentMap[$paymentStatus]['color'] ?? '#ccc' ?>;">
                                                <?= $paymentMap[$paymentStatus]['name'] ?? 'Chưa xác định' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?action=/order-detail&id=<?= (int) $order['id'] ?>" class="btn-view-order">
                                                Xem chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="oh-card oh-empty-box">
                    <div class="oh-empty-icon">
                        <i class="zmdi zmdi-format-list-bulleted"></i>
                    </div>
                    <h3 class="mtext-105 cl2 font-weight-bold mb-2">Bạn chưa có đơn hàng nào</h3>
                    <p class="stext-107 cl6 mb-4">Hãy khám phá cửa hàng và đặt đơn hàng đầu tiên của bạn nhé!</p>
                    <a href="<?= BASE_URL ?>?action=/product" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-25 trans-04 m-lr-auto" style="max-width: 220px;">
                        Khám phá cửa hàng ngay
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top"><i class="zmdi zmdi-chevron-up"></i></span>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>
</body>
</html>

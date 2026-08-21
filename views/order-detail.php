<?php
// $order và $items đã được CartController::orderDetail() chuẩn bị sẵn (lấy từ DB)

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

$orderStatus   = (int) ($order['order_status'] ?? 1);
$paymentStatus = (int) ($order['payment_status'] ?? 0);
$total         = (float) ($order['total_amount'] ?? 0);
$discount      = (float) ($order['discount'] ?? 0);
$subtotal      = $total + $discount;

$paymentMethod = $order['payment_method'] ?? 'cod';
$paymentText   = $paymentMethod === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Chi Tiết Đơn Hàng #<?= (int) $order['id'] ?> - Bunny Wear</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">
    <style>
        .od-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            padding: 25px;
        }
        .od-badge {
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }
        .od-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 15px;
        }
        .od-row:last-child { border-bottom: none; }
        .od-label { color: #64748b; }
        .od-value { font-weight: 600; text-align: right; }
        .od-value.green { color: #16a34a; }
        .od-total { color: #e11d48; font-size: 20px; }
        .od-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .od-item:last-child { border-bottom: none; }
        .od-item-name { font-weight: 600; }
        .od-item-qty { color: #64748b; margin-left: 8px; }
        .btn-back-history {
            display: inline-block;
            padding: 10px 22px;
            border-radius: 20px;
            border: 1px solid #111;
            color: #111;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-back-history:hover { background: #111; color: #fff; text-decoration: none; }
    </style>
</head>
<body class="animsition">

    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="wrap-menu-desktop how-shadow1">
                <nav class="limiter-menu-desktop container">
                    <a href="<?= BASE_URL ?>" class="logo">
                        <img src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg" alt="IMG-LOGO">
                    </a>
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                            <li><a href="<?= BASE_URL ?>?action=/product">Cửa hàng</a></li>
                            <li class="active-menu"><a href="<?= BASE_URL ?>?action=/order-history">Lịch Sử Mua Hàng</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="container m-t-20">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="<?= BASE_URL ?>?action=/order-history" class="stext-109 cl8 hov-cl1 trans-04">
                Lịch sử mua hàng <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">Đơn hàng #<?= (int) $order['id'] ?></span>
        </div>
    </div>

    <section class="bg0 p-t-30 p-b-80">
        <div class="container" style="max-width: 800px;">

            <div class="d-flex justify-content-between align-items-center flex-wrap p-b-20">
                <h1 class="ltext-105 cl5 font-weight-bold" style="font-size: 24px;">
                    Đơn hàng #<?= (int) $order['id'] ?>
                </h1>
                <div>
                    <span class="od-badge" style="background-color: <?= $statusMap[$orderStatus]['color'] ?? '#ccc' ?>;">
                        <?= $statusMap[$orderStatus]['name'] ?? 'Không xác định' ?>
                    </span>
                    <span class="od-badge" style="background-color: <?= $paymentMap[$paymentStatus]['color'] ?? '#ccc' ?>;">
                        <?= $paymentMap[$paymentStatus]['name'] ?? 'Chưa xác định' ?>
                    </span>
                </div>
            </div>

            <?php if ($orderStatus === 7 && !empty($order['cancel_reason'])): ?>
                <div class="alert alert-danger">
                    <strong>Lý do hủy:</strong> <?= htmlspecialchars($order['cancel_reason']) ?>
                </div>
            <?php endif; ?>

            <div class="od-card mb-4">
                <h3 class="font-weight-bold mb-3" style="font-size: 18px;">Thông tin đơn hàng</h3>

                <div class="od-row">
                    <span class="od-label">Người nhận</span>
                    <span class="od-value"><?= htmlspecialchars($order['customer_name'] ?? '') ?></span>
                </div>
                <div class="od-row">
                    <span class="od-label">Email</span>
                    <span class="od-value"><?= htmlspecialchars($order['email'] ?? '') ?></span>
                </div>
                <div class="od-row">
                    <span class="od-label">Số điện thoại</span>
                    <span class="od-value"><?= htmlspecialchars($order['phone'] ?? '') ?></span>
                </div>
                <div class="od-row">
                    <span class="od-label">Địa chỉ</span>
                    <span class="od-value">
                        <?= htmlspecialchars(($order['address'] ?? '') . ', ' . ($order['district'] ?? '') . ', ' . ($order['city'] ?? '')) ?>
                    </span>
                </div>
                <?php if (!empty($order['note'])): ?>
                <div class="od-row">
                    <span class="od-label">Ghi chú</span>
                    <span class="od-value"><?= htmlspecialchars($order['note']) ?></span>
                </div>
                <?php endif; ?>
                <div class="od-row">
                    <span class="od-label">Phương thức thanh toán</span>
                    <span class="od-value"><?= htmlspecialchars($paymentText) ?></span>
                </div>
                <div class="od-row">
                    <span class="od-label">Ngày đặt hàng</span>
                    <span class="od-value">
                        <?= !empty($order['order_date']) ? date('d/m/Y H:i', strtotime($order['order_date'])) : '' ?>
                    </span>
                </div>
                <?php if (!empty($order['updated_at'])): ?>
                <div class="od-row">
                    <span class="od-label">Cập nhật lần cuối</span>
                    <span class="od-value"><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></span>
                </div>
                <?php endif; ?>
                <div class="od-row">
                    <span class="od-label">Tạm tính</span>
                    <span class="od-value"><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</span>
                </div>
                <?php if (!empty($order['coupon_code'])): ?>
                <div class="od-row">
                    <span class="od-label">Mã giảm giá</span>
                    <span class="od-value green">
                        <?= htmlspecialchars($order['coupon_code']) ?> (−<?= number_format($discount, 0, ',', '.') ?> VNĐ)
                    </span>
                </div>
                <?php endif; ?>
                <div class="od-row">
                    <span class="od-label">Tổng tiền</span>
                    <span class="od-value od-total"><?= number_format($total, 0, ',', '.') ?> VNĐ</span>
                </div>
            </div>

            <div class="od-card mb-4">
                <h3 class="font-weight-bold mb-3" style="font-size: 18px;">Sản phẩm đã đặt</h3>

                <?php foreach (($items ?? []) as $item): ?>
                    <div class="od-item">
                        <div>
                            <span class="od-item-name"><?= htmlspecialchars($item['product_name'] ?? 'Sản phẩm') ?></span>
                            <span class="od-item-qty">x<?= (int) ($item['quantity'] ?? 1) ?></span>
                        </div>
                        <div class="font-weight-bold">
                            <?= number_format((float) ($item['total'] ?? 0), 0, ',', '.') ?> VNĐ
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center">
                <a href="?action=/order-history" class="btn-back-history">
                    <i class="fa fa-angle-left m-r-5"></i> Quay lại lịch sử mua hàng
                </a>
            </div>

        </div>
    </section>

    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

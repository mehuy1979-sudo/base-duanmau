<?php

// $order đã được CartController::orderSuccess() chuẩn bị sẵn (lấy từ DB)
// Không cần đọc lại $_SESSION['order'] nữa

$paymentMethod = $order['payment_method'] ?? 'cod';

if ($paymentMethod === 'cod') {
    $paymentText = 'Thanh toán khi nhận hàng (COD)';
} else {
    $paymentText = 'Chuyển khoản ngân hàng';
}

$total = $order['total'] ?? 0;
$discount = $order['discount'] ?? 0;
$couponCode = $order['coupon_code'] ?? null;
?>
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Đặt hàng thành công</title>

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css"
    >

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: #f2f2f2;

            color: #111;
        }

        .success-container {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;
        }

        .success-box {

            width: 100%;

            max-width: 750px;

            background: #fff;

            padding: 45px;

            text-align: center;

            box-shadow:
                0 10px 40px
                rgba(0, 0, 0, 0.08);
        }

        .success-icon {

            width: 90px;

            height: 90px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #28a745;

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 50px;
        }

        .success-box h1 {

            margin: 0 0 10px;

            font-size: 32px;

            font-weight: 700;

            text-transform: uppercase;
        }

        .success-message {

            color: #666;

            font-size: 16px;

            margin-bottom: 30px;
        }

        .order-info {

            text-align: left;

            border: 1px solid #ddd;

            padding: 25px;

            margin-top: 20px;
        }

        .order-info h3 {

            margin-top: 0;

            margin-bottom: 20px;

            font-size: 20px;

            text-transform: uppercase;
        }

        .info-row {

            display: flex;

            justify-content: space-between;

            gap: 20px;

            padding: 10px 0;

            border-bottom: 1px solid #eee;

            font-size: 15px;
        }

        .info-row:last-child {

            border-bottom: none;
        }

        .info-label {

            color: #666;
        }

        .info-value {

            font-weight: 600;

            text-align: right;
        }

        .info-value.green {
            color: #28a745;
        }

        .total {

            color: #ff3b2a;

            font-size: 20px;
        }

        .product-list {

            text-align: left;

            margin-top: 25px;

            border: 1px solid #ddd;

            padding: 20px;
        }

        .product-list h3 {

            margin-top: 0;

            font-size: 20px;
        }

        .product-item {

            display: flex;

            justify-content: space-between;

            padding: 12px 0;

            border-bottom: 1px solid #eee;
        }

        .product-item:last-child {

            border-bottom: none;
        }

        .product-name {

            font-weight: 600;
        }

        .product-quantity {

            color: #666;

            margin-left: 10px;
        }

        .product-price {

            font-weight: 600;
        }

        .button-group {

            display: flex;

            justify-content: center;

            gap: 15px;

            margin-top: 30px;
        }

        .btn-home {

            display: inline-block;

            padding: 14px 25px;

            background: #111;

            color: #fff;

            text-decoration: none;

            font-weight: 700;

            text-transform: uppercase;
        }

        .btn-home:hover {

            background: #ff3b2a;

            color: #fff;

            text-decoration: none;
        }

        .btn-cart {

            display: inline-block;

            padding: 14px 25px;

            border: 1px solid #111;

            color: #111;

            text-decoration: none;

            font-weight: 700;

            text-transform: uppercase;
        }

        .btn-cart:hover {

            background: #111;

            color: #fff;

            text-decoration: none;
        }

        @media (max-width: 600px) {

            .success-container {
                padding: 15px;
            }

            .success-box {
                padding: 25px 18px;
            }

            .success-box h1 {
                font-size: 24px;
            }

            .info-row {
                flex-direction: column;

                gap: 5px;
            }

            .info-value {
                text-align: left;
            }

            .button-group {
                flex-direction: column;
            }

            .btn-home,
            .btn-cart {
                width: 100%;

                text-align: center;
            }
        }

    </style>

</head>

<body>

<div class="success-container">

    <div class="success-box">

        <!-- ICON THÀNH CÔNG -->

        <div class="success-icon">
            <i class="fa fa-check"></i>
        </div>


        <!-- TIÊU ĐỀ -->

        <h1>
            Đặt hàng thành công!
        </h1>

        <p class="success-message">

            Cảm ơn bạn đã mua hàng tại Striz.

            Đơn hàng của bạn đã được tiếp nhận.

        </p>


        <!-- THÔNG TIN KHÁCH HÀNG -->

        <div class="order-info">

            <h3>
                Thông tin đơn hàng
            </h3>


            <div class="info-row">

                <span class="info-label">
                    Họ và tên
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        $order['customer_name'] ?? ''
                    ) ?>

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Email
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        $order['email'] ?? ''
                    ) ?>

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Số điện thoại
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        $order['phone'] ?? ''
                    ) ?>

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Địa chỉ
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        ($order['address'] ?? '')
                        . ', '
                        . ($order['district'] ?? '')
                        . ', '
                        . ($order['city'] ?? '')
                    ) ?>

                </span>

            </div>


            <?php if (!empty($order['note'])): ?>
            <div class="info-row">

                <span class="info-label">
                    Ghi chú
                </span>

                <span class="info-value">

                    <?= htmlspecialchars($order['note']) ?>

                </span>

            </div>
            <?php endif; ?>


            <div class="info-row">

                <span class="info-label">
                    Phương thức thanh toán
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        $paymentText
                    ) ?>

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Thời gian đặt hàng
                </span>

                <span class="info-value">

                    <?= htmlspecialchars(
                        $order['created_at'] ?? ''
                    ) ?>

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Tạm tính
                </span>

                <span class="info-value">

                    <?= number_format(
                        $order['subtotal'] ?? $total,
                        0,
                        ',',
                        '.'
                    ) ?>

                    VNĐ

                </span>

            </div>


            <?php if (!empty($couponCode)): ?>
            <div class="info-row">

                <span class="info-label">
                    Mã giảm giá
                </span>

                <span class="info-value green">

                    <?= htmlspecialchars($couponCode) ?>
                    (−<?= number_format($discount, 0, ',', '.') ?> VNĐ)

                </span>

            </div>
            <?php endif; ?>


            <div class="info-row">

                <span class="info-label">
                    Tổng tiền
                </span>

                <span class="info-value total">

                    <?= number_format(
                        $total,
                        0,
                        ',',
                        '.'
                    ) ?>

                    VNĐ

                </span>

            </div>

        </div>


        <!-- SẢN PHẨM -->

        <div class="product-list">

            <h3>
                Sản phẩm đã đặt
            </h3>


            <?php foreach (
                ($order['cart'] ?? [])
                as $item
            ): ?>

                <div class="product-item">

                    <div>

                        <span class="product-name">

                            <?= htmlspecialchars(
                                $item['name'] ?? 'Sản phẩm'
                            ) ?>

                        </span>

                        <span class="product-quantity">

                            x<?= (int)
                                ($item['quantity'] ?? 1) ?>

                        </span>

                    </div>


                    <div class="product-price">

                        <?= number_format(
                            $item['total'] ?? 0,
                            0,
                            ',',
                            '.'
                        ) ?>

                        VNĐ

                    </div>

                </div>

            <?php endforeach; ?>

        </div>


        <!-- BUTTON -->

        <div class="button-group">

            <a
                href="<?= BASE_URL ?>"
                class="btn-home"
            >
                Tiếp tục mua hàng
            </a>

            <a
                href="?action=/cart"
                class="btn-cart"
            >
                Về giỏ hàng
            </a>

        </div>

    </div>

</div>

</body>

</html>
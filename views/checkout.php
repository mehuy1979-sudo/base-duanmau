<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #efefef;
            color: #111;
        }

        * {
            box-sizing: border-box;
        }

        .header-top {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.08);
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-inner {
            width: 100%;
            max-width: 1280px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .brand {
            font-size: 52px;
            font-weight: 700;
            font-family: cursive, "Brush Script MT", serif;
            letter-spacing: -2px;
            color: #111;
            line-height: 1;
            transform: rotate(-3deg);
            text-decoration: none;
        }

        .brand span {
            font-family: inherit;
        }

        .menu-row {
            display: flex;
            align-items: center;
            gap: 26px;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            color: #1d1d1d;
        }

        .menu-row a {
            color: #111;
            text-decoration: none;
            opacity: 0.9;
        }

        .menu-row a:hover {
            opacity: 1;
        }

        .icon-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .icon-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #111;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            border: none;
            cursor: pointer;
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.42), rgba(0,0,0,0.42)),
                        url('<?= BASE_URL ?>views/images/slider-02.jpg') center/cover no-repeat;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.18);
        }

        .hero-content {
            position: relative;
            text-align: center;
            z-index: 1;
            color: #fff;
        }

        .hero-content h1 {
            margin: 0;
            font-size: 64px;
            font-weight: 800;
            text-transform: uppercase;
            color: #ff4428;
            letter-spacing: 2px;
            text-shadow: 0 2px 0 rgba(255,255,255,0.2);
        }

        .hero-content .small {
            display: block;
            margin-top: 8px;
            font-size: 15px;
            color: #fff;
            text-transform: none;
            font-weight: 500;
        }

        .hero-content .small span {
            color: #ff4428;
        }

        .page-wrap {
            max-width: 1200px;
            margin: 42px auto 60px;
            display: grid;
            grid-template-columns: 1.5fr 0.9fr;
            gap: 28px;
            padding: 0 16px;
        }

        .panel {
            background: #f4f4f4;
            border: 1px solid #e3e3e3;
            border-radius: 0;
            padding: 26px 24px;
            box-shadow: 0 1px 0 rgba(0,0,0,0.02);
        }

        .panel-title {
            margin: 0 0 22px;
            font-size: 18px;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 110px 1fr auto auto;
            gap: 18px;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #e1e1e1;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .product-thumb {
            width: 100px;
            height: 100px;
            border-radius: 2px;
            background: linear-gradient(135deg, #a9b39f, #e5e0d7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-meta h4 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 700;
        }

        .product-meta p {
            margin: 0;
            font-size: 14px;
            color: #5d5d5d;
        }

        .price {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            white-space: nowrap;
        }

        .price.red {
            color: #ff3f2d;
        }

        .checkout-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 18px;
            margin-top: 12px;
        }

        .checkout-form .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            grid-column: span 1;
        }

        .checkout-form .field.full {
            grid-column: 1 / -1;
        }

        .checkout-form label {
            font-size: 13px;
            color: #444;
            font-weight: 600;
        }

        .checkout-form input,
        .checkout-form select,
        .checkout-form textarea {
            width: 100%;
            min-height: 42px;
            border: 1px solid #d8d8d8;
            background: #fff;
            padding: 10px 12px;
            font-size: 14px;
            color: #111;
        }

        .checkout-form textarea {
            min-height: 112px;
            resize: vertical;
        }

        .summary-box {
            padding: 12px 0 0;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            font-size: 16px;
            border-bottom: 1px dashed #ddd;
        }

        .summary-line .label {
            color: #555;
        }

        .summary-line .value {
            font-weight: 700;
            color: #111;
        }

        .summary-line .value.red {
            color: #ff3b2a;
        }

        .checkout-btn {
            margin-top: 10px;
            width: 100%;
            border: none;
            background: #111;
            color: #fff;
            padding: 18px 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .checkout-btn:hover {
            background: #000;
        }

        .link-back {
            display: inline-block;
            margin-top: 16px;
            text-align: center;
            width: 100%;
            color: #ff3b2a;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }

            .menu-row {
                display: none;
            }

            .header-inner {
                padding: 0 18px;
            }

            .brand {
                font-size: 40px;
            }
        }

        @media (max-width: 620px) {
            .hero {
                height: 190px;
            }

            .hero-content h1 {
                font-size: 34px;
            }

            .checkout-form {
                grid-template-columns: 1fr;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
            }

            .price {
                grid-column: 2;
            }
        }
    </style>
</head>
<body>
    <header class="header-top">
        <div class="header-inner">
            <a href="<?= BASE_URL ?>" class="brand"><span>S</span>triz</a>

            <nav class="menu-row">
                <a href="#">Trang chủ</a>
                <a href="#">Chời trang nam</a>
                <a href="#">Thời trang nữ</a>
                <a href="#">Giày</a>
                <a href="#">Blog</a>
                <a href="#">Liên hệ</a>
            </nav>

            <div class="icon-row">
                <button class="icon-btn"><i class="zmdi zmdi-search"></i></button>
                <button class="icon-btn"><i class="zmdi zmdi-account"></i></button>
                <button class="icon-btn"><i class="zmdi zmdi-shopping-cart"></i></button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Đơn Hàng</h1>
            <div class="small"><span>Trang chủ</span> &nbsp;> &nbsp; Đơn hàng</div>
        </div>
    </section>

    <main class="page-wrap">
        <section class="panel">
            <h2 class="panel-title">Thông tin đặt hàng</h2>

            <div class="cart-item">
                <div class="product-thumb">hoodie</div>
                <div class="product-meta">
                    <h4>Tiger Hoody</h4>
                    <p>Size: L</p>
                </div>
                <div class="price">1</div>
                <div class="price red">1,600,000 VNĐ</div>
            </div>

            <form class="checkout-form" method="POST" action="#">
                <div class="field full">
                    <label>Họ và tên</label>
                    <input type="text" placeholder="Nhập họ và tên" value="">
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" placeholder="Nhập email" value="">
                </div>

                <div class="field">
                    <label>Số điện thoại</label>
                    <input type="tel" placeholder="Nhập số điện thoại" value="">
                </div>

                <div class="field full">
                    <label>Số nhà ngõ đường</label>
                    <input type="text" placeholder="Nhập địa chỉ" value="">
                </div>

                <div class="field">
                    <label>Tỉnh / Thành phố</label>
                    <select>
                        <option>-- Tỉnh / Thành phố --</option>
                        <option>Hà Nội</option>
                        <option>Đà Nẵng</option>
                        <option>Hồ Chí Minh</option>
                    </select>
                </div>

                <div class="field">
                    <label>Quận / Huyện</label>
                    <select>
                        <option>-- Quận / Huyện --</option>
                        <option>Quận 1</option>
                        <option>Quận 7</option>
                        <option>Ba Đình</option>
                    </select>
                </div>

                <div class="field full">
                    <label>Ghi chú</label>
                    <textarea placeholder="Ghi chú đơn hàng"></textarea>
                </div>
            </form>
        </section>

        <aside class="panel summary-box">
            <div class="summary-line">
                <span class="label">Đơn giá</span>
                <span class="value">1,600,000 VNĐ</span>
            </div>
            <div class="summary-line">
                <span class="label">Thành tiền</span>
                <span class="value red">1,600,000 VNĐ</span>
            </div>

            <button class="checkout-btn" type="button">Thanh toán</button>
            <a class="link-back" href="?action=/cart">← Quay lại giỏ hàng</a>
        </aside>
    </main>
</body>
</html>

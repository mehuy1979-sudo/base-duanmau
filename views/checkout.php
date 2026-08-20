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

        .checkout-form select:disabled {
            background: #f2f2f2;
            color: #999;
            cursor: not-allowed;
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

        .summary-line .value.green {
            color: #28a745;
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
        .payment-method {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 5px;
}

.payment-option {
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    gap: 10px;
    padding: 14px;
    background: #fff;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: 0.2s;
}

.payment-option:hover {
    border-color: #111;
}

.payment-option input {
    width: 18px !important;
    height: 18px;
    min-height: auto !important;
    margin: 0;
}

.payment-option span {
    font-size: 14px;
    font-weight: 600;
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

        .error-box {
            background: #fdecea;
            border: 1px solid #f5c2c0;
            color: #b3261e;
            padding: 14px 16px;
            margin-bottom: 20px;
            font-size: 14px;
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

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="error-box"><?= htmlspecialchars($_SESSION['error']) ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php foreach ($cart as $item): ?>
    <div class="cart-item">

        <div class="product-thumb">
            <?php if (!empty($item['image'])): ?>
                <img
                    src="<?= BASE_URL ?>views/images/<?= htmlspecialchars($item['image']) ?>"
                    alt="<?= htmlspecialchars($item['name']) ?>"
                    style="width:100%; height:100%; object-fit:cover;"
                >
            <?php else: ?>
                hoodie
            <?php endif; ?>
        </div>

        <div class="product-meta">
            <h4><?= htmlspecialchars($item['name']) ?></h4>

            <?php if (!empty($item['size'])): ?>
                <p>Size: <?= htmlspecialchars($item['size']) ?></p>
            <?php endif; ?>
        </div>

        <div class="price">
            <?= (int) $item['quantity'] ?>
        </div>

        <div class="price red">
            <?= number_format($item['total'], 0, ',', '.') ?> VNĐ
        </div>

    </div>
<?php endforeach; ?>

            <form class="checkout-form" method="POST" action="?action=/place-order" id="checkoutForm">

    <div class="field full">
        <label>Họ và tên</label>

        <input
            type="text"
            name="customer_name"
            placeholder="Nhập họ và tên"
            value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>"
            required
        >
    </div>


    <div class="field">
        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Nhập email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
        >
    </div>


    <div class="field">
        <label>Số điện thoại</label>

        <input
            type="tel"
            name="phone"
            placeholder="Nhập số điện thoại"
            pattern="^[0-9]{9,11}$"
            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
            required
        >
    </div>


    <div class="field full">
        <label>Số nhà ngõ đường</label>

        <input
            type="text"
            name="address"
            placeholder="Nhập địa chỉ"
            value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
            required
        >
    </div>


    <div class="field">
        <label>Tỉnh / Thành phố</label>

        <select name="city" id="city-select" required>

            <option value="">
                -- Tỉnh / Thành phố --
            </option>

            <option value="Hà Nội">Hà Nội</option>
            <option value="Đà Nẵng">Đà Nẵng</option>
            <option value="Hồ Chí Minh">Hồ Chí Minh</option>

        </select>
    </div>


    <div class="field">
        <label>Quận / Huyện</label>

        <select name="district" id="district-select" required disabled>
            <option value="">-- Chọn tỉnh/thành trước --</option>
        </select>
    </div>


    <div class="field full">
        <label>Ghi chú</label>

        <textarea
            name="note"
            placeholder="Ghi chú đơn hàng"
        ><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
    </div>


    <!-- PHƯƠNG THỨC THANH TOÁN -->

    <div class="field full">

        <label>Phương thức thanh toán</label>

        <div class="payment-method">

            <label class="payment-option">

                <input
                    type="radio"
                    name="payment_method"
                    value="cod"
                    checked
                >

                <span>
                    💵 Thanh toán khi nhận hàng (COD)
                </span>

            </label>


            <label class="payment-option">

                <input
                    type="radio"
                    name="payment_method"
                    value="bank"
                >

                <span>
                    🏦 Chuyển khoản ngân hàng
                </span>

            </label>

        </div>

    </div>


    <!-- NÚT ĐẶT HÀNG -->

    <div class="field full">

        <button
            class="checkout-btn"
            type="submit"
        >
            Đặt hàng
        </button>

    </div>

</form>
        </section>

        <aside class="panel summary-box">

    <div class="summary-line">

        <span class="label">
            Đơn giá
        </span>

        <span class="value">
            <?= number_format($subtotal, 0, ',', '.') ?> VNĐ
        </span>

    </div>

    <?php if (!empty($coupon_code)): ?>
    <div class="summary-line">

        <span class="label">
            Giảm giá (<?= htmlspecialchars($coupon_code) ?>)
        </span>

        <span class="value green">
            −<?= number_format($discount, 0, ',', '.') ?> VNĐ
        </span>

    </div>
    <?php endif; ?>

    <div class="summary-line">

        <span class="label">
            Phí vận chuyển
        </span>

        <span class="value">
            <?= number_format($shipping, 0, ',', '.') ?> VNĐ
        </span>

    </div>


    <div class="summary-line">

        <span class="label">
            Thành tiền
        </span>

        <span class="value red">
            <?= number_format($total, 0, ',', '.') ?> VNĐ
        </span>

    </div>


    <a
        class="link-back"
        href="?action=/cart"
    >
        ← Quay lại giỏ hàng
    </a>

</aside>
    </main>

    <script>
        // Danh sách quận/huyện theo từng tỉnh/thành phố
        const districtData = {
            "Hà Nội": ["Ba Đình", "Cầu Giấy", "Đống Đa", "Hai Bà Trưng", "Hoàn Kiếm", "Thanh Xuân"],
            "Đà Nẵng": ["Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn", "Liên Chiểu"],
            "Hồ Chí Minh": ["Quận 1", "Quận 3", "Quận 5", "Bình Thạnh", "Tân Bình", "Gò Vấp"]
        };

        const citySelect = document.getElementById('city-select');
        const districtSelect = document.getElementById('district-select');

        function populateDistricts(cityName, selectedDistrict) {
            const districts = districtData[cityName] || [];

            districtSelect.innerHTML = '';

            if (districts.length === 0) {
                districtSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành trước --</option>';
                districtSelect.disabled = true;
                return;
            }

            districtSelect.disabled = false;
            districtSelect.innerHTML = '<option value="">-- Quận / Huyện --</option>';

            districts.forEach(function (d) {
                const opt = document.createElement('option');
                opt.value = d;
                opt.textContent = d;
                if (d === selectedDistrict) {
                    opt.selected = true;
                }
                districtSelect.appendChild(opt);
            });
        }

        citySelect.addEventListener('change', function () {
            populateDistricts(this.value, '');
        });

        // Khôi phục lựa chọn cũ nếu form bị submit lại do lỗi validate
        document.addEventListener('DOMContentLoaded', function () {
            const preselectedCity = <?= json_encode($_POST['city'] ?? '') ?>;
            const preselectedDistrict = <?= json_encode($_POST['district'] ?? '') ?>;

            if (preselectedCity) {
                citySelect.value = preselectedCity;
                populateDistricts(preselectedCity, preselectedDistrict);
            }
        });

        // Validate phía client trước khi submit
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            let valid = true;
            this.querySelectorAll('[required]').forEach(function (field) {
                if (!field.checkValidity()) {
                    valid = false;
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ và đúng định dạng thông tin.');
            }
        });
    </script>
</body>
</html>
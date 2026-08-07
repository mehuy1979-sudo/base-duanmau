<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Giỏ Hàng</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/slick/slick.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/MagnificPopup/magnific-popup.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/perfect-scrollbar/perfect-scrollbar.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">

    <style>
        .cart-container {
            padding: 50px 0;
        }

        .cart-breadcrumb {
            margin-bottom: 30px;
            font-size: 14px;
        }

        .cart-breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .cart-breadcrumb a:hover {
            color: #333;
        }

        .cart-table {
            background: white;
            border: 1px solid #e0e0e0;
            margin-bottom: 30px;
        }

        .cart-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th {
            background: #f9f9f9;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
        }

        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-img {
            width: 80px;
            height: 80px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .product-img img {
            max-width: 100%;
            max-height: 100%;
        }

        .product-name {
            color: #333;
            font-weight: 500;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            width: 90px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
        }

        .quantity-input button {
            background: none;
            border: none;
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #666;
            font-size: 16px;
        }

        .quantity-input button:hover {
            background: #f5f5f5;
        }

        .quantity-input input {
            border: none;
            width: 30px;
            text-align: center;
            font-size: 14px;
            outline: none;
        }

        .price {
            color: #333;
            font-weight: 500;
            min-width: 80px;
            text-align: right;
        }

        .remove-btn {
            color: #ccc;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s;
        }

        .remove-btn:hover {
            color: #d32f2f;
        }

        .cart-row-last td {
            border-bottom: none;
        }

        .cart-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 15px;
            background: #f9f9f9;
            border-top: 1px solid #e0e0e0;
            gap: 15px;
            flex-wrap: wrap;
        }

        .coupon-form {
            display: flex;
            gap: 10px;
            flex: 1;
            min-width: 300px;
        }

        .coupon-form input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            font-size: 13px;
        }

        .coupon-form input::placeholder {
            color: #999;
        }

        .btn-apply-coupon {
            padding: 10px 30px;
            background: #e0e0e0;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-apply-coupon:hover {
            background: #d0d0d0;
        }

        .btn-update-cart {
            padding: 10px 30px;
            background: #e0e0e0;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-update-cart:hover {
            background: #d0d0d0;
        }

        .cart-totals {
            background: white;
            border: 1px solid #e0e0e0;
            padding: 30px 25px;
            width: 100%;
        }

        .cart-totals h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .totals-row label {
            color: #666;
            margin: 0;
        }

        .totals-row .amount {
            color: #333;
            font-weight: 500;
        }

        .shipping-row {
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .shipping-row label {
            color: #666;
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .shipping-row p {
            color: #999;
            font-size: 12px;
            margin: 0 0 10px 0;
        }

        .shipping-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            font-size: 13px;
            background: white;
            cursor: pointer;
        }

        .shipping-fields {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .shipping-fields input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            font-size: 13px;
        }

        .shipping-fields input::placeholder {
            color: #999;
        }

        .totals-row.total-row {
            border-bottom: none;
            font-weight: 600;
            font-size: 16px;
            padding: 20px 0;
        }

        .totals-row.total-row .amount {
            font-size: 18px;
            color: #333;
        }

        .btn-checkout {
            width: 100%;
            padding: 15px;
            background: #333;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-checkout:hover {
            background: #1a1a1a;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }

        .empty-cart p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn-continue-shopping {
            display: inline-block;
            padding: 10px 30px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-continue-shopping:hover {
            background: #1a1a1a;
        }

        @media (max-width: 768px) {
            .cart-table table {
                font-size: 12px;
            }

            .cart-table th,
            .cart-table td {
                padding: 10px;
            }

            .product-img {
                width: 60px;
                height: 60px;
            }

            .cart-bottom {
                flex-direction: column;
                align-items: stretch;
            }

            .coupon-form {
                flex-direction: column;
                min-width: auto;
            }

            .coupon-form input,
            .btn-apply-coupon,
            .btn-update-cart {
                width: 100%;
            }

            .cart-totals {
                margin-top: 20px;
            }

            .quantity-input {
                width: 70px;
            }
        }
    </style>
</head>

<body>

 <header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Miễn phí vận chuyển cho đơn hàng trên $100
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Trợ Giúp & Câu Hỏi
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Tài Khoản
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Tiếng Việt
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							USD
						</a>
					</div>
				</div>
			</div>

			<!-- Menu -->
			<div class="wrap-menu-desktop">
				<nav class="menu-desktop">
					<a href="<?= BASE_URL ?>" class="logo">
						<img src="<?= BASE_URL ?>views/images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<div class="menu-desktop-main">
						<a href="<?= BASE_URL ?>" class="menu-desktop-link">
							Trang Chủ
						</a>

						<a href="#" class="menu-desktop-link">
							Cửa Hàng
						</a>

						<a href="#" class="menu-desktop-link">
							Đặc Sắc
						</a>

						<a href="#" class="menu-desktop-link">
							Blog
						</a>

						<a href="#" class="menu-desktop-link">
							Về Chúng Tôi
						</a>

						<a href="#" class="menu-desktop-link">
							Liên Hệ
						</a>
					</div>

					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl-2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="#" class="icon-header-item cl-2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-link">
							<i class="zmdi zmdi-favorite"></i>
						</a>
					</div>
				</nav>
			</div>
		</div>
	</header>

    <!-- Main Content -->
    <div class="container cart-container">
        <div class="cart-breadcrumb">
            <a href="<?= BASE_URL ?>">Trang Chủ</a>
            <span> > </span>
            <span>Giỏ Hàng</span>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <?php if (empty($cart)): ?>
                    <div class="empty-cart">
                        <p>Giỏ hàng của bạn đang trống</p>
                        <a href="<?= BASE_URL ?>" class="btn-continue-shopping">Tiếp Tục Mua Sắm</a>
                    </div>
                <?php else: ?>
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>SẢN PHẨM</th>
                                    <th>GIÁ</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>TỔNG CỘNG</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $index => $item): ?>
                                    <tr class="<?= $index === count($cart) - 1 ? 'cart-row-last' : '' ?>">
                                        <td>
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <img src="<?= BASE_URL ?>views/images/icons/product-01.jpg" alt="<?= $item['name'] ?>">
                                                </div>
                                                <span class="product-name"><?= htmlspecialchars($item['name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="price">$<?= number_format($item['price'], 2) ?></td>
                                        <td>
                                            <div class="quantity-input">
                                                <button type="button" onclick="decreaseQuantity(this)">−</button>
                                                <input type="number" min="1" value="<?= $item['quantity'] ?>" readonly>
                                                <button type="button" onclick="increaseQuantity(this)">+</button>
                                            </div>
                                        </td>
                                        <td class="price">$<?= number_format($item['total'], 2) ?></td>
                                        <td>
                                            <a href="?action=/cart/remove&id=<?= $item['id'] ?>" class="remove-btn" title="Xóa">
                                                <i class="zmdi zmdi-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="cart-bottom">
                        <form method="POST" action="?action=/cart/update" class="coupon-form">
                            <input type="text" name="coupon_code" placeholder="Mã Giảm Giá" required>
                            <button type="submit" class="btn-apply-coupon">ÁP DỤNG MÃ</button>
                        </form>
                        <button type="button" onclick="updateCart()" class="btn-update-cart">CẬP NHẬT GIỎ</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="cart-totals">
                    <h4>TỔNG GIỎ HÀNG</h4>

                    <div class="totals-row">
                        <label>Tạm Tính:</label>
                        <span class="amount">$<?= number_format($subtotal, 2) ?></span>
                    </div>

                    <div class="shipping-row">
                        <label>Vận Chuyển:</label>
                        <p>Không có phương thức vận chuyển nào có sẵn. Vui lòng kiểm tra lại địa chỉ của bạn hoặc liên hệ với chúng tôi nếu bạn cần hỗ trợ.</p>
                        <label>TÍNH PHÍ VẬN CHUYỂN</label>
                        <select class="shipping-select" onchange="calculateShipping()">
                            <option value="">Chọn quốc gia...</option>
                            <option value="vn">Việt Nam</option>
                            <option value="us">Hoa Kỳ</option>
                            <option value="jp">Nhật Bản</option>
                        </select>

                        <div class="shipping-fields">
                            <input type="text" placeholder="Tỉnh / Thành Phố" id="state">
                            <input type="text" placeholder="Mã Bưu Chính / Zip" id="zip">
                        </div>
                    </div>

                    <div class="totals-row">
                        <label>Vận Chuyển:</label>
                        <span class="amount">$<?= number_format($shipping, 2) ?></span>
                    </div>

                    <div class="totals-row total-row">
                        <label>Tổng Cộng:</label>
                        <span class="amount">$<?= number_format($total, 2) ?></span>
                    </div>

                    <button class="btn-checkout" onclick="proceedToCheckout()">THANH TOÁN</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Danh Mục
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Phụ Nữ
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Đàn Ông
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Giày
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Đồng Hồ
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Liên Kết
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Về Chúng Tôi
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Liên Hệ
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Chính Sách
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Điều Khoản
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Theo Dõi
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Facebook
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Instagram
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Twitter
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-286 cl7 hov-cl1 trans-04">
                                Pinterest
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Liên Hệ
                    </h4>

                    <div class="stext-107 cl7 size-201">
                        <p class="p-b-18">
                            Bất kỳ câu hỏi? Gọi cho chúng tôi 24/7 tại:
                        </p>

                        <p class="s-text-107 cl7">
                            <span class="cl3">+1 800 1236879</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src="<?= BASE_URL ?>views/images/icons/pay-01.png" alt="IMG-PAYMENT">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="<?= BASE_URL ?>views/images/icons/pay-02.png" alt="IMG-PAYMENT">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="<?= BASE_URL ?>views/images/icons/pay-03.png" alt="IMG-PAYMENT">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="<?= BASE_URL ?>views/images/icons/pay-04.png" alt="IMG-PAYMENT">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="<?= BASE_URL ?>views/images/icons/pay-05.png" alt="IMG-PAYMENT">
                    </a>
                </div>

                <div class="t-center p-t-28 p-b-17">
                    <a href="#" class="t-center trans-04">
                        Nội Dung © 2024 - Bản Quyền Đặc Biệt
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/select2/select2.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/slick/slick.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/slick-custom.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/parallax100/parallax100.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>

    <script>
        function increaseQuantity(btn) {
            const input = btn.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantity(btn) {
            const input = btn.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function updateCart() {
            // Implement update cart logic
            alert('Giỏ hàng đã được cập nhật');
        }

        function calculateShipping() {
            const country = document.querySelector('.shipping-select').value;
            const state = document.getElementById('state').value;
            const zip = document.getElementById('zip').value;

            if (country && state && zip) {
                alert(`Đã tính phí vận chuyển cho: ${country} - ${state} - ${zip}`);
            } else {
                alert('Vui lòng điền đầy đủ thông tin');
            }
        }

        function proceedToCheckout() {
            alert('Chuyển tới trang thanh toán');
            // window.location.href = '?action=/checkout';
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Detail</title>
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
        .breadcrumb-section {
            position: relative;
            z-index: 10;
           
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            clear: both;
            margin-top:80px;
            border-top: 1px solid #ddd;
            
        }
        .breadcrumb-section .breadcrumb {
            padding: 0;
        }
        .breadcrumb-section .breadcrumb-item {
            font-size: 14px;
            color: #999;
        }
        .breadcrumb-section .breadcrumb-item a {
            color: #999;
            text-decoration: none;
        }
        .breadcrumb-section .breadcrumb-item a:hover {
            color: #666;
        }
        .breadcrumb-section .breadcrumb-item.active {
            color: #999;
        }
        .breadcrumb-section .breadcrumb-item + .breadcrumb-item::before {
            content: " > ";
            padding: 0 5px;
            color: #999;
        }
        .menu-mobile {
            display: none;
        }
        @media (max-width: 768px) {
            .container-menu-desktop {
                display: none;
            }
            .menu-mobile {
                display: block;
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
						Free shipping for standard order over $100
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							My Account
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							EN
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							USD
						</a>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->
                    <a href="<?= BASE_URL ?>" class="logo">
                        <img src="<?= BASE_URL ?>views/images/icons/logo-01.png" alt="IMG-LOGO">
                    </a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.html">Trang chủ</a>
								<ul class="sub-menu">
									<li><a href="index.html">Homepage 1</a></li>
									<li><a href="home-02.html">Homepage 2</a></li>
									<li><a href="home-03.html">Homepage 3</a></li>
								</ul>
							</li>

							<li>
								<a href="product.html">Sản Phẩm</a>
							</li>

							<li class="label1" data-label1="hot">
								<a href="shoping-cart.html">Giỏ hàng</a>
							</li>

							<li>
								<a href="blog.html">Danh Mục Yêu Thích</a>
							</li>

							<li>
								<a href="about.html"></a>
							</li>

							<li>
								<a href="contact.html">Contact</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo mobile -->
            <div class="logo-mobile">
                <a href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg" alt="IMG-LOGO">
                </a>
            </div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							EN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							USD
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="views/images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

    <?php
    $product = $product ?? [];
    $productName = $product['name'] ?? 'Lightweight Jacket';
    $productPrice = (float) ($product['price'] ?? 29.99);
    $productDescription = $product['description'] ?? 'No description available.';

    $galleryImages = [];
    if (!empty($product['image'])) {
        $galleryImages[] = BASE_URL . 'assets/uploads/' . $product['image'];
    }

    $galleryImages = array_values(array_unique(array_merge($galleryImages, [
        BASE_URL . 'views/images/product-detail-01.jpg',
        BASE_URL . 'views/images/product-detail-02.jpg',
        BASE_URL . 'views/images/product-detail-03.jpg'
    ])));

    if (count($galleryImages) > 3) {
        $galleryImages = array_slice($galleryImages, 0, 3);
    }
    ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>product.html">Men</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($productName) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="border rounded p-3 bg-light">
                    <div class="d-flex align-items-start" style="gap: 12px;">
                        <div class="d-flex flex-column" style="gap: 10px;">
                            <?php foreach ($galleryImages as $index => $image): ?>
                                <button type="button" class="thumbnail-btn border rounded p-1 bg-white <?= $index === 0 ? 'border-dark' : '' ?>" data-image="<?= $image ?>" style="width: 84px; height: 84px; overflow: hidden; flex-shrink: 0;">
                                    <img src="<?= $image ?>" alt="Thumbnail" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <a id="main-product-link" href="<?= $galleryImages[0] ?? BASE_URL . 'views/images/product-detail-01.jpg' ?>" target="_blank" class="flex-grow-1">
                            <img id="main-product-image" src="<?= $galleryImages[0] ?? BASE_URL . 'views/images/product-detail-01.jpg' ?>" alt="IMG-PRODUCT" class="img-fluid w-100" style="max-height: 420px; object-fit: cover;">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        <?= htmlspecialchars($productName) ?>
                    </h4>

                    <span class="mtext-106 cl2">
                        $<?= number_format($productPrice, 2) ?>
                    </span>

                    <p class="stext-102 cl3 p-t-23">
                        <?= nl2br(htmlspecialchars($productDescription)) ?>
                    </p>

                    <div class="p-t-33">
                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Size
                            </div>
                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select class="js-select2" name="size">
                                        <option>Chọn</option>
                                        <option>Size S</option>
                                        <option>Size M</option>
                                        <option>Size L</option>
                                        <option>Size XL</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Color
                            </div>
                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select class="js-select2" name="color">
                                        <option>Chọn</option>
                                        <option>Red</option>
                                        <option>Blue</option>
                                        <option>White</option>
                                        <option>Grey</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-section" style="background-color: #2a2a2a; color: #ccc; padding: 60px 0 40px; margin-top: 80px;">
        <div class="container">
            <div class="row" style="margin-bottom: 50px;">
                <!-- Categories -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Categories</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Women</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Men</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Shoes</a></li>
                        <li><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Watches</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Help</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Track Order</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Returns</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">Shipping</a></li>
                        <li><a href="#" style="color: #999; text-decoration: none; transition: color 0.3s;">FAQs</a></li>
                    </ul>
                </div>

                <!-- Get In Touch -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Get In Touch</h5>
                    <p style="color: #999; line-height: 1.8; margin-bottom: 20px;">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
                    </p>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="color: #999; font-size: 18px; transition: color 0.3s;"><i class="fa fa-facebook"></i></a>
                        <a href="#" style="color: #999; font-size: 18px; transition: color 0.3s;"><i class="fa fa-instagram"></i></a>
                        <a href="#" style="color: #999; font-size: 18px; transition: color 0.3s;"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <h5 style="color: #fff; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Newsletter</h5>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <input type="email" placeholder="email@example.com" style="padding: 12px 15px; border: none; border-radius: 20px; background-color: #f5f5f5; color: #333; font-size: 14px;">
                        <button style="padding: 12px 30px; background-color: #5b6df2; color: white; border: none; border-radius: 25px; font-weight: bold; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: background-color 0.3s;">Subscribe</button>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div style="border-top: 1px solid #444; padding-top: 30px; text-align: center;">
                <p style="color: #666; margin-bottom: 15px; font-size: 13px;">We Accept</p>
                <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                    <img src="<?= BASE_URL ?>views/images/icons/icon-pay-01.png" alt="PayPal" style="height: 32px; background: white; padding: 5px 10px; border-radius: 4px;">
                    <img src="<?= BASE_URL ?>views/images/icons/icon-pay-02.png" alt="Visa" style="height: 32px; background: white; padding: 5px 10px; border-radius: 4px;">
                    <img src="<?= BASE_URL ?>views/images/icons/icon-pay-03.png" alt="Mastercard" style="height: 32px; background: white; padding: 5px 10px; border-radius: 4px;">
                    <img src="<?= BASE_URL ?>views/images/icons/icon-pay-04.png" alt="American Express" style="height: 32px; background: white; padding: 5px 10px; border-radius: 4px;">
                    <img src="<?= BASE_URL ?>views/images/icons/icon-pay-05.png" alt="Discover" style="height: 32px; background: white; padding: 5px 10px; border-radius: 4px;">
                </div>
            </div>
        </div>
    </footer>

    <style>
        a:hover {
            color: #fff !important;
        }
    </style>
    <!-- jQuery MUST be loaded first -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function () {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        });
    </script>
    <script src="<?= BASE_URL ?>views/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/slick/slick.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/slick-custom.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/parallax100/parallax100.js"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <script src="<?= BASE_URL ?>views/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.thumbnail-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const image = this.getAttribute('data-image');
                    const mainImage = document.getElementById('main-product-image');
                    const mainLink = document.getElementById('main-product-link');

                    if (mainImage && mainLink) {
                        mainImage.src = image;
                        mainLink.href = image;
                    }

                    document.querySelectorAll('.thumbnail-btn').forEach(function (item) {
                        item.classList.remove('border-dark');
                    });
                    this.classList.add('border-dark');
                });
            });
        });
    </script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>
</body>
</html>

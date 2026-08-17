<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Đăng Nhập</title>

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
        .auth-container {
            padding: 60px 0;
            display: flex;
            justify-content: center;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 40px 35px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .auth-group {
            margin-bottom: 18px;
        }

        .auth-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .auth-group input {
            width: 100%;
            padding: 11px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .auth-group input:focus {
            border-color: #333;
        }

        .btn-auth-submit {
            width: 100%;
            padding: 12px;
            background: #333;
            border: 1px solid #333;
            border-radius: 3px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-auth-submit:hover {
            background: #1a1a1a;
        }

        .auth-footer-text {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #666;
        }

        .auth-footer-text a {
            color: #333;
            font-weight: 600;
            text-decoration: underline;
        }

        .alert-box {
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 3px;
        }

        .alert-success {
            background: #e6f7ec;
            border: 1px solid #b7e4c7;
            color: #1e7e34;
        }

        .alert-error {
            background: #fdecea;
            border: 1px solid #f5c2c0;
            color: #b3261e;
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
                            Trợ Giúp &amp; Câu Hỏi
                        </a>

                        <a href="?action=/login" class="flex-c-m trans-04 p-lr-25">
                            Đăng Nhập
                        </a>

                        <a href="?action=/register" class="flex-c-m trans-04 p-lr-25">
                            Đăng Ký
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="wrap-menu-desktop">
                <nav class="menu-desktop">
                    <a href="<?= BASE_URL ?>" class="logo">
                        <img src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg" alt="IMG-LOGO">
                    </a>

                    <div class="menu-desktop-main">
                        <a href="<?= BASE_URL ?>" class="menu-desktop-link">
                            Trang Chủ
                        </a>

                        <a href="?action=/product" class="menu-desktop-link">
                            Cửa Hàng
                        </a>

                        <a href="?action=/cart" class="menu-desktop-link">
                            Giỏ Hàng
                        </a>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl-2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="container auth-container">
        <div class="auth-box">
            <div class="auth-title">Đăng Nhập</div>
            <div class="auth-subtitle">Đăng nhập để tiếp tục mua sắm cùng chúng tôi</div>

            <?php if (!empty($success)): ?>
                <div class="alert-box alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert-box alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="?action=/login/submit" method="POST">
                <div class="auth-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>

                <div class="auth-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>

                <button type="submit" class="btn-auth-submit">Đăng Nhập</button>
            </form>

            <div class="auth-footer-text">
                Bạn chưa có tài khoản? <a href="?action=/register">Đăng ký ngay</a>
            </div>
        </div>
    </div>

    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="p-t-10">
                <p class="stext-107 cl6 txt-center">
                    Copyright &copy; <?= date('Y') ?> Bunnywear. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

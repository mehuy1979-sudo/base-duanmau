<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng Nhập - Bunny Wear</title>
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
        .auth-wrapper {
            min-height: calc(100vh - 250px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 15px;
            background: #f8fafc;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid #edf2f7;
            padding: 40px 35px;
            transition: all .3s ease;
        }

        .auth-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.09);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-brand-icon {
            width: 56px;
            height: 56px;
            background: #eff6ff;
            color: #717fe0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            color: #718096;
            font-size: 14px;
        }

        .form-group-custom {
            margin-bottom: 20px;
        }

        .form-group-custom label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
        }

        .input-wrapper input {
            width: 100%;
            height: 48px;
            padding: 10px 42px 10px 42px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14.5px;
            color: #2d3748;
            outline: none;
            transition: all 0.25s ease;
        }

        .input-wrapper input:focus {
            background: #fff;
            border-color: #717fe0;
            box-shadow: 0 0 0 3.5px rgba(113, 127, 224, 0.15);
        }

        .btn-toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            outline: none;
            padding: 0;
        }

        .btn-toggle-password:hover {
            color: #4a5568;
        }

        .btn-auth-primary {
            width: 100%;
            height: 48px;
            background: #717fe0;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .btn-auth-primary:hover {
            background: #5b69c7;
            box-shadow: 0 4px 12px rgba(113, 127, 224, 0.35);
        }

        .auth-footer-nav {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #718096;
        }

        .auth-footer-nav a {
            color: #717fe0;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer-nav a:hover {
            text-decoration: underline;
        }

        .alert-custom {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .alert-custom-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-custom-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body class="animsition bg-light">

    <!-- Header -->
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        Khuyến mại hè giảm 20% tại Bunny Wear
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        <a href="<?= BASE_URL ?>?action=/login" class="flex-c-m trans-04 p-lr-25 font-weight-bold text-white">
                            Đăng Nhập
                        </a>
                        <a href="<?= BASE_URL ?>?action=/register" class="flex-c-m trans-04 p-lr-25">
                            Đăng Ký
                        </a>
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
                            <li><a href="<?= BASE_URL ?>?action=/wishlist">Yêu thích</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Auth Form -->
    <div class="auth-wrapper">
        <div class="auth-card animate__animated animate__fadeIn">
            
            <div class="auth-header">
                <div class="auth-brand-icon">
                    <i class="fa fa-user"></i>
                </div>
                <h3 class="auth-title">Chào Mừng Trở Lại</h3>
                <p class="auth-subtitle">Đăng nhập tài khoản để tiếp tục mua sắm</p>
            </div>

            <?php if (!empty($success)): ?>
                <div class="alert-custom alert-custom-success">
                    <i class="fa fa-check-circle mr-2 fs-16"></i>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert-custom alert-custom-error">
                    <i class="fa fa-exclamation-circle mr-2 fs-16"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>?action=/login/submit" method="POST">
                <div class="form-group-custom">
                    <label for="email">Địa chỉ Email</label>
                    <div class="input-wrapper">
                        <i class="fa fa-envelope-o input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="name@example.com"
                               value="<?= htmlspecialchars($old['email'] ?? '') ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group-custom">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="mb-0">Mật khẩu</label>
                        <a href="javascript:void(0)" onclick="alert('Vui lòng liên hệ quản trị viên hoặc hotline Bunny Wear để đặt lại mật khẩu.')" class="fs-12 text-muted">Quên mật khẩu?</a>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePass('password', this)">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth-primary">
                    <i class="fa fa-sign-in mr-2"></i> Đăng Nhập
                </button>
            </form>

            <div class="auth-footer-nav">
                Bạn chưa có tài khoản? <a href="<?= BASE_URL ?>?action=/register">Đăng ký ngay</a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg3 p-t-40 p-b-25 text-white">
        <div class="container text-center">
            <p class="stext-107 cl6 mb-0 text-white">
                © <?= date('Y') ?> Bunny Wear. Bản quyền thuộc về Bunny Wear Shop.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= BASE_URL ?>views/js/main.js"></script>

    <script>
        function togglePass(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Bunny Wear</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/auth.css">
</head>

<body>

<div class="auth-page">

    <!-- =========================
         BÊN TRÁI - FORM
    ========================== -->
    <section class="auth-left">

        <div class="auth-container">

            <!-- LOGO -->
            <a href="<?= BASE_URL ?>" class="brand-logo">
                <img
                    src="<?= BASE_URL ?>views/images/icons/Bunnywear.jpg"
                    alt="Bunny Wear"
                    onerror="this.src='<?= BASE_URL ?>views/images/logo.jpg';"
                >
            </a>

            <!-- HEADING -->
            <div class="auth-heading">
                <span class="eyebrow">
                    WELCOME BACK
                </span>

                <h1>
                    Đăng nhập
                </h1>

                <p>
                    Chào mừng bạn quay trở lại với Bunny Wear.
                    Tiếp tục khám phá phong cách của bạn.
                </p>
            </div>

            <!-- THÔNG BÁO -->
            <?php if (isset($_GET['registered'])): ?>
                <div class="message success">
                    Đăng ký thành công! Hãy đăng nhập để tiếp tục.
                </div>
            <?php endif; ?>

            <?php if (!empty($error) || !empty($_SESSION['auth_error'])): ?>
                <div class="message error">
                    <?= htmlspecialchars($error ?? $_SESSION['auth_error'] ?? '') ?>
                    <?php unset($_SESSION['auth_error']); ?>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form
                method="post"
                action="<?= BASE_URL ?>?action=login"
                class="auth-form"
            >
                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@gmail.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="password">
                            Mật khẩu
                        </label>

                        <a href="<?= BASE_URL ?>?action=/forgot-password" class="forgot">
                            Quên mật khẩu?
                        </a>
                    </div>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="auth-button"
                >
                    <span>
                        ĐĂNG NHẬP
                    </span>
                    <strong>
                        →
                    </strong>
                </button>
            </form>

            <!-- FOOTER -->
            <div class="auth-footer">
                <span>
                    Chưa có tài khoản?
                </span>

                <a href="<?= BASE_URL ?>?action=register">
                    Đăng ký ngay
                </a>
            </div>

        </div>

    </section>

    <!-- =========================
         BÊN PHẢI - FASHION
    ========================== -->
    <section class="fashion-side">

        <div class="fashion-content">
            <div class="fashion-label">
                BUNNY WEAR
            </div>

            <h2>
                FIND<br>
                YOUR<br>
                <span>LOOK.</span>
            </h2>

            <p>
                Simple clothes.<br>
                Strong personality.
            </p>

            <div class="fashion-line"></div>

            <div class="fashion-bottom">
                <span>
                    FASHION / LIFESTYLE
                </span>

                <span>
                    EST. 2026
                </span>
            </div>
        </div>

    </section>

</div>

</body>
</html>

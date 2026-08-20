<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản | Bunny Wear</title>
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
                    BUNNY WEAR
                </span>

                <h1>
                    Tạo tài khoản
                </h1>

                <p>
                    Tham gia Bunny Wear để khám phá những
                    sản phẩm thời trang mới nhất.
                </p>
            </div>

            <!-- ERROR -->
            <?php if (!empty($error) || !empty($_SESSION['auth_error'])): ?>
                <div class="message error">
                    <?= htmlspecialchars($error ?? $_SESSION['auth_error'] ?? '') ?>
                    <?php unset($_SESSION['auth_error']); ?>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form
                method="post"
                action="<?= BASE_URL ?>?action=register"
                class="auth-form"
            >
                <!-- HỌ TÊN -->
                <div class="form-group">
                    <label for="fullname">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        id="fullname"
                        name="fullname"
                        placeholder="Nhập họ và tên"
                        autocomplete="name"
                        required
                    >
                </div>

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
                    <label for="password">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Tối thiểu 6 ký tự"
                        minlength="6"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="auth-button"
                >
                    <span>
                        ĐĂNG KÝ
                    </span>
                    <strong>
                        →
                    </strong>
                </button>
            </form>

            <!-- FOOTER -->
            <div class="auth-footer">
                <span>
                    Bạn đã có tài khoản?
                </span>

                <a href="<?= BASE_URL ?>?action=login">
                    Đăng nhập
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
                NEW COLLECTION
            </div>

            <h2>
                WEAR<br>
                YOUR<br>
                <span>STYLE.</span>
            </h2>

            <p>
                Thời trang dành cho<br>
                phong cách của riêng bạn.
            </p>

            <div class="fashion-line"></div>

            <div class="fashion-bottom">
                <span>
                    BUNNY WEAR
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

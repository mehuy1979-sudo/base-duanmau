<?php
$cart = $cart ?? [];
$total = 0;
$cartCount = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
    $cartCount += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Giỏ hàng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>views/images/icons/favicon.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animate/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/util.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>views/css/main.css">
</head>

<body class="animsition">

<header>
    <div class="container-menu-desktop">
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-25">Help & FAQs</a>
                    <a href="#" class="flex-c-m trans-04 p-lr-25">My Account</a>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <a href="<?= BASE_URL ?>" class="logo">
                    <img src="<?= BASE_URL ?>views/images/icons/logo-01.png" alt="IMG-LOGO">
                </a>

                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="active-menu label1" data-label1="hot">
                            <a href="<?= BASE_URL ?>?action=cart">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>

                <div class="wrap-icon-header flex-w flex-r-m">
                    <a href="<?= BASE_URL ?>?action=cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="<?= $cartCount ?>">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <div class="wrap-header-mobile">
        <div class="logo-mobile">
            <a href="<?= BASE_URL ?>">
                <img src="<?= BASE_URL ?>views/images/icons/logo-01.png" alt="IMG-LOGO">
            </a>
        </div>

        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <a href="<?= BASE_URL ?>?action=cart" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="<?= $cartCount ?>">
                <i class="zmdi zmdi-shopping-cart"></i>
            </a>
        </div>
    </div>
</header>

<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?= BASE_URL ?>" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <span class="stext-109 cl4">Giỏ hàng</span>
    </div>
</div>

<?php if (empty($cart)): ?>

<div class="bg0 p-t-75 p-b-85">
    <div class="container text-center">
        <h4 class="mtext-105 cl2 p-b-30">Giỏ hàng trống</h4>
        <p class="stext-102 cl6 p-b-30">Hãy thêm sản phẩm để tiếp tục mua sắm.</p>
        <div class="flex-w flex-c-m flex-w gap-2">
            <a href="<?= BASE_URL ?>?action=add-cart&id=1" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 m-r-10 m-b-10">
                Thêm SP 1
            </a>
            <a href="<?= BASE_URL ?>?action=add-cart&id=2" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 m-r-10 m-b-10">
                Thêm SP 2
            </a>
            <a href="<?= BASE_URL ?>" class="flex-c-m stext-101 cl2 size-116 bg8 bor14 hov-btn3 p-lr-15 trans-04 m-b-10">
                Về trang chủ
            </a>
        </div>
    </div>
</div>

<?php else: ?>

<form class="bg0 p-t-75 p-b-85" action="<?= BASE_URL ?>?action=cart-update" method="POST">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Sản phẩm</th>
                                <th class="column-2"></th>
                                <th class="column-3">Giá</th>
                                <th class="column-4">Số lượng</th>
                                <th class="column-5">Thành tiền</th>
                            </tr>

                            <?php foreach ($cart as $item):
                                $subtotal = $item['price'] * $item['quantity'];
                                $image = $item['image'] ?? 'product-01.jpg';
                            ?>
                            <tr class="table_row">
                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="<?= BASE_URL ?>views/images/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    </div>
                                </td>
                                <td class="column-2">
                                    <?= htmlspecialchars($item['name']) ?>
                                    <br>
                                    <a href="<?= BASE_URL ?>?action=cart-delete&id=<?= (int) $item['id'] ?>" class="stext-109 cl6 hov-cl1">
                                        Xóa
                                    </a>
                                </td>
                                <td class="column-3"><?= number_format($item['price']) ?> đ</td>
                                <td class="column-4">
                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product"
                                               type="number"
                                               min="0"
                                               name="quantity[<?= (int) $item['id'] ?>]"
                                               value="<?= (int) $item['quantity'] ?>">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="column-5"><?= number_format($subtotal) ?> đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m w-full-sm">
                            <a href="<?= BASE_URL ?>?action=add-cart&id=<?= count($cart) + 1 ?>"
                               class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                Thêm sản phẩm mẫu
                            </a>
                        </div>

                        <div class="flex-w flex-m w-full-sm">
                            <button type="submit" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Cập nhật giỏ hàng
                            </button>
                            <a href="<?= BASE_URL ?>?action=cart-clear"
                               class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 m-l-10 m-tb-10"
                               onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                                Xóa hết
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">Tổng giỏ hàng</h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">Tạm tính:</span>
                        </div>
                        <div class="size-209">
                            <span class="mtext-110 cl2"><?= number_format($total) ?> đ</span>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">Tổng:</span>
                        </div>
                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2"><?= number_format($total) ?> đ</span>
                        </div>
                    </div>

                    <a href="#" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04">
                        Thanh toán
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<?php endif; ?>

<script src="<?= BASE_URL ?>views/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="<?= BASE_URL ?>views/vendor/animsition/js/animsition.min.js"></script>
<script src="<?= BASE_URL ?>views/vendor/bootstrap/js/popper.js"></script>
<script src="<?= BASE_URL ?>views/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>views/js/main.js"></script>

</body>
</html>

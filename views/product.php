<?php
// Partial view - Danh sách sản phẩm
// File này được include bởi views/main.php thông qua $view = 'product'
?>

<div class="col-12">

    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="<?= BASE_URL ?>assets/uploads/<?= htmlspecialchars($product['image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($product['product_name'] ?? $product['name'] ?? 'Sản phẩm') ?>">
                        <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product['id'] ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                            Xem chi tiết
                        </a>
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="<?= BASE_URL ?>?action=/product-detail&id=<?= $product['id'] ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                <?= htmlspecialchars($product['product_name'] ?? $product['name'] ?? 'Tên sản phẩm') ?>
                            </a>
                            <span class="stext-105 cl3 text-danger font-weight-bold">
                                <?= number_format($product['price'] ?? 0, 0, ',', '.') ?> VND
                            </span>
                        </div>
                        <div class="block2-txt-child2 flex-r p-t-3">
                            <?php $isFav = in_array($product['id'] ?? 0, $_SESSION['wishlist'] ?? []); ?>
                            <a href="javascript:void(0)" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 <?= $isFav ? 'js-addedwish-b2' : '' ?>" data-product-id="<?= $product['id'] ?? 0 ?>" data-product-name="<?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm') ?>">
                                <img class="icon-heart1 dis-block trans-04" src="<?= BASE_URL ?>views/images/icons/icon-heart-01.png" alt="ICON">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?= BASE_URL ?>views/images/icons/icon-heart-02.png" alt="ICON">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="p-t-40 p-b-40 text-center">
            <p class="stext-107 cl6">Chưa có sản phẩm nào.</p>
        </div>
    <?php endif; ?>
</div>
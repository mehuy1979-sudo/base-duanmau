<?php
$statusMap = [
    1 => ['name' => 'Chờ xác nhận', 'color' => '#ffc107'],
    2 => ['name' => 'Đã xác nhận', 'color' => '#17a2b8'],
    3 => ['name' => 'Đang giao', 'color' => '#007bff'],
    4 => ['name' => 'Giao hàng thành công', 'color' => '#28a745'],
    5 => ['name' => 'Giao hàng thất bại', 'color' => '#dc3545'],
    6 => ['name' => 'Hoàn thành', 'color' => '#6c757d'],
    7 => ['name' => 'Đã hủy', 'color' => '#343a40']
];

$paymentMap = [
    0 => ['name' => 'Chưa thanh toán', 'color' => '#dc3545'],
    1 => ['name' => 'Đã thanh toán', 'color' => '#28a745']
];

$orderId         = $order['id'] ?? $_GET['id'] ?? 0;
$customerName    = $order['user_name'] ?? $order['customer_name'] ?? $order['name'] ?? 'Khách lẻ';
$customerPhone   = $order['user_phone'] ?? $order['customer_phone'] ?? $order['phone'] ?? 'N/A';
$customerAddress = $order['user_address'] ?? $order['customer_address'] ?? $order['address'] ?? 'N/A';
$totalAmount     = (float)($order['total_amount'] ?? $order['total_price'] ?? $order['total'] ?? 0);
$orderStatus     = (int)($order['order_status'] ?? $order['status'] ?? 1);
$paymentStatus   = (int)($order['payment_status'] ?? $order['payment'] ?? 0);
$cancelReason    = $order['cancel_reason'] ?? '';

$currentStatus  = $statusMap[$orderStatus] ?? ['name' => 'N/A', 'color' => '#ccc'];
$currentPayment = $paymentMap[$paymentStatus] ?? ['name' => 'N/A', 'color' => '#ccc'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Đơn Hàng #<?= htmlspecialchars((string)$orderId) ?></title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .back-btn { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; color: #fff; font-weight: bold; display: inline-block; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group select, .form-group textarea { padding: 8px; width: 320px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #28a745; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background-color: #218838; }
        .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; display: block; margin: 0 auto; }
    </style>
</head>
<body>

<a href="?action=orders" class="back-btn">&laquo; Quay lại danh sách</a>

<h2>Chi Tiết Đơn Hàng #<?= htmlspecialchars((string)$orderId) ?></h2>

<div class="card">
    <h3>Thông tin người nhận</h3>
    <p><strong>Khách hàng:</strong> <?= htmlspecialchars((string)$customerName) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars((string)$customerPhone) ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars((string)$customerAddress) ?></p>
</div>

<div class="card">
    <h3>Danh sách sản phẩm mua</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 80px; text-align: center;">Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orderDetails)): ?>
                <?php foreach ($orderDetails as $detail): ?>
                    <?php
                        $productName = $detail['product_name'] ?? $detail['name'] ?? ('Sản phẩm #' . ($detail['product_id'] ?? ''));
                        $unitPrice   = (float)($detail['unit_price'] ?? $detail['price'] ?? 0);
                        $quantity    = (int)($detail['quantity'] ?? $detail['qty'] ?? 1);
                        $subtotal    = (float)($detail['total_price'] ?? ($unitPrice * $quantity));

                        // Xử lý chuẩn hóa đường dẫn ảnh
                        $rawImage = trim($detail['image'] ?? $detail['img'] ?? '');
                        $imgPath = '';

                        if (!empty($rawImage)) {
                            $cleanImage = ltrim($rawImage, '/');

                            if (strpos($cleanImage, 'assets/uploads/product/') === 0) {
                                $imgPath = $cleanImage;
                            } elseif (strpos($cleanImage, 'uploads/product/') === 0) {
                                $imgPath = 'assets/' . $cleanImage;
                            } elseif (strpos($cleanImage, 'product/') === 0) {
                                $imgPath = 'assets/uploads/' . $cleanImage;
                            } else {
                                $imgPath = 'assets/uploads/product/' . $cleanImage;
                            }
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <?php if (!empty($imgPath)): ?>
                                <img src="<?= htmlspecialchars($imgPath) ?>" 
                                     alt="<?= htmlspecialchars((string)$productName) ?>" 
                                     class="product-img">
                            <?php else: ?>
                                <span style="color: #999; font-size: 11px;">Không có ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars((string)$productName) ?></td>
                        <td><?= number_format($unitPrice, 0, ',', '.') ?> VNĐ</td>
                        <td><?= $quantity ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Không có dữ liệu sản phẩm trong đơn hàng.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <h4 style="text-align: right; margin-top: 15px;">
        Tổng thanh toán: <span style="color: #dc3545; font-size: 18px;"><?= number_format($totalAmount, 0, ',', '.') ?> VNĐ</span>
    </h4>
</div>

<div class="card">
    <h3>Trạng thái đơn hàng</h3>
    <p>
        <strong>Trạng thái hiện tại:</strong> 
        <span class="badge" style="background-color: <?= $currentStatus['color'] ?>;">
            <?= htmlspecialchars((string)$currentStatus['name']) ?>
        </span>
    </p>
    <p>
        <strong>Trạng thái thanh toán:</strong> 
        <span class="badge" style="background-color: <?= $currentPayment['color'] ?>;">
            <?= htmlspecialchars((string)$currentPayment['name']) ?>
        </span>
    </p>

    <?php if (!empty($cancelReason)): ?>
        <p><strong>Lý do hủy đơn:</strong> <span style="color: #dc3545;"><?= htmlspecialchars((string)$cancelReason) ?></span></p>
    <?php endif; ?>

    <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">

    <?php if (in_array($orderStatus, [1, 2, 3, 4])): ?>
        <form action="?action=update_order_status" method="POST">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            
            <div class="form-group">
                <label for="new_status">Cập nhật trạng thái:</label>
                <select name="new_status" id="new_status" required onchange="toggleCancelReason(this.value)">
                    <?php if ($orderStatus === 1): ?>
                        <option value="2">Đã xác nhận</option>
                        <option value="7">Hủy đơn hàng</option>
                    <?php elseif ($orderStatus === 2): ?>
                        <option value="3">Đang giao</option>
                    <?php elseif ($orderStatus === 3): ?>
                        <option value="4">Giao hàng thành công</option>
                        <option value="5">Giao hàng thất bại</option>
                    <?php elseif ($orderStatus === 4): ?>
                        <option value="6">Hoàn thành</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group" id="cancel_reason_group" style="display: none;">
                <label for="cancel_reason">Lý do hủy đơn (Bắt buộc):</label>
                <textarea name="cancel_reason" id="cancel_reason" rows="3" placeholder="Nhập lý do hủy đơn..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Cập nhật trạng thái</button>
        </form>

        <script>
            function toggleCancelReason(val) {
                const reasonGroup = document.getElementById('cancel_reason_group');
                const reasonInput = document.getElementById('cancel_reason');
                if (val == 7) {
                    reasonGroup.style.display = 'block';
                    reasonInput.setAttribute('required', 'required');
                } else {
                    reasonGroup.style.display = 'none';
                    reasonInput.removeAttribute('required');
                }
            }
            toggleCancelReason(document.getElementById('new_status').value);
        </script>
    <?php else: ?>
        <p style="color: #6c757d; font-style: italic; margin-top: 10px;">
            Đơn hàng này đã kết thúc lifecycle (Hoàn thành / Thất bại / Đã hủy), không thể chuyển trạng thái nữa.
        </p>
    <?php endif; ?>
</div>

</body>
</html>
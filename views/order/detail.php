<?php
$statusNames = [
    1 => 'Chờ xác nhận',
    2 => 'Đã xác nhận',
    3 => 'Đang giao',
    4 => 'Giao hàng thành công',
    5 => 'Giao hàng thất bại',
    6 => 'Hoàn thành',
    7 => 'Đã hủy'
];

$paymentNames = [
    0 => 'Chưa thanh toán',
    1 => 'Đã thanh toán'
];

$currentStatus = (int)$order['order_status'];

// TỰ ĐỘNG BẮT LOGIC FLOWCHART: Chỉ cho phép chọn trạng thái tiếp theo hợp lệ
$nextAllowedStatuses = [];
switch ($currentStatus) {
    case 1: // Chờ xác nhận -> Đã xác nhận (2) hoặc Hủy (7)
        $nextAllowedStatuses = [2 => 'Đã xác nhận', 7 => 'Đã hủy'];
        break;
    case 2: // Đã xác nhận -> Đang giao (3)
        $nextAllowedStatuses = [3 => 'Đang giao'];
        break;
    case 3: // Đang giao -> Thành công (4) hoặc Thất bại (5)
        $nextAllowedStatuses = [4 => 'Giao hàng thành công', 5 => 'Giao hàng thất bại'];
        break;
    case 4: // Giao hàng thành công -> Hoàn thành (6)
        $nextAllowedStatuses = [6 => 'Hoàn thành'];
        break;
    default:
        // Các trạng thái 5 (Thất bại), 6 (Hoàn thành), 7 (Đã hủy) không cho đổi nữa
        $nextAllowedStatuses = [];
        break;
}
?>

<h2>Chi Tiết Đơn Hàng #<?= $order['id'] ?></h2>
<a href="?role=admin&act=orders">&laquo; Quay lại danh sách</a>

<div style="display: flex; gap: 20px; margin-top: 20px;">
    <!-- CỘT TRÁI: THÔNG TIN VÀ SẢN PHẨM -->
    <div style="flex: 2;">
        <h3>Thông tin người nhận</h3>
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>

        <h3>Danh sách sản phẩm mua</h3>
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name'] ?? 'Sản phẩm #' . $item['product_id']) ?></td>
                        <td><?= number_format($item['unit_price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><strong>Tổng thanh toán:</strong></td>
                    <td><strong style="color: red;"><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- CỘT PHẢI: TRẠNG THÁI & FORM CẬP NHẬT -->
    <div style="flex: 1; background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
        <h3>Trạng thái đơn hàng</h3>
        <p><strong>Trạng thái hiện tại:</strong> <b style="color: #007bff;"><?= $statusNames[$currentStatus] ?? 'N/A' ?></b></p>
        <p><strong>Trạng thái thanh toán:</strong> <b><?= $paymentNames[$order['payment_status']] ?? 'N/A' ?></b></p>

        <?php if (!empty($order['cancel_reason'])): ?>
            <p style="color: red; background: #ffe6e6; padding: 8px; border-radius: 4px;">
                <strong>Lý do hủy:</strong> <?= htmlspecialchars($order['cancel_reason']) ?>
            </p>
        <?php endif; ?>

        <hr style="margin: 15px 0;">

        <?php if (!empty($nextAllowedStatuses)): ?>
            <h4>Cập nhật trạng thái</h4>
            <form action="?role=admin&act=update_order_status" method="POST">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                <label for="new_status">Chuyển sang trạng thái tiếp theo:</label><br>
                <select name="new_status" id="new_status" required style="width: 100%; padding: 8px; margin: 8px 0;" onchange="checkCancelReason()">
                    <option value="">-- Chọn trạng thái --</option>
                    <?php foreach ($nextAllowedStatuses as $statusCode => $statusLabel): ?>
                        <option value="<?= $statusCode ?>"><?= $statusLabel ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Ô nhập lý do hủy (Ẩn/Hiện bằng Javascript) -->
                <div id="cancelReasonBox" style="display: none; margin-top: 10px;">
                    <label for="cancel_reason" style="color: red;"><b>Lý do hủy đơn (*bắt buộc):</b></label><br>
                    <textarea name="cancel_reason" id="cancel_reason" rows="3" style="width: 100%; padding: 8px;" placeholder="Nhập lý do hủy đơn tại đây..."></textarea>
                </div>

                <button type="submit" style="margin-top: 15px; width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Cập nhật trạng thái
                </button>
            </form>

            <script>
                function checkCancelReason() {
                    var statusSelect = document.getElementById('new_status');
                    var reasonBox = document.getElementById('cancelReasonBox');
                    var reasonInput = document.getElementById('cancel_reason');

                    // Giá trị 7 tương ứng với trạng thái 'Đã hủy'
                    if (statusSelect.value == '7') {
                        reasonBox.style.display = 'block';
                        reasonInput.setAttribute('required', 'required');
                    } else {
                        reasonBox.style.display = 'none';
                        reasonInput.removeAttribute('required');
                    }
                }
            </script>
        <?php else: ?>
            <p style="color: #6c757d; font-style: italic;">Đơn hàng này đã kết thúc lifecycle (Hoàn thành / Thất bại / Đã hủy), không thể chuyển trạng thái nữa.</p>
        <?php endif; ?>
    </div>
</div>
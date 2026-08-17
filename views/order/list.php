<?php
// Ánh xạ trạng thái đơn hàng sang tên tiếng Việt và thẻ màu
$statusMap = [
    1 => ['name' => 'Chờ xác nhận', 'color' => '#ffc107'], // Vàng
    2 => ['name' => 'Đã xác nhận', 'color' => '#17a2b8'],  // Xanh nhạt
    3 => ['name' => 'Đang giao', 'color' => '#007bff'],     // Xanh dương
    4 => ['name' => 'Giao hàng thành công', 'color' => '#28a745'], // Xanh lá
    5 => ['name' => 'Giao hàng thất bại', 'color' => '#dc3545'],   // Đỏ
    6 => ['name' => 'Hoàn thành', 'color' => '#6c757d'],   // Xám đậm
    7 => ['name' => 'Đã hủy', 'color' => '#343a40']        // Đen
];

$paymentMap = [
    0 => ['name' => 'Chưa thanh toán', 'color' => '#dc3545'],
    1 => ['name' => 'Đã thanh toán', 'color' => '#28a745']
];
?>

<h2>Quản Lý Đơn Hàng</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
            <th>Trạng thái đơn hàng</th>
            <th>Thanh toán</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                    <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <span style="background-color: <?= $statusMap[$order['order_status']]['color'] ?? '#ccc' ?>; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            <?= $statusMap[$order['order_status']]['name'] ?? 'Không xác định' ?>
                        </span>
                    </td>
                    <td>
                        <span style="background-color: <?= $paymentMap[$order['payment_status']]['color'] ?? '#ccc' ?>; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            <?= $paymentMap[$order['payment_status']]['name'] ?? 'Chưa xác định' ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                    <td>
                        <a href="?action=order_detail&id=<?= $order['id'] ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center;">Chưa có đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
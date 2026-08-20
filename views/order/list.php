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
?>

<h2>Quản Lý Đơn Hàng</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border-collapse: collapse; font-family: sans-serif;">
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
                <?php
                    $id            = $order['id'] ?? 0;
                    $customerName  = $order['user_name'] ?? $order['customer_name'] ?? $order['name'] ?? 'Khách lẻ';
                    $customerPhone = $order['user_phone'] ?? $order['customer_phone'] ?? $order['phone'] ?? 'N/A';
                    $totalAmount   = (float)($order['total_amount'] ?? $order['total_price'] ?? $order['total'] ?? 0);
                    $orderStatus   = (int)($order['order_status'] ?? $order['status'] ?? 1);
                    $paymentStatus = (int)($order['payment_status'] ?? $order['payment'] ?? 0);
                    $createdAt     = $order['created_at'] ?? $order['order_date'] ?? null;
                ?>
                <tr>
                    <td>#<?= htmlspecialchars((string)$id) ?></td>
                    <td><?= htmlspecialchars((string)$customerName) ?></td>
                    <td><?= htmlspecialchars((string)$customerPhone) ?></td>
                    <td><?= number_format($totalAmount, 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <span style="background-color: <?= $statusMap[$orderStatus]['color'] ?? '#ccc' ?>; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                            <?= $statusMap[$orderStatus]['name'] ?? 'Không xác định' ?>
                        </span>
                    </td>
                    <td>
                        <span style="background-color: <?= $paymentMap[$paymentStatus]['color'] ?? '#ccc' ?>; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                            <?= $paymentMap[$paymentStatus]['name'] ?? 'Chưa xác định' ?>
                        </span>
                    </td>
                    <td>
                        <?= $createdAt ? date('d/m/Y H:i', strtotime($createdAt)) : 'Chưa ghi nhận' ?>
                    </td>
                    <td>
                        <a href="?action=order_detail&id=<?= $id ?>">Xem chi tiết</a>
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
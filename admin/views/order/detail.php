<?php
$statusMap = [
    1 => ['name' => 'Chờ xử lý', 'color' => 'warning', 'icon' => 'bi-hourglass-split'],
    2 => ['name' => 'Đã xác nhận', 'color' => 'info', 'icon' => 'bi-check2-square'],
    3 => ['name' => 'Đang giao', 'color' => 'primary', 'icon' => 'bi-truck'],
    4 => ['name' => 'Đã giao', 'color' => 'success', 'icon' => 'bi-box-seam'],
    5 => ['name' => 'Giao thất bại', 'color' => 'danger', 'icon' => 'bi-exclamation-octagon'],
    6 => ['name' => 'Hoàn thành', 'color' => 'success', 'icon' => 'bi-check-circle-fill'],
    7 => ['name' => 'Đã hủy', 'color' => 'secondary', 'icon' => 'bi-x-circle']
];

$paymentMap = [
    0 => ['name' => 'Chưa thanh toán', 'color' => 'danger'],
    1 => ['name' => 'Đã thanh toán', 'color' => 'success']
];

$orderId         = (int)($order['id'] ?? 0);
$customerName    = $order['customer_name'] ?? $order['user_name'] ?? 'Khách lẻ';
$customerEmail   = $order['email'] ?? 'Chưa cung cấp';
$customerPhone   = $order['phone'] ?? $order['user_phone'] ?? 'N/A';
$customerAddress = $order['address'] ?? 'N/A';
$cityDistrict    = trim(($order['district'] ?? '') . ', ' . ($order['city'] ?? ''), ', ');
$totalAmount     = (float)($order['total_amount'] ?? 0);
$discount        = (float)($order['discount'] ?? 0);
$couponCode      = $order['coupon_code'] ?? '';
$orderStatus     = (int)($order['order_status'] ?? 1);
$paymentStatus   = (int)($order['payment_status'] ?? 0);
$paymentMethod   = strtoupper($order['payment_method'] ?? 'COD');
$cancelReason    = $order['cancel_reason'] ?? '';
$orderDate       = $order['order_date'] ?? $order['created_at'] ?? null;

$stInfo  = $statusMap[$orderStatus] ?? ['name' => 'Chờ xử lý', 'color' => 'warning', 'icon' => 'bi-hourglass-split'];
$payInfo = $paymentMap[$paymentStatus] ?? ['name' => 'Chưa thanh toán', 'color' => 'danger'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi Tiết Đơn Hàng #DH<?= str_pad($orderId, 5, '0', STR_PAD_LEFT) ?> | Bunny Wear Admin</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .order-card-panel {
      background: var(--admin-surface, #fff);
      border: 1px solid var(--admin-border, #e5e7eb);
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
      margin-bottom: 1.5rem;
    }
    .product-thumb-sm {
      width: 56px;
      height: 56px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #e5e7eb;
    }
    .step-track {
      display: flex;
      justify-content: space-between;
      position: relative;
      margin: 1.5rem 0;
    }
    .step-track::before {
      content: '';
      position: absolute;
      top: 18px;
      left: 10%;
      right: 10%;
      height: 3px;
      background: #e5e7eb;
      z-index: 1;
    }
    .step-track-item {
      position: relative;
      z-index: 2;
      text-align: center;
      flex: 1;
    }
    .step-track-circle {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #f3f4f6;
      color: #6b7280;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      margin-bottom: 6px;
      border: 3px solid #fff;
    }
    .step-track-item.completed .step-track-circle {
      background: #10b981;
      color: #fff;
    }
    .step-track-item.active .step-track-circle {
      background: #6366f1;
      color: #fff;
      box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
    }
    .step-track-label {
      font-size: 0.8rem;
      font-weight: 600;
      color: #4b5563;
    }
  </style>
</head>
<body>
<div class="admin-shell">
  <div class="sidebar-backdrop" data-sidebar-close></div>

  <!-- SIDEBAR -->
  <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

  <!-- MAIN -->
  <div class="admin-main">
    <!-- Navbar -->
    <nav class="navbar admin-navbar navbar-expand bg-white">
      <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-label="Toggle sidebar">
          <span></span><span></span><span></span>
        </button>
        <div class="navbar-actions ms-auto d-flex align-items-center gap-2">
          <a href="<?= BASE_URL ?>" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-sm-inline-flex align-items-center gap-1">
            <i class="bi bi-shop"></i> Xem Cửa Hàng
          </a>
          <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch theme">
            <i class="bi bi-moon-stars" data-theme-icon></i>
          </button>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <main class="dashboard-content">
      <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Heading Bar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
          <div>
            <a href="index.php?action=orders" class="btn btn-sm btn-outline-secondary mb-2">
              <i class="bi bi-arrow-left me-1"></i> Danh sách đơn hàng
            </a>
            <h1 class="h3 mb-1 fw-bold">Chi Tiết Đơn Hàng #DH<?= str_pad($orderId, 5, '0', STR_PAD_LEFT) ?></h1>
            <p class="text-muted mb-0">Đặt lúc: <?= $orderDate ? date('d/m/Y H:i', strtotime($orderDate)) : '—' ?></p>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-dark btn-sm fw-semibold" onclick="window.print()">
              <i class="bi bi-printer me-1"></i> In Đơn Hàng
            </button>
          </div>
        </div>

        <!-- Flash Alert -->
        <?php if (!empty($flashSuccess)): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($flashSuccess) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($flashError) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- Progress Tracker (if not cancelled) -->
        <?php if ($orderStatus !== 7): ?>
          <div class="order-card-panel">
            <h5 class="fw-bold mb-3">Tiến Trình Đơn Hàng</h5>
            <div class="step-track">
              <div class="step-track-item completed">
                <div class="step-track-circle"><i class="bi bi-check-lg"></i></div>
                <div class="step-track-label">1. Chờ xử lý</div>
              </div>
              <div class="step-track-item <?= in_array($orderStatus, [2, 3, 4, 6]) ? 'completed' : ($orderStatus === 1 ? 'active' : '') ?>">
                <div class="step-track-circle"><?= in_array($orderStatus, [2, 3, 4, 6]) ? '<i class="bi bi-check-lg"></i>' : '2' ?></div>
                <div class="step-track-label">2. Đã xác nhận</div>
              </div>
              <div class="step-track-item <?= in_array($orderStatus, [3, 4, 6]) ? 'completed' : ($orderStatus === 2 ? 'active' : '') ?>">
                <div class="step-track-circle"><?= in_array($orderStatus, [3, 4, 6]) ? '<i class="bi bi-check-lg"></i>' : '3' ?></div>
                <div class="step-track-label">3. Đang giao hàng</div>
              </div>
              <div class="step-track-item <?= in_array($orderStatus, [4, 6]) ? 'completed active' : ($orderStatus === 3 ? 'active' : '') ?>">
                <div class="step-track-circle"><?= in_array($orderStatus, [4, 6]) ? '<i class="bi bi-check-lg"></i>' : '4' ?></div>
                <div class="step-track-label">4. Hoàn thành</div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="alert alert-secondary mb-4">
            <i class="bi bi-x-octagon-fill me-2 text-danger"></i>
            <strong>Đơn hàng này đã bị hủy.</strong>
            <?php if (!empty($cancelReason)): ?>
              <span class="ms-2">Lý do: <em><?= htmlspecialchars($cancelReason) ?></em></span>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="row g-4">
          <!-- Left Column: Products List -->
          <div class="col-lg-8">
            <div class="order-card-panel">
              <h5 class="fw-bold mb-3 border-bottom pb-2">Danh Sách Sản Phẩm Đã Mua (<?= count($orderDetails ?? []) ?>)</h5>
              
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width: 70px;">Hình ảnh</th>
                      <th>Sản phẩm</th>
                      <th class="text-center">Đơn giá</th>
                      <th class="text-center">Số lượng</th>
                      <th class="text-end">Tạm tính</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($orderDetails)): ?>
                      <?php foreach ($orderDetails as $detail): ?>
                        <?php
                          $productName = $detail['product_name'] ?? ('Sản phẩm #' . ($detail['product_id'] ?? ''));
                          $unitPrice   = (float)($detail['price'] ?? 0);
                          $quantity    = (int)($detail['quantity'] ?? 1);
                          $subtotal    = $unitPrice * $quantity;
                          $rawImage    = trim($detail['image'] ?? '');
                          $imgSrc      = !empty($rawImage) ? BASE_URL . 'assets/uploads/' . $rawImage : BASE_URL . 'views/images/product-01.jpg';
                        ?>
                        <tr>
                          <td>
                            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($productName) ?>" class="product-thumb-sm" onerror="this.src='<?= BASE_URL ?>views/images/product-01.jpg';">
                          </td>
                          <td>
                            <div class="fw-semibold"><?= htmlspecialchars($productName) ?></div>
                            <small class="text-muted">Mã SP: #<?= (int)($detail['product_id'] ?? 0) ?></small>
                          </td>
                          <td class="text-center"><?= number_format($unitPrice, 0, ',', '.') ?> ₫</td>
                          <td class="text-center"><span class="badge bg-secondary"><?= $quantity ?></span></td>
                          <td class="text-end fw-bold text-dark"><?= number_format($subtotal, 0, ',', '.') ?> ₫</td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="5" class="text-center py-4 text-muted">Không có sản phẩm trong đơn.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Order Summary calculation -->
              <div class="border-top mt-3 pt-3">
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Tạm tính:</span>
                  <span class="fw-semibold"><?= number_format($totalAmount + $discount, 0, ',', '.') ?> ₫</span>
                </div>
                <?php if ($discount > 0): ?>
                  <div class="d-flex justify-content-between mb-2 text-success">
                    <span>Mã giảm giá (<?= htmlspecialchars($couponCode ?: 'KM') ?>):</span>
                    <span>-<?= number_format($discount, 0, ',', '.') ?> ₫</span>
                  </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between fs-5 fw-bold text-danger border-top pt-2">
                  <span>Tổng tiền thanh toán:</span>
                  <span><?= number_format($totalAmount, 0, ',', '.') ?> ₫</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column: Customer Info & Status Action Form -->
          <div class="col-lg-4">
            <!-- Customer Info -->
            <div class="order-card-panel">
              <h5 class="fw-bold mb-3 border-bottom pb-2">Thông Tin Người Nhận</h5>
              <p class="mb-2"><strong>Họ tên:</strong> <?= htmlspecialchars($customerName) ?></p>
              <p class="mb-2"><strong>Số điện thoại:</strong> <a href="tel:<?= htmlspecialchars($customerPhone) ?>" class="text-decoration-none fw-semibold"><?= htmlspecialchars($customerPhone) ?></a></p>
              <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($customerEmail) ?></p>
              <p class="mb-2"><strong>Địa chỉ:</strong> <?= htmlspecialchars($customerAddress) ?><?= $cityDistrict ? ', ' . htmlspecialchars($cityDistrict) : '' ?></p>
              <p class="mb-2"><strong>Phương thức:</strong> <span class="badge bg-light text-dark border"><?= htmlspecialchars($paymentMethod) ?></span></p>
              <?php if (!empty($order['note'])): ?>
                <p class="mb-0 text-muted small"><strong>Ghi chú:</strong> <em>"<?= htmlspecialchars($order['note']) ?>"</em></p>
              <?php endif; ?>
            </div>

            <!-- Status Manager Form -->
            <div class="order-card-panel">
              <h5 class="fw-bold mb-3 border-bottom pb-2">Cập Nhật Trạng Thái Đơn</h5>
              
              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">TRẠNG THÁI HIỆN TẠI</label>
                <div>
                  <span class="badge bg-<?= $stInfo['color'] ?> fs-6 py-2 px-3">
                    <i class="bi <?= $stInfo['icon'] ?> me-1"></i> <?= $stInfo['name'] ?>
                  </span>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">THANH TOÁN</label>
                <div>
                  <span class="badge bg-<?= $payInfo['color'] ?> py-1 px-2">
                    <?= $payInfo['name'] ?>
                  </span>
                </div>
              </div>

              <?php if (in_array($orderStatus, [1, 2, 3, 4, 5])): ?>
                <form action="index.php?action=update_order_status" method="POST" class="mt-4 border-top pt-3">
                  <input type="hidden" name="order_id" value="<?= $orderId ?>">

                  <div class="mb-3">
                    <label for="new_status" class="form-label fw-bold">Chuyển sang trạng thái tiếp theo:</label>
                    <select name="new_status" id="new_status" class="form-select" required onchange="toggleCancelReason(this.value)">
                      <?php if ($orderStatus === 1): ?>
                        <option value="2">2. Đã xác nhận đơn hàng</option>
                        <option value="3">3. Chuyển sang Đang giao</option>
                        <option value="7">7. Hủy đơn hàng này</option>
                      <?php elseif ($orderStatus === 2): ?>
                        <option value="3">3. Bắt đầu giao hàng (Đang giao)</option>
                        <option value="7">7. Hủy đơn hàng</option>
                      <?php elseif ($orderStatus === 3): ?>
                        <option value="4">4. Giao hàng thành công (Đã giao)</option>
                        <option value="6">6. Hoàn tất đơn hàng (Hoàn thành)</option>
                        <option value="5">5. Giao hàng thất bại</option>
                        <option value="7">7. Hủy đơn hàng</option>
                      <?php elseif ($orderStatus === 4): ?>
                        <option value="6">6. Hoàn thành đơn hàng</option>
                      <?php elseif ($orderStatus === 5): ?>
                        <option value="3">3. Thử giao lại (Đang giao)</option>
                        <option value="7">7. Hủy đơn hàng</option>
                      <?php endif; ?>
                    </select>
                  </div>

                  <div class="mb-3" id="cancel_reason_group" style="display: none;">
                    <label for="cancel_reason" class="form-label fw-bold text-danger">Lý do hủy đơn (Bắt buộc):</label>
                    <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="3" placeholder="Ví dụ: Khách yêu cầu hủy, hết hàng kho..."></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                    <i class="bi bi-arrow-repeat me-1"></i> Cập Nhật Trạng Thái
                  </button>
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
                <div class="alert alert-light border mt-3 mb-0 small text-muted">
                  <i class="bi bi-info-circle me-1"></i> Đơn hàng này đã kết thúc (Hoàn thành hoặc Đã hủy), không thể chuyển trạng thái nữa.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
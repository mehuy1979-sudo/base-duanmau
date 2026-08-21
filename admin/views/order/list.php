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

$currentStatus = $_GET['status'] ?? '';
$keyword = trim($_GET['q'] ?? '');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Quản lý đơn hàng' ?> | Bunny Wear Admin</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .metric-card {
      border: 1px solid var(--admin-border, #e5e7eb);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      background: var(--admin-surface, #fff);
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .metric-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,.06);
    }
    .order-status-badge {
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.35rem 0.65rem;
      border-radius: 20px;
    }
    .filter-tabs {
      display: flex;
      gap: 0.4rem;
      flex-wrap: wrap;
    }
    .filter-tab {
      padding: 0.35rem 0.9rem;
      border: 1px solid var(--admin-border, #e5e7eb);
      border-radius: 20px;
      background: var(--admin-surface, #fff);
      color: #6b7280;
      font-size: 0.84rem;
      font-weight: 600;
      text-decoration: none;
      transition: all .16s ease;
    }
    .filter-tab:hover, .filter-tab.active {
      border-color: var(--admin-primary, #6366f1);
      background: var(--admin-primary, #6366f1);
      color: #fff;
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

        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
          <div>
            <h1 class="h3 mb-1 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Quản Lý Đơn Hàng</h1>
            <p class="text-muted mb-0">Theo dõi, xác nhận và cập nhật tiến trình giao hàng cho khách.</p>
          </div>
        </div>

        <!-- Flash Alerts -->
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

        <!-- Metric Cards -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3">
            <div class="metric-card">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-semibold">Tổng Đơn Hàng</span>
                <span class="text-primary fs-5"><i class="bi bi-bag-check"></i></span>
              </div>
              <div class="fs-4 fw-bold mt-2"><?= $stats['total'] ?? 0 ?></div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="metric-card">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-semibold">Chờ Xử Lý</span>
                <span class="text-warning fs-5"><i class="bi bi-hourglass-split"></i></span>
              </div>
              <div class="fs-4 fw-bold mt-2 text-warning"><?= $stats['pending'] ?? 0 ?></div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="metric-card">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-semibold">Đang Giao Hàng</span>
                <span class="text-primary fs-5"><i class="bi bi-truck"></i></span>
              </div>
              <div class="fs-4 fw-bold mt-2 text-primary"><?= $stats['shipping'] ?? 0 ?></div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="metric-card">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-semibold">Đã Hoàn Thành</span>
                <span class="text-success fs-5"><i class="bi bi-check-circle"></i></span>
              </div>
              <div class="fs-4 fw-bold mt-2 text-success"><?= ($stats['completed'] ?? 0) + ($stats['delivered'] ?? 0) ?></div>
            </div>
          </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
              <div class="filter-tabs">
                <a href="index.php?action=orders" class="filter-tab <?= $currentStatus === '' ? 'active' : '' ?>">Tất cả (<?= $stats['total'] ?? 0 ?>)</a>
                <a href="index.php?action=orders&status=1" class="filter-tab <?= $currentStatus === '1' ? 'active' : '' ?>">Chờ xử lý (<?= $stats['pending'] ?? 0 ?>)</a>
                <a href="index.php?action=orders&status=2" class="filter-tab <?= $currentStatus === '2' ? 'active' : '' ?>">Đã xác nhận (<?= $stats['confirmed'] ?? 0 ?>)</a>
                <a href="index.php?action=orders&status=3" class="filter-tab <?= $currentStatus === '3' ? 'active' : '' ?>">Đang giao (<?= $stats['shipping'] ?? 0 ?>)</a>
                <a href="index.php?action=orders&status=6" class="filter-tab <?= $currentStatus === '6' ? 'active' : '' ?>">Hoàn thành (<?= $stats['completed'] ?? 0 ?>)</a>
                <a href="index.php?action=orders&status=7" class="filter-tab <?= $currentStatus === '7' ? 'active' : '' ?>">Đã hủy (<?= $stats['cancelled'] ?? 0 ?>)</a>
              </div>

              <form class="d-flex gap-2" method="GET" style="max-width: 320px;">
                <input type="hidden" name="action" value="orders">
                <?php if ($currentStatus !== ''): ?>
                  <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>">
                <?php endif; ?>
                <input type="search" name="q" class="form-control form-control-sm" placeholder="Tìm tên, SĐT, mã đơn..." value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="btn btn-primary btn-sm px-3"><i class="bi bi-search"></i></button>
              </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Mã Đơn</th>
                    <th>Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái Đơn</th>
                    <th>Thanh Toán</th>
                    <th>Ngày Đặt</th>
                    <th class="text-end">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                      <?php
                        $id            = (int)($order['id'] ?? 0);
                        $customerName  = $order['customer_name'] ?? $order['user_name'] ?? 'Khách lẻ';
                        $customerPhone = $order['phone'] ?? $order['user_phone'] ?? 'N/A';
                        $totalAmount   = (float)($order['total_amount'] ?? 0);
                        $orderStatus   = (int)($order['order_status'] ?? 1);
                        $paymentStatus = (int)($order['payment_status'] ?? 0);
                        $createdAt     = $order['order_date'] ?? $order['created_at'] ?? null;
                        $stInfo        = $statusMap[$orderStatus] ?? ['name' => 'Chờ xử lý', 'color' => 'warning', 'icon' => 'bi-hourglass-split'];
                        $payInfo       = $paymentMap[$paymentStatus] ?? ['name' => 'Chưa thanh toán', 'color' => 'danger'];
                      ?>
                      <tr>
                        <td class="fw-bold">#DH<?= str_pad($id, 5, '0', STR_PAD_LEFT) ?></td>
                        <td>
                          <div class="fw-semibold"><?= htmlspecialchars($customerName) ?></div>
                          <small class="text-muted"><?= htmlspecialchars($order['email'] ?? '') ?></small>
                        </td>
                        <td><?= htmlspecialchars($customerPhone) ?></td>
                        <td class="fw-bold text-danger"><?= number_format($totalAmount, 0, ',', '.') ?> ₫</td>
                        <td>
                          <span class="badge bg-<?= $stInfo['color'] ?> order-status-badge">
                            <i class="bi <?= $stInfo['icon'] ?> me-1"></i> <?= $stInfo['name'] ?>
                          </span>
                        </td>
                        <td>
                          <span class="badge bg-<?= $payInfo['color'] ?> order-status-badge">
                            <?= $payInfo['name'] ?>
                          </span>
                        </td>
                        <td class="small text-muted">
                          <?= $createdAt ? date('d/m/Y H:i', strtotime($createdAt)) : '—' ?>
                        </td>
                        <td class="text-end">
                          <a href="index.php?action=order_detail&id=<?= $id ?>" class="btn btn-sm btn-outline-primary fw-semibold">
                            <i class="bi bi-eye me-1"></i> Chi tiết
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                        Không có đơn hàng nào phù hợp.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
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
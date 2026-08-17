<?php $currentUrl = htmlspecialchars($_SERVER['REQUEST_URI']); ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <div class="text-uppercase small fw-bold text-primary">Quản trị</div>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Tổng quan nhanh về hệ thống tài khoản.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card border-start border-primary border-3 p-3 rounded bg-body-tertiary">
      <div class="text-uppercase small text-muted">Tổng tài khoản</div>
      <div class="fs-2 fw-bold"><?= (int) ($stats['total'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card border-start border-success border-3 p-3 rounded bg-body-tertiary">
      <div class="text-uppercase small text-muted">Đang hoạt động</div>
      <div class="fs-2 fw-bold"><?= (int) ($stats['active'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card border-start border-danger border-3 p-3 rounded bg-body-tertiary">
      <div class="text-uppercase small text-muted">Đã khóa</div>
      <div class="fs-2 fw-bold"><?= (int) ($stats['locked'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card border-start border-warning border-3 p-3 rounded bg-body-tertiary">
      <div class="text-uppercase small text-muted">Quản trị viên</div>
      <div class="fs-2 fw-bold"><?= (int) ($stats['admin'] ?? 0) ?></div>
    </div>
  </div>
</div>

<div class="p-4 rounded bg-body-tertiary">
  <h5 class="mb-2">Chào mừng, <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Admin') ?> 👋</h5>
  <p class="text-muted mb-3">Đây là trang tổng quan của hệ thống quản trị Bunnywear. Hiện tại module đang hoạt động
    đầy đủ là <strong>Quản lý tài khoản</strong>. Các module khác sẽ được bổ sung dần.</p>
  <a href="index.php?action=account/list" class="btn btn-primary">
    <i class="bi bi-people me-1"></i> Đi tới Quản lý tài khoản
  </a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

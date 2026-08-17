<?php $currentUrl = htmlspecialchars($_SERVER['REQUEST_URI']); ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
    <div>
      <div class="text-uppercase small fw-bold text-primary">Quản trị</div>
      <h1 class="h3 mb-1">Cài đặt</h1>
      <p class="text-muted mb-0">Thông tin tài khoản quản trị đang đăng nhập.</p>
    </div>
  </div>
</div>

<div class="p-4 rounded bg-body-tertiary" style="max-width: 480px;">
  <div class="mb-3">
    <div class="text-uppercase small text-muted">Họ và tên</div>
    <div class="fw-bold"><?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></div>
  </div>
  <div class="mb-3">
    <div class="text-uppercase small text-muted">Email</div>
    <div class="fw-bold"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></div>
  </div>
  <div class="mb-4">
    <div class="text-uppercase small text-muted">Quyền</div>
    <div class="fw-bold">Quản trị viên</div>
  </div>

  <a href="<?= BASE_URL ?>?action=/logout" class="btn btn-outline-danger">
    <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
  </a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

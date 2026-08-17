<?php
$flashSuccess = $_SESSION['admin_flash_success'] ?? null;
$flashError   = $_SESSION['admin_flash_error'] ?? null;
unset($_SESSION['admin_flash_success'], $_SESSION['admin_flash_error']);
?>
<?php if ($flashSuccess): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1" aria-hidden="true"></i> <?= htmlspecialchars($flashSuccess) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<?php if ($flashError): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1" aria-hidden="true"></i> <?= htmlspecialchars($flashError) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

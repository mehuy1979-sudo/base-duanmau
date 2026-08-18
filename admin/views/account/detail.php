<?php
$pageTitle  = 'Chi tiết tài khoản';
$activeMenu = 'account';

$roleLabels = [
    'admin'    => ['text' => 'Admin',      'class' => 'text-bg-primary'],
    'customer' => ['text' => 'Khách hàng', 'class' => 'text-bg-secondary'],
];
$statusLabels = [
    'active' => ['text' => 'Đang hoạt động', 'class' => 'text-bg-success'],
    'locked' => ['text' => 'Đã khóa',        'class' => 'text-bg-danger'],
];

$roleInfo   = $roleLabels[$account['role']] ?? $roleLabels['customer'];
$statusInfo = $statusLabels[$account['status']] ?? $statusLabels['active'];

require_once __DIR__ . '/../partials/header.php';
?>

<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Quản trị</p>
      <h1 class="h3 mb-1">Chi tiết tài khoản</h1>
      <p class="text-muted mb-0">Xem thông tin, khóa/mở khóa và sửa quyền tài khoản.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a class="btn btn-outline-secondary btn-sm" href="index.php?action=account/list">
      <i class="bi bi-arrow-left" aria-hidden="true"></i> Quay lại danh sách
    </a>
  </div>
</div>

<section class="row g-3">
  <div class="col-12 col-xl-4">
    <div class="panel h-100 text-center profile-card">
      <div class="profile-hero pt-4">
        <img class="avatar-img avatar-xl profile-photo" src="<?= !empty($account['avatar']) ? htmlspecialchars($account['avatar']) : 'assets/images/avatar/avatar.jpg' ?>" alt="<?= htmlspecialchars($account['fullname']) ?>">
        <h2 class="h5 mb-1"><?= htmlspecialchars($account['fullname']) ?></h2>
        <p class="text-muted mb-3">Mã tài khoản #<?= (int) $account['id'] ?></p>
        <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['text'] ?></span>
      </div>
      <div class="info-list mt-4 text-start">
        <div><span>Email</span><strong><?= htmlspecialchars($account['email']) ?></strong></div>
        <div><span>Ngày tạo</span><strong><?= htmlspecialchars(date('d/m/Y H:i', strtotime($account['created_at']))) ?></strong></div>
      </div>

      <div class="p-3 pt-0">
        <form method="post" action="index.php?action=account/toggle-lock"
              onsubmit="return confirm('<?= $account['status'] === 'active' ? 'Khóa tài khoản này?' : 'Mở khóa tài khoản này?' ?>');">
          <input type="hidden" name="id" value="<?= (int) $account['id'] ?>">
          <input type="hidden" name="redirect" value="index.php?action=account/detail&id=<?= (int) $account['id'] ?>">
          <?php if ($account['status'] === 'active'): ?>
            <button class="btn btn-danger w-100" type="submit">
              <i class="bi bi-lock" aria-hidden="true"></i> Khóa tài khoản
            </button>
          <?php else: ?>
            <button class="btn btn-success w-100" type="submit">
              <i class="bi bi-unlock" aria-hidden="true"></i> Mở khóa tài khoản
            </button>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12 col-xl-8">
    <div class="panel mb-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-person-lines-fill" aria-hidden="true"></i><span>Thông tin quyền hạn</span></h2>
          <p class="text-muted mb-0">Quyền hiện tại và trạng thái tài khoản.</p>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="mini-card"><span>Quyền hiện tại</span><strong><span class="badge <?= $roleInfo['class'] ?>"><?= $roleInfo['text'] ?></span></strong></div>
        </div>
        <div class="col-md-6">
          <div class="mini-card"><span>Trạng thái</span><strong><span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['text'] ?></span></strong></div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Sửa quyền tài khoản</span></h2>
          <p class="text-muted mb-0">Chuyển đổi giữa quyền Admin và Khách hàng.</p>
        </div>
      </div>

      <form method="post" action="index.php?action=account/change-role" class="row g-2 align-items-center"
            onsubmit="return confirm('Xác nhận thay đổi quyền tài khoản này?');">
        <input type="hidden" name="id" value="<?= (int) $account['id'] ?>">
        <div class="col-12 col-md-6">
          <select class="form-select" name="role" required>
            <option value="admin" <?= $account['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="customer" <?= $account['role'] === 'customer' ? 'selected' : '' ?>>Khách hàng</option>
          </select>
        </div>
        <div class="col-12 col-md-3">
          <button class="btn btn-primary w-100" type="submit">
            <i class="bi bi-save" aria-hidden="true"></i> Lưu quyền
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

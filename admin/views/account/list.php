<?php
$pageTitle  = 'Quản lý tài khoản';
$activeMenu = 'account';
$currentUrl = htmlspecialchars($_SERVER['REQUEST_URI']);

$roleLabels = [
    'admin'    => ['text' => 'Admin',        'class' => 'text-bg-primary'],
    'customer' => ['text' => 'Khách hàng',   'class' => 'text-bg-secondary'],
];
$statusLabels = [
    'active' => ['text' => 'Đang hoạt động', 'class' => 'text-bg-success'],
    'locked' => ['text' => 'Đã khóa',        'class' => 'text-bg-danger'],
];

require_once __DIR__ . '/../partials/header.php';
?>

<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Quản trị</p>
      <h1 class="h3 mb-1">Quản lý tài khoản</h1>
      <p class="text-muted mb-0">Danh sách, chi tiết, khóa/mở khóa và phân quyền tài khoản.</p>
    </div>
  </div>
</div>

<section class="row g-3 mb-1">
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card">
      <div class="metric-top">
        <span class="metric-label">Tổng tài khoản</span>
        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value"><?= (int) $stats['total'] ?></div>
    </article>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card">
      <div class="metric-top">
        <span class="metric-label">Đang hoạt động</span>
        <span class="metric-icon"><i class="bi bi-check-circle" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value"><?= (int) $stats['active'] ?></div>
    </article>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-danger">
      <div class="metric-top">
        <span class="metric-label">Đã khóa</span>
        <span class="metric-icon"><i class="bi bi-slash-circle" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value"><?= (int) $stats['locked'] ?></div>
    </article>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-warning">
      <div class="metric-top">
        <span class="metric-label">Quản trị viên</span>
        <span class="metric-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value"><?= (int) $stats['admin'] ?></div>
    </article>
  </div>
</section>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Danh sách tài khoản</span></h2>
      <p class="text-muted mb-0">Tìm kiếm, lọc theo quyền / trạng thái.</p>
    </div>
  </div>

  <form class="row g-2 align-items-center mb-3" method="get" action="index.php">
    <input type="hidden" name="action" value="account/list">
    <div class="col-12 col-md-4">
      <input type="text" class="form-control form-control-sm" name="keyword" placeholder="Tên, email hoặc số điện thoại" value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-6 col-md-3">
      <select class="form-select form-select-sm" name="role">
        <option value="">-- Tất cả quyền --</option>
        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="customer" <?= $role === 'customer' ? 'selected' : '' ?>>Khách hàng</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <select class="form-select form-select-sm" name="status">
        <option value="">-- Tất cả trạng thái --</option>
        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Đang hoạt động</option>
        <option value="locked" <?= $status === 'locked' ? 'selected' : '' ?>>Đã khóa</option>
      </select>
    </div>
    <div class="col-12 col-md-2 d-flex gap-2">
      <button class="btn btn-primary btn-sm w-100" type="submit"><i class="bi bi-search" aria-hidden="true"></i> Lọc</button>
      <a class="btn btn-outline-secondary btn-sm" href="index.php?action=account/list" title="Xóa bộ lọc"><i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i></a>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">Người dùng</th>
          <th scope="col">Quyền</th>
          <th scope="col">Trạng thái</th>
          <th scope="col">Ngày tạo</th>
          <th scope="col" class="text-end">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($accounts)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Không tìm thấy tài khoản phù hợp.</td>
          </tr>
        <?php endif; ?>

        <?php foreach ($accounts as $account): ?>
          <?php
            $roleInfo   = $roleLabels[$account['role']] ?? $roleLabels['customer'];
            $statusInfo = $statusLabels[$account['status']] ?? $statusLabels['active'];
          ?>
          <tr>
            <td>
              <div class="d-flex align-items-center gap-2">
                <img class="avatar-img avatar-sm" src="<?= !empty($account['avatar']) ? htmlspecialchars($account['avatar']) : 'assets/images/avatar/avatar.jpg' ?>" alt="<?= htmlspecialchars($account['fullname']) ?>">
                <div>
                  <p class="fw-semibold mb-0"><?= htmlspecialchars($account['fullname']) ?></p>
                  <p class="text-muted small mb-0"><?= htmlspecialchars($account['email']) ?></p>
                </div>
              </div>
            </td>
            <td><span class="badge <?= $roleInfo['class'] ?>"><?= $roleInfo['text'] ?></span></td>
            <td><span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['text'] ?></span></td>
            <td><?= htmlspecialchars(date('d/m/Y', strtotime($account['created_at']))) ?></td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                <a class="btn btn-light btn-sm" href="index.php?action=account/detail&id=<?= (int) $account['id'] ?>">
                  <i class="bi bi-eye" aria-hidden="true"></i> Chi tiết
                </a>
                <form method="post" action="index.php?action=account/toggle-lock" class="d-inline"
                      onsubmit="return confirm('<?= $account['status'] === 'active' ? 'Khóa tài khoản này?' : 'Mở khóa tài khoản này?' ?>');">
                  <input type="hidden" name="id" value="<?= (int) $account['id'] ?>">
                  <input type="hidden" name="redirect" value="<?= $currentUrl ?>">
                  <?php if ($account['status'] === 'active'): ?>
                    <button class="btn btn-outline-danger btn-sm" type="submit" title="Khóa tài khoản">
                      <i class="bi bi-lock" aria-hidden="true"></i>
                    </button>
                  <?php else: ?>
                    <button class="btn btn-outline-success btn-sm" type="submit" title="Mở khóa tài khoản">
                      <i class="bi bi-unlock" aria-hidden="true"></i>
                    </button>
                  <?php endif; ?>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
    <p class="text-muted small mb-0">Tổng cộng <?= (int) $total ?> tài khoản — Trang <?= (int) $page ?>/<?= (int) $totalPage ?></p>

    <?php if ($totalPage > 1): ?>
      <?php
        $buildPageUrl = function ($p) use ($keyword, $role, $status) {
            return 'index.php?' . http_build_query([
                'action'  => 'account/list',
                'keyword' => $keyword,
                'role'    => $role,
                'status'  => $status,
                'page'    => $p,
            ]);
        };
      ?>
      <nav aria-label="Phân trang tài khoản">
        <ul class="pagination pagination-sm mb-0">
          <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $buildPageUrl(max(1, $page - 1)) ?>">Trước</a>
          </li>
          <?php for ($p = 1; $p <= $totalPage; $p++): ?>
            <li class="page-item <?= $p === $page ? 'active' : '' ?>">
              <a class="page-link" href="<?= $buildPageUrl($p) ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= $page >= $totalPage ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $buildPageUrl(min($totalPage, $page + 1)) ?>">Sau</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

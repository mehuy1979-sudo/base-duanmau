<?php $activeMenu = $activeMenu ?? ''; ?>
<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
  <div class="sidebar-header">
    <a class="brand-mark" href="index.php?action=dashboard" aria-label="Trang quản trị">

    <a class="brand-mark" href="html/index.html" aria-label="Trang quản trị">
      <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
      <span class="brand-copy">
        <span class="brand-title">Bunnywear</span>
        <span class="brand-subtitle">Trang quản trị</span>
      </span>
    </a>
  </div>

  <nav class="sidebar-nav">
    <a class="nav-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>" href="index.php?action=dashboard" <?= $activeMenu === 'dashboard' ? 'aria-current="page"' : '' ?>>

    <a class="nav-link" href="html/index.html">
      <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
      <span class="nav-text">Dashboard</span>
    </a>
    <a class="nav-link <?= $activeMenu === 'account' ? 'active' : '' ?>" href="index.php?action=account/list" <?= $activeMenu === 'account' ? 'aria-current="page"' : '' ?>>
      <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      <span class="nav-text">Quản lý tài khoản</span>
    </a>
    <a class="nav-link <?= $activeMenu === 'stats' ? 'active' : '' ?>" href="index.php?action=stats" <?= $activeMenu === 'stats' ? 'aria-current="page"' : '' ?>>
      <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
      <span class="nav-text">Thống kê</span>
    </a>
    <a class="nav-link <?= $activeMenu === 'settings' ? 'active' : '' ?>" href="index.php?action=settings" <?= $activeMenu === 'settings' ? 'aria-current="page"' : '' ?>>

    <a class="nav-link" href="html/charts.html">
      <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
      <span class="nav-text">Thống kê</span>
    </a>
    <a class="nav-link" href="html/settings.html">

      <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
      <span class="nav-text">Cài đặt</span>
    </a>
  </nav>

  <div class="sidebar-user">
    <img class="avatar-img avatar-md sidebar-user-avatar" src="assets/images/avatar/avatar.jpg" alt="Admin">
    <strong><?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Admin') ?></strong>

    <strong>Admin</strong>
    <small>Active Workspace</small>
  </div>

  <div class="sidebar-footer">
    <span class="status-dot"></span>
    <span class="sidebar-footer-text">System running smoothly</span>
  </div>
</aside>

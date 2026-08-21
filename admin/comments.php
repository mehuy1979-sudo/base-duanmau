<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/CommentModel.php';

// Chỉ cho phép admin đã đăng nhập truy cập trang này
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '?action=/login');
    exit;
}

if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$model = new CommentModel();
$error = '';
$success = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int) ($_POST['id'] ?? 0);
        $action = $_POST['comment_action'] ?? '';

        if ($id <= 0 || !in_array($action, ['lock', 'unlock'], true)) {
            throw new RuntimeException('Yêu cầu không hợp lệ.');
        }

        $model->setLocked($id, $action === 'lock');
        header('Location: comments.php?view=detail&id=' . $id . '&updated=1');
        exit;
    }

    if (isset($_GET['updated'])) {
        $success = 'Đã cập nhật trạng thái bình luận.';
    }

    $view = $_GET['view'] ?? 'list';
    $detail = null;

    if ($view === 'detail') {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            throw new RuntimeException('Không tìm thấy bình luận.');
        }

        $detail = $model->find($id);
        if (!$detail) {
            throw new RuntimeException('Bình luận không tồn tại.');
        }
    }

    $keyword = trim($_GET['q'] ?? '');
    $status = $_GET['status'] ?? '';
    $page = max(1, (int) ($_GET['page'] ?? 1));

    $result = $model->getAll($keyword, $status, $page, 10);
    $stats = $model->getStats();
} catch (Throwable $e) {
    $error = $e->getMessage();
    $result = ['items' => [], 'total' => 0, 'page' => 1, 'per_page' => 10, 'pages' => 1];
    $stats = ['total' => 0, 'active' => 0, 'locked' => 0];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $detail ? 'Chi tiết bình luận' : 'Quản lý bình luận' ?> | Admin</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-content { padding: 28px; }
        .comment-card { border: 1px solid #e8ebf0; border-radius: 14px; background: #fff; }
        .comment-content { white-space: pre-wrap; line-height: 1.7; }
        .stat-card { border: 0; border-radius: 14px; box-shadow: 0 8px 24px rgba(15,23,42,.06); }
        .status-badge { font-size: .78rem; }
        .table td, .table th { vertical-align: middle; }
        .pagination .page-link { border-radius: 8px; margin: 0 3px; }
        .star-rating { letter-spacing: 2px; }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a class="brand-mark" href="index.php?action=dashboard">
                <span class="brand-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                <span class="brand-copy">
                    <span class="brand-title">adminHMD</span>
                    <span class="brand-subtitle">Admin Template</span>
                </span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <a class="nav-link" href="index.php?action=dashboard">
                <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            <a class="nav-link" href="index.php?action=account/list">
                <span class="nav-icon"><i class="bi bi-people"></i></span>
                <span class="nav-text">Users</span>
            </a>
            <a class="nav-link active" href="comments.php" aria-current="page">
                <span class="nav-icon"><i class="bi bi-chat-left-text"></i></span>
                <span class="nav-text">Bình luận & đánh giá</span>
            </a>
            <a class="nav-link" href="../database/merge_features.sql" target="_blank">
                <span class="nav-icon"><i class="bi bi-database"></i></span>
                <span class="nav-text">SQL bình luận</span>
            </a>
            <a class="nav-link" href="index.php?action=products">
                <span class="nav-icon"><i class="bi bi-table"></i></span>
                <span class="nav-text">Tables</span>
            </a>
            <a class="nav-link" href="index.php?action=settings">
                <span class="nav-icon"><i class="bi bi-gear"></i></span>
                <span class="nav-text">Settings</span>
            </a>
        </nav>

        <div class="sidebar-user">
            <img class="avatar-img avatar-md sidebar-user-avatar" src="assets/images/avatar/avatar.jpg" alt="Admin">
            <strong>Administrator</strong>
            <small>Comment management</small>
        </div>
    </aside>

    <div class="admin-main">
        <nav class="navbar admin-navbar navbar-expand bg-white">
            <div class="container-fluid px-3 px-lg-4">
                <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true">
                    <span></span><span></span><span></span>
                </button>
                <div class="ms-3">
                    <span class="fw-semibold">Quản trị nội dung</span>
                </div>
            </div>
        </nav>

        <main class="admin-content">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Không thể tải dữ liệu bình luận</div>
                    <div><?= e($error) ?></div>
                    <div class="mt-2 small">Nếu bạn vừa dùng bảng <code>comments</code> hiện tại, hãy chạy file <code>database/comment_management.sql</code> một lần trong phpMyAdmin để thêm <code>rating</code> và <code>is_locked</code>.</div>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i><?= e($success) ?>
                </div>
            <?php endif; ?>

            <?php if ($detail): ?>
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <div class="text-muted small mb-1">Bình luận #<?= e($detail['id']) ?></div>
                        <h1 class="h3 mb-1">Chi tiết bình luận</h1>
                        <p class="text-muted mb-0">Xem nội dung, người dùng, sản phẩm và trạng thái.</p>
                    </div>
                    <a href="comments.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Danh sách
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="comment-card p-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <div class="fw-semibold fs-5"><?= e($detail['user_name'] ?: 'Khách hàng') ?></div>
                                    <div class="text-muted small"><?= e($detail['user_email'] ?: 'Không có email') ?></div>
                                </div>
                                <?php if ($detail['normalized_status'] === 'locked'): ?>
                                    <span class="badge text-bg-danger status-badge"><i class="bi bi-lock-fill me-1"></i>Đã khóa</span>
                                <?php else: ?>
                                    <span class="badge text-bg-success status-badge"><i class="bi bi-unlock-fill me-1"></i>Đang hiển thị</span>
                                <?php endif; ?>
                            </div>

                            <div class="border-top pt-3">
                                <div class="small text-muted mb-1">Sản phẩm</div>
                                <div class="fw-semibold mb-3"><?= e($detail['product_name'] ?: 'Không xác định') ?></div>

                                <div class="small text-muted mb-1">Đánh giá</div>
                                <div class="star-rating text-warning fs-5 mb-3">
                                    <?php
                                    $rating = max(0, min(5, (int) $detail['rating']));
                                    for ($i = 1; $i <= 5; $i++):
                                    ?>
                                        <i class="bi <?= $i <= $rating ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="text-muted fs-6 ms-2"><?= $rating ?>/5</span>
                                </div>

                                <div class="small text-muted mb-1">Nội dung</div>
                                <div class="comment-content"><?= e($detail['content']) ?></div>

                                <div class="small text-muted mt-4 mb-1">Thời gian</div>
                                <div><?= e($detail['created_at'] ?: 'Không có dữ liệu') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="comment-card p-4">
                            <h2 class="h5 mb-3">Thao tác</h2>
                            <p class="text-muted small">
                                Khóa bình luận sẽ giữ nguyên dữ liệu trong CSDL nhưng có thể dùng trạng thái để ẩn khỏi phía khách hàng.
                            </p>

                            <?php if ($detail['normalized_status'] === 'locked'): ?>
                                <form method="post" onsubmit="return confirm('Mở khóa bình luận này?');">
                                    <input type="hidden" name="id" value="<?= e($detail['id']) ?>">
                                    <input type="hidden" name="comment_action" value="unlock">
                                    <button class="btn btn-success w-100">
                                        <i class="bi bi-unlock me-1"></i> Mở khóa bình luận
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" onsubmit="return confirm('Khóa bình luận này?');">
                                    <input type="hidden" name="id" value="<?= e($detail['id']) ?>">
                                    <input type="hidden" name="comment_action" value="lock">
                                    <button class="btn btn-danger w-100">
                                        <i class="bi bi-lock me-1"></i> Khóa bình luận
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <div class="text-muted small mb-1">Quản lý nội dung người dùng</div>
                        <h1 class="h3 mb-1">Bình luận & đánh giá</h1>
                        <p class="text-muted mb-0">Danh sách, xem chi tiết và khóa/mở khóa bình luận.</p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card stat-card p-3">
                            <div class="text-muted small">Tổng bình luận</div>
                            <div class="fs-3 fw-bold"><?= e($stats['total']) ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card stat-card p-3">
                            <div class="text-muted small">Đang hiển thị</div>
                            <div class="fs-3 fw-bold text-success"><?= e($stats['active']) ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card stat-card p-3">
                            <div class="text-muted small">Đã khóa</div>
                            <div class="fs-3 fw-bold text-danger"><?= e($stats['locked']) ?></div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form class="row g-2" method="get">
                            <div class="col-12 col-md-6">
                                <input type="search" class="form-control" name="q" value="<?= e($keyword) ?>"
                                       placeholder="Tìm theo nội dung, người dùng, sản phẩm...">
                            </div>
                            <div class="col-12 col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Đang hiển thị</option>
                                    <option value="locked" <?= $status === 'locked' ? 'selected' : '' ?>>Đã khóa</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 d-flex gap-2">
                                <button class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-search me-1"></i> Lọc
                                </button>
                                <a class="btn btn-outline-secondary" href="comments.php">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Nội dung</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$result['items']): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        Không có bình luận phù hợp.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($result['items'] as $item): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= e($item['id']) ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= e($item['user_name'] ?: 'Khách hàng') ?></div>
                                            <div class="small text-muted"><?= e($item['user_email'] ?: '') ?></div>
                                        </td>
                                        <td><?= e($item['product_name'] ?: 'Không xác định') ?></td>
                                        <td style="min-width:240px;max-width:360px;">
                                            <div class="text-truncate" title="<?= e($item['content']) ?>">
                                                <?= e($item['content']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-warning">
                                                <?php
                                                $rating = max(0, min(5, (int) $item['rating']));
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo '<i class="bi ' . ($i <= $rating ? 'bi-star-fill' : 'bi-star') . '"></i>';
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($item['normalized_status'] === 'locked'): ?>
                                                <span class="badge text-bg-danger status-badge">Đã khóa</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-success status-badge">Đang hiển thị</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small"><?= e($item['created_at'] ?: '') ?></td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="comments.php?view=detail&id=<?= e($item['id']) ?>">
                                                <i class="bi bi-eye me-1"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($result['pages'] > 1): ?>
                        <div class="card-footer bg-white">
                            <nav>
                                <ul class="pagination mb-0 justify-content-end">
                                    <?php for ($p = 1; $p <= $result['pages']; $p++): ?>
                                        <li class="page-item <?= $p === $result['page'] ? 'active' : '' ?>">
                                            <a class="page-link"
                                               href="?q=<?= urlencode($keyword) ?>&status=<?= urlencode($status) ?>&page=<?= $p ?>">
                                                <?= $p ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

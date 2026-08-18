<?php

class AccountController
{
    private AccountModel $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    // Danh sách tài khoản (tìm kiếm + lọc quyền/trạng thái + phân trang)
    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $role    = trim($_GET['role'] ?? '');
        $status  = trim($_GET['status'] ?? '');
        $page    = max(1, (int) ($_GET['page'] ?? 1));

        $result = $this->accountModel->getList($keyword, $role, $status, $page, 8);
        $stats  = $this->accountModel->getStats();

        $accounts  = $result['items'];
        $total     = $result['total'];
        $page      = $result['page'];
        $totalPage = $result['total_page'];

        require_once __DIR__ . '/../views/account/list.php';
    }

    // Chi tiết 1 tài khoản
    public function detail(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $account = $this->accountModel->getById($id);

        if (!$account) {
            $_SESSION['admin_flash_error'] = 'Không tìm thấy tài khoản #' . $id;
            header('Location: index.php?action=account/list');
            exit;
        }

        require_once __DIR__ . '/../views/account/detail.php';
    }

    // Khóa / Mở khóa tài khoản
    public function toggleLock(): void
    {
        $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
        $redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'index.php?action=account/list';

        $newStatus = $this->accountModel->toggleLock($id);

        if ($newStatus === null) {
            $_SESSION['admin_flash_error'] = 'Không tìm thấy tài khoản #' . $id;
        } else {
            $_SESSION['admin_flash_success'] = $newStatus === 'locked'
                ? 'Đã khóa tài khoản #' . $id
                : 'Đã mở khóa tài khoản #' . $id;
        }

        header('Location: ' . $redirect);
        exit;
    }

    // Sửa quyền tài khoản (admin / customer)
    public function changeRole(): void
    {
        $id   = (int) ($_POST['id'] ?? 0);
        $role = trim($_POST['role'] ?? '');

        $ok = $this->accountModel->changeRole($id, $role);

        if ($ok) {
            $_SESSION['admin_flash_success'] = 'Đã cập nhật quyền tài khoản #' . $id . ' thành "' . $role . '"';
        } else {
            $_SESSION['admin_flash_error'] = 'Cập nhật quyền thất bại. Vui lòng kiểm tra lại.';
        }

        header('Location: index.php?action=account/detail&id=' . $id);
        exit;
    }
}

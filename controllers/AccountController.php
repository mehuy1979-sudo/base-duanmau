<?php

class AccountController
{
    private AccountModel $accountModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->accountModel = new AccountModel();
    }

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     */
    private function checkLogin(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?action=/login');
            exit;
        }
    }

    /**
     * Hiển thị thông tin tài khoản
     */
    public function index(): void
    {
        $this->checkLogin();

        $userId = (int) $_SESSION['user']['id'];

        $account = $this->accountModel->getById($userId);

        if (!$account) {
            $_SESSION['account_error'] = 'Không tìm thấy thông tin tài khoản.';
            header('Location: ' . BASE_URL . '?action=/');
            exit;
        }

        $success = $_SESSION['account_success'] ?? null;
        $error   = $_SESSION['account_error'] ?? null;

        unset(
            $_SESSION['account_success'],
            $_SESSION['account_error']
        );

        require_once PATH_VIEW . 'account/index.php';
    }

    /**
     * Hiển thị form chỉnh sửa tài khoản
     */
    public function edit(): void
    {
        $this->checkLogin();

        $userId = (int) $_SESSION['user']['id'];

        $account = $this->accountModel->getById($userId);

        if (!$account) {
            $_SESSION['account_error'] = 'Không tìm thấy tài khoản.';
            header('Location: ' . BASE_URL . '?action=/account');
            exit;
        }

        $error = $_SESSION['account_error'] ?? null;

        unset($_SESSION['account_error']);

        require_once PATH_VIEW . 'account/edit.php';
    }

    /**
     * Xử lý cập nhật thông tin tài khoản
     */
    public function update(): void
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?action=/account/edit');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];

        $account = $this->accountModel->getById($userId);

        if (!$account) {
            $_SESSION['account_error'] = 'Không tìm thấy tài khoản.';
            header('Location: ' . BASE_URL . '?action=/account');
            exit;
        }

        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        // Kiểm tra họ tên
        if ($fullname === '') {
            $_SESSION['account_error'] = 'Họ tên không được để trống.';
            header('Location: ' . BASE_URL . '?action=/account/edit');
            exit;
        }

        // Kiểm tra mật khẩu nếu người dùng nhập
        if ($password !== '') {

            if (strlen($password) < 6) {
                $_SESSION['account_error'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                header('Location: ' . BASE_URL . '?action=/account/edit');
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['account_error'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: ' . BASE_URL . '?action=/account/edit');
                exit;
            }
        }

        // Dữ liệu cần cập nhật
        $data = [
            'fullname' => $fullname,
            'phone'    => $phone !== '' ? $phone : null,
        ];

        // Nếu có nhập mật khẩu mới thì mã hóa
        if ($password !== '') {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $result = $this->accountModel->update($userId, $data);

        if (!$result) {
            $_SESSION['account_error'] = 'Cập nhật thông tin thất bại.';
            header('Location: ' . BASE_URL . '?action=/account/edit');
            exit;
        }

        // Cập nhật lại session
        $_SESSION['user']['fullname'] = $fullname;

        $_SESSION['account_success'] = 'Cập nhật thông tin tài khoản thành công!';

        header('Location: ' . BASE_URL . '?action=/account');
        exit;
    }
}
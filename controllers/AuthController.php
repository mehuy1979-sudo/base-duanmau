<?php

class AuthController
{
    private AccountModel $accountModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->accountModel = new AccountModel();
    }

    // Hiển thị trang đăng nhập
    public function showLogin(): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirectByRole($_SESSION['user']['role']);
        }

        $error   = $_SESSION['login_error'] ?? null;
        $success = $_SESSION['login_success'] ?? null;
        $old     = $_SESSION['login_old'] ?? [];

        unset($_SESSION['login_error'], $_SESSION['login_success'], $_SESSION['login_old']);

        require_once PATH_VIEW . 'login.php';
    }

    // Xử lý đăng nhập
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?action=/login');
            exit;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ email và mật khẩu.';
            $_SESSION['login_old']   = ['email' => $email];
            header('Location: ?action=/login');
            exit;
        }

        $account = $this->accountModel->attemptLogin($email, $password);

        if (!$account) {
            $_SESSION['login_error'] = 'Email hoặc mật khẩu không chính xác.';
            $_SESSION['login_old']   = ['email' => $email];
            header('Location: ?action=/login');
            exit;
        }

        if (($account['status'] ?? 'active') === 'locked') {
            $_SESSION['login_error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.';
            $_SESSION['login_old']   = ['email' => $email];
            header('Location: ?action=/login');
            exit;
        }

        // Lưu thông tin đăng nhập vào session
        $_SESSION['user'] = [
            'id'       => $account['id'],
            'fullname' => $account['fullname'],
            'email'    => $account['email'],
            'role'     => $account['role'],
        ];

        // Giữ tương thích với các đoạn code cũ đang dùng $_SESSION['user_id'] (giỏ hàng, đặt hàng...)
        $_SESSION['user_id'] = $account['id'];

        $this->redirectByRole($account['role']);
    }

    // Hiển thị trang đăng ký
    public function showRegister(): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirectByRole($_SESSION['user']['role']);
        }

        $error = $_SESSION['register_error'] ?? null;
        $old   = $_SESSION['register_old'] ?? [];

        unset($_SESSION['register_error'], $_SESSION['register_old']);

        require_once PATH_VIEW . 'register.php';
    }

    // Xử lý đăng ký
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?action=/register');
            exit;
        }

        $fullname        = trim($_POST['fullname'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $phone           = trim($_POST['phone'] ?? '');
        $password        = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        $old = ['fullname' => $fullname, 'email' => $email, 'phone' => $phone];

        if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['register_error'] = 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
            $_SESSION['register_old']   = $old;
            header('Location: ?action=/register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Email không hợp lệ.';
            $_SESSION['register_old']   = $old;
            header('Location: ?action=/register');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['register_error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            $_SESSION['register_old']   = $old;
            header('Location: ?action=/register');
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['register_error'] = 'Mật khẩu xác nhận không khớp.';
            $_SESSION['register_old']   = $old;
            header('Location: ?action=/register');
            exit;
        }

        if ($this->accountModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Email này đã được đăng ký. Vui lòng đăng nhập hoặc dùng email khác.';
            $_SESSION['register_old']   = $old;
            header('Location: ?action=/register');
            exit;
        }

        $this->accountModel->register([
            'fullname' => $fullname,
            'email'    => $email,
            'phone'    => $phone,
            'password' => $password,
        ]);

        $_SESSION['login_success'] = 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.';
        $_SESSION['login_old']     = ['email' => $email];

        header('Location: ?action=/login');
        exit;
    }

    // Đăng xuất
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();

        header('Location: ' . BASE_URL . '?action=/');
        exit;
    }

    // Điều hướng theo vai trò sau khi đăng nhập
    private function redirectByRole(string $role): void
    {
        if ($role === 'admin') {
            header('Location: ' . BASE_URL . 'admin/index.php');
        } else {
            header('Location: ' . BASE_URL . '?action=/');
        }
        exit;
    }
}

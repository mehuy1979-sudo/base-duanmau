<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = (string)($_POST['password'] ?? '');

            if (empty($fullname) || empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
                include PATH_VIEW . "register.php";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userModel = new UserModel();
            if ($userModel->create($fullname, $email, $hashedPassword)) {
                header("Location: " . BASE_URL . "?action=login&registered=1");
                exit; 
            } else {
                $error = "Email này đã được sử dụng. Vui lòng chọn email khác!";
                include PATH_VIEW . "register.php";
            }
        } else {
            include PATH_VIEW . "register.php";
        }
    }

    public function login() {
        // Nếu đã đăng nhập rồi thì chuyển hướng
        if (!empty($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                header("Location: " . BASE_URL . "admin/index.php");
            } else {
                header("Location: " . BASE_URL);
            }
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST['email'] ?? '');
            $password = (string)($_POST['password'] ?? '');

            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                if (($user['status'] ?? 'active') === 'locked') {
                    $error = "Tài khoản của bạn đang bị tạm khóa. Vui lòng liên hệ quản trị viên!";
                    include PATH_VIEW . "login.php";
                    return;
                }

                // Lưu session đầy đủ cho toàn hệ thống
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'fullname' => $user['fullname'],
                    'email'    => $user['email'],
                    'phone'    => $user['phone'] ?? '',
                    'role'     => $user['role'] ?? 'customer',
                ];

                // Phân quyền chuyển hướng
                if (($user['role'] ?? '') === 'admin') {
                    header("Location: " . BASE_URL . "admin/index.php");
                } else {
                    header("Location: " . BASE_URL);
                }
                exit;
            } else {
                $error = "Sai địa chỉ email hoặc mật khẩu!";
                include PATH_VIEW . "login.php";
            }
        } else {
            include PATH_VIEW . "login.php";
        }   
    }

    public function logout() {
        unset($_SESSION['user'], $_SESSION['user_id'], $_SESSION['fullname']);
        session_destroy();
        header("Location: " . BASE_URL . "?action=login");
        exit;
    }
}

<?php
require_once "models/UserModel.php";

class UserController {
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $userModel = new UserModel();
            if ($userModel->create($fullname, $email, $password)) {
                // Sau khi đăng ký thành công thì chuyển hướng sang login
                header("Location: ?action=login");
                exit; 
            } else {
                echo "Có lỗi xảy ra hoặc email đã tồn tại!";
            }
        } else {
            include "views/register.php"; // form đăng ký
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                echo "Đăng nhập thành công! Xin chào " . $user['fullname'];
            } else {
                echo "Sai email hoặc mật khẩu!";
            }
        } else {
            include "views/login.php"; // form đăng nhập
        }   
    }

    public function logout() {
        session_destroy();
        header("Location: ?action=login");
    }
}

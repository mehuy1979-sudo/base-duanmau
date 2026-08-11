<?php
class UserModel {
    private $pdo;

    public function __construct() {
        try {
            // Nếu MySQL root KHÔNG có mật khẩu
            $this->pdo = new PDO("mysql:host=localhost;dbname=shop_quanao;charset=utf8", "root", "2006");

    
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối DB thất bại: " . $e->getMessage());
        }
    }

    public function create($fullname, $email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users(fullname,email,password) VALUES (?,?,?)");
        return $stmt->execute([$fullname, $email, $password]);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}

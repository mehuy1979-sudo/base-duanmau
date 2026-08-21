<?php

class UserModel
{
    private $pdo;

    /**
     * KẾT NỐI DATABASE
     */
    public function __construct()
    {
        try {
            if (class_exists('Database')) {
                $this->pdo = Database::getConnection();
            } else {
                $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4", DB_HOST, DB_PORT, DB_NAME);
                $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
            }
        } catch (PDOException $e) {
            $this->pdo = null;
        }
    }

    /**
     * KIỂM TRA EMAIL ĐÃ TỒN TẠI CHƯA
     */
    public function findByEmail($email)
    {
        if (!$this->pdo) return null;
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * TẠO TÀI KHOẢN
     */
    public function create($fullname, $email, $password)
    {
        if (!$this->pdo) return false;
        // Kiểm tra email đã tồn tại
        $existingUser = $this->findByEmail($email);
        if ($existingUser) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (fullname, email, password, role, status) VALUES (?, ?, ?, 'customer', 'active')"
            );
            return $stmt->execute([$fullname, $email, $password]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * TÌM USER THEO ID
     */
    public function findById($id)
    {
        if (!$this->pdo) return null;
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function updatePassword($email, $password)
    {
        if (!$this->pdo) return false;
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            return $stmt->execute([$password, $email]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
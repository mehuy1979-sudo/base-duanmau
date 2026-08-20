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

            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=shop_quanao;charset=utf8",
                "root",
                "2006"
            );

            $this->pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->pdo->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {

            die("Kết nối DB thất bại: " . $e->getMessage());
        }
    }


    /**
     * KIỂM TRA EMAIL ĐÃ TỒN TẠI CHƯA
     */
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }


    /**
     * TẠO TÀI KHOẢN
     */
    public function create($fullname, $email, $password)
    {
        // Kiểm tra email đã tồn tại
        $existingUser = $this->findByEmail($email);

        if ($existingUser) {
            return false;
        }


        // Tạo tài khoản customer
        $stmt = $this->pdo->prepare(
            "INSERT INTO users
            (
                fullname,
                email,
                password,
                role,
                status
            )
            VALUES
            (
                ?,
                ?,
                ?,
                'customer',
                'active'
            )"
        );


        return $stmt->execute([
            $fullname,
            $email,
            $password
        ]);
    }


    /**
     * TÌM USER THEO ID
     */
    public function findById($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE id = ? LIMIT 1"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function updatePassword($email, $password)
{
    $stmt = $this->pdo->prepare(
        "UPDATE users SET password = ? WHERE email = ?"
    );

    return $stmt->execute([
        $password,
        $email
    ]);
}
}
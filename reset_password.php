<?php

require_once "models/UserModel.php";

$model = new UserModel();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $message = "Vui lòng nhập đầy đủ thông tin!";
    } else {

        $hash = password_hash($password, PASSWORD_BCRYPT);

        if ($model->updatePassword($email, $hash)) {
            $message = "Đổi mật khẩu thành công!";
        } else {
            $message = "Không tìm thấy tài khoản!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
</head>

<body>

    <h2>Đổi mật khẩu</h2>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <br>

        <div>
            <label>Mật khẩu mới</label>
            <input type="password" name="password" required>
        </div>

        <br>

        <button type="submit">Đổi mật khẩu</button>

    </form>

</body>
</html>
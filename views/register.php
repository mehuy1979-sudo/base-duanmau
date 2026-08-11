<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký - Shop Quần Áo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('assets/fashion-bg.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .register-box {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .register-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .register-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .register-box button {
      width: 100%;
      padding: 12px;
      background: #e91e63;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .register-box button:hover {
      background: #d81b60;
    }
    .register-box p {
      text-align: center;
      margin-top: 15px;
    }
    .register-box a {
      color: #e91e63;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>Đăng ký tài khoản</h2>
    <form method="post" action="?action=register">
      <input type="text" name="fullname" placeholder="Họ và tên" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="?action=login">Đăng nhập ngay</a></p>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập - Shop Quần Áo</title>
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
    .login-box {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .login-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .login-box button {
      width: 100%;
      padding: 12px;
      background: #e91e63;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .login-box button:hover {
      background: #d81b60;
    }
    .login-box .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
      margin-top: 10px;
    }
    .login-box p {
      text-align: center;
      margin-top: 15px;
    }
    .login-box a {
      color: #e91e63;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Đăng nhập</h2>
    <form method="post" action="?action=login">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <div class="options">
        <label><input type="checkbox" name="remember"> Nhớ đăng nhập</label>
        <a href="?action=forgot-password">Quên mật khẩu?</a>
      </div>
      <button type="submit">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="?action=register">Đăng ký ngay</a></p>
  </div>
</body>
</html>

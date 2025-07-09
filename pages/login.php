<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Log In - JUSTDONATE</title>
  <link rel="stylesheet" href="../css/login.css" />
  <script src="../js/login-script.js"></script>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">

</head>
<body>

  <!-- พื้นหลังฟุ้ง ๆ -->
  <div class="background-blur"></div>

  <div class="login-container">
    <div class="logo">
      <img src="../assets/logo.png" alt="JUSTDONATE Logo" />
      <h1>JUSTDONATE</h1>
    </div>

    <h2>🔑 เข้าสู่ระบบ</h2>

    <form action="auth.php" method="POST">
      <div class="input-container">
        <span class="icon">👤</span>
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
      </div>

      <div class="input-container">
        <span class="icon">🔒</span>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>
      </div>

      <button type="submit">
        🔓 เข้าสู่ระบบ
      </button>
    </form>

    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
  </div>

</body>
</html>

<html lang="th"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/login-script.js"></script>
</head>
<body>

<div class="login-container" style="opacity: 1; transform: translateY(0px); transition: opacity 0.5s, transform 0.5s;">
    <h2>🔑 เข้าสู่ระบบ</h2>
    
    
   <form action="auth.php" method="POST">
    <div class="input-container">
        <span class="icon">👤</span>
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required="">
    </div>
    
    <div class="input-container">
        <span class="icon">🔒</span>
        <input type="password" name="password" placeholder="รหัสผ่าน" required="">
    </div>
    
    <button type="submit"><span>🔑 เข้าสู่ระบบ</span></button>
</form>


    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
</div>



</body></html>
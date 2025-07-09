<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>สมัครสมาชิก</title>
  <link rel="stylesheet" href="/css/register.css" />
  <link rel="icon" href="data:,">
  <link rel="icon" type="image/x-icon" href="/favicon.ico">

</head>
<body>

<div class="register-container">
  <h2>📝 สมัครสมาชิกกับ JUSTDONATE</h2>
  <p class="subtext">ร่วมเป็นส่วนหนึ่งในการเปลี่ยนแปลงสังคมผ่านการสนับสนุนของคุณ 💛</p>

  <form action="register_process.php" method="POST">
    <div class="input-container">
      <span class="icon">👤</span>
      <input type="text" name="username" placeholder="ชื่อผู้ใช้" required />
    </div>

<div class="input-container password-wrapper">
  <span class="icon">🔒</span>
  <input type="password" name="password" placeholder="รหัสผ่าน" required />
  <img src="/assets/eyebrow.png" class="toggle-password" onclick="togglePassword(this)" alt="แสดงรหัสผ่าน" />
</div>

<div class="input-container password-wrapper">
  <span class="icon">🔁</span>
  <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" required />
  <img src="/assets/eyebrow.png" class="toggle-password" onclick="togglePassword(this)" alt="แสดงรหัสผ่าน" />
</div>

    <button type="submit">✅ สมัครสมาชิก</button>
  </form>

  

  <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
</div>

<script>
function togglePassword(img) {
  const input = img.parentElement.querySelector('input');
  const showIcon = "/assets/eyebrow.png";
  const hideIcon = "/assets/witness.png";

  const isHidden = input.type === "password";
  input.type = isHidden ? "text" : "password";
  img.src = isHidden ? hideIcon : showIcon;
  img.alt = isHidden ? "ซ่อนรหัสผ่าน" : "แสดงรหัสผ่าน";
}
</script>



<script>
  window.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.register-container').classList.add('show');
  });
</script>

</body>
</html>

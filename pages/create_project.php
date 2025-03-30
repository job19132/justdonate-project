<?php 
session_start(); // เริ่มต้น session
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สร้างโครงการใหม่ | JUSTDONATE</title>
  <link rel="stylesheet" href="/css/create_project.css">
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>

<header class="navbar">
  <div class="navbar-inner">
    <a href="/index.php" class="logo">JUSTDONATE</a>

    <nav>
      <a href="/pages/project_list.php">โครงการ</a>

      <?php if (isset($_SESSION['username'])): ?>
        <!-- ถ้าเป็นผู้ใช้ที่ล็อกอินแล้ว -->
        <span class="user-info">
          👤 <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- แอดมิน -->
            <span class="badge-admin">[Admin]</span>
            <a href="/pages/admin_projects.php" class="btn-admin">📋 อนุมัติ/จัดการโครงการ</a>
          <?php endif; ?>
        </span>
        <a href="/pages/logout.php" class="btn-logout">🚪 ออกจากระบบ</a>
      <?php else: ?>
        <a href="/pages/login.php" class="btn-login">🔑 เข้าสู่ระบบ</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<div class="form-container">
  <h2>📝 สร้างโครงการระดมทุน</h2>

  <form action="create_project_process.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="ชื่อโครงการ" required>
    <textarea name="description" placeholder="รายละเอียดโครงการ" rows="5" required></textarea>
    <input type="number" name="goal_amount" placeholder="เป้าหมาย (บาท)" required>
    <input type="file" name="image">
    <button type="submit">✅ สร้างโครงการ</button>
  </form>
</div>

</body>
</html>

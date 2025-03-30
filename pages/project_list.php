<?php
require '../config/db.php';
session_start();

$projects = $conn->query("SELECT * FROM projects WHERE status = 'approved' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>โครงการทั้งหมด</title>
  <link rel="stylesheet" href="/css/project-list.css">
</head>
<body>

<header class="navbar">
  <div class="navbar-inner">
    <a href="/index.php" class="logo">JUSTDONATE</a>

    <nav>
      <?php if (isset($_SESSION['username'])): ?>
        <span class="user-info">
          👤 <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <span class="badge-admin">[Admin]</span>
            <a href="/pages/admin_projects.php" class="btn-admin">📋 อนุมัติ/จัดการโครงการ</a>
          <?php endif; ?>
        </span>
        <a href="/pages/create_project.php" class="btn-create-project">📝 เปิดโครงการใหม่</a>
        <a href="/pages/logout.php" class="btn-logout">🚪 ออกจากระบบ</a>
      <?php else: ?>
        <a href="/pages/login.php" class="btn-login">🔑 เข้าสู่ระบบ</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<div class="container">
  <h2> โครงการระดมทุนทั้งหมด</h2>

  <div class="project-list">
    <?php while ($row = $projects->fetch_assoc()): ?>
      <div class="project-card">
        <img src="/uploads/<?= htmlspecialchars($row['image']) ?>" alt="project" />
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p> เป้าหมาย: <?= number_format($row['goal_amount']) ?> บาท</p>
        <a href="/pages/support.php?project_id=<?= $row['id'] ?>" class="donate-button">สนับสนุน</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <!-- ฟอร์มลบโครงการสำหรับแอดมิน -->
          <form action="delete_project.php" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโครงการนี้?');">
            <input type="hidden" name="project_id" value="<?= $row['id'] ?>">
            <button type="submit" class="btn-delete">ลบโครงการ</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>

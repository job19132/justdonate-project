<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "คุณไม่มีสิทธิ์เข้าถึงหน้านี้";
  exit();
}

$pendingProjects = $conn->query("SELECT * FROM projects WHERE status = 'pending' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>อนุมัติโครงการ | JUSTDONATE</title>
  <link rel="stylesheet" href="/css/admin_projects.css">
</head>

<body>
<header class="navbar">
  <div class="navbar-inner">
    <a href="/index.php" class="logo">JUSTDONATE</a>

    <nav>
      <a href="/pages/project_list.php">โครงการ</a>

      <?php if (isset($_SESSION['username'])): ?>
        <span class="user-info">
          👤 <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <span class="badge-admin">[Admin]</span>
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

<!-- 🏆 รายการโครงการที่กำลังรออนุมัติ -->
<div class="admin-container">
  <h2>📋 รายการโครงการที่รออนุมัติ</h2>

  <?php if ($pendingProjects->num_rows === 0): ?>
    <p>ไม่มีโครงการที่รออนุมัติในขณะนี้</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>ชื่อโครงการ</th>
          <th>รายละเอียด</th>
          <th>เป้าหมาย (บาท)</th>
          <th>สร้างเมื่อ</th>
          <th>รูป</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($project = $pendingProjects->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($project['title']) ?></td>
            <td><?= htmlspecialchars($project['description']) ?></td>
            <td><?= number_format($project['goal_amount']) ?> บาท</td>
            <td><?= $project['created_at'] ?></td>
            <td>
              <?php if ($project['image']): ?>
                <img src="/uploads/<?= $project['image'] ?>" width="80" height="60" />
              <?php else: ?>
                <span>ไม่มีรูป</span>
              <?php endif; ?>
            </td>
            <td>
              <!-- ✅ อนุมัติ -->
              <form action="approve_project.php" method="POST" style="display:inline-block;">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="btn-approve">✅ อนุมัติ</button>
              </form>

              <!-- ❌ ปฏิเสธ -->
              <form action="approve_project.php" method="POST" style="display:inline-block;" onsubmit="return confirm('แน่ใจหรือไม่ว่าต้องการปฏิเสธโครงการนี้?');">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <input type="hidden" name="action" value="reject">
                <button type="submit" class="btn-reject">❌ ปฏิเสธ</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>

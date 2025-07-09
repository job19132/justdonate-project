<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JUSTDONATE</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="../css/styles.css"> <!-- เชื่อม CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
<!-- 🎯 ตัวเลือกค้นหาโครงการระดมทุน -->
<form method="GET" action="index.php" class="search-form">
  <div class="search-bar">
    <span class="icon">🔍</span>
    <input type="text" id="search" name="search" placeholder="ค้นหาโครงการที่คุณสนใจ" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  </div>
  <button type="submit" class="search-button">🔍 ค้นหา</button>
</form>

<!-- 🏆 รายชื่อโครงการที่กำลังระดมทุน -->
<?php
require 'config/db.php'; // เชื่อมฐานข้อมูล

// ตรวจสอบค่าค้นหา
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

// การคำนวณหน้า
$projects_per_page = 8; // จำนวนโปรเจกต์ต่อหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $projects_per_page;

// คำสั่ง SQL กับการค้นหาและการแบ่งหน้า
$sql = "SELECT * FROM projects WHERE status = 'approved' AND (title LIKE ? OR description LIKE ?) ORDER BY created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $search, $search, $start_from, $projects_per_page);
$stmt->execute();
$result = $stmt->get_result();

// จำนวนโปรเจกต์ทั้งหมด
$total_sql = "SELECT COUNT(*) AS total FROM projects WHERE status = 'approved' AND (title LIKE ? OR description LIKE ?)";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("ss", $search, $search);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_projects = $total_row['total'];
$total_pages = ceil($total_projects / $projects_per_page);
?>

<div class="project-list">
  <?php if ($result->num_rows > 0): ?>
    <?php while ($project = $result->fetch_assoc()): ?>
      <div class="project-card">
        <a href="/pages/project-detail.php?id=<?= $project['id'] ?>" class="project-card-link">
          <div class="project-image">
            <img src="/uploads/<?= $project['image'] ?>" alt="<?= htmlspecialchars($project['title']) ?>">
          </div>
          <div class="project-info">
            <h3><?= htmlspecialchars($project['title']) ?></h3>
            <p>เป้าหมาย: <?= number_format($project['goal_amount']) ?> บาท</p>
            <p>ระดมทุนได้: <?= number_format($project['raised_amount']) ?> บาท</p>
            <a href="/pages/support.php?project_id=<?= $project['id'] ?>" class="donate-button">สนับสนุน</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <form action="/pages/delete_project.php" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโครงการนี้?');">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <button type="submit" class="btn-delete" style="margin-top: 10px; background: #e11d48;">❌ ลบโครงการ</button>
              </form>
            <?php endif; ?>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>ยังไม่มีโครงการที่ได้รับการอนุมัติ</p>
  <?php endif; ?>
</div>

<!-- 🔹 Pagination -->
<div class="pagination">
  <?php if ($total_pages > 1): ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  <?php endif; ?>
</div>

</body>
</html>

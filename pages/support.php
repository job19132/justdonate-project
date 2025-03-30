<?php
session_start();
require '../config/db.php';

$project_id = $_GET['project_id'] ?? $_POST['project_id'] ?? null;

if (!$project_id) {
    showError();
    exit();
}

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ? AND status = 'approved'");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    showError();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        $error_message = "จำนวนเงินต้องมากกว่าศูนย์";
    } else {
        $stmt = $conn->prepare("UPDATE projects SET raised_amount = raised_amount + ? WHERE id = ?");
        $stmt->bind_param("di", $amount, $project_id);
        $stmt->execute();

        header("Location: /index.php");
        exit();
    }
}

function showError() {
    echo "
    <div style='text-align:center; margin-top: 100px; font-size: 18px; color: #d32f2f;'>
        ❗ ไม่พบโครงการ หรือโครงการยังไม่ผ่านการอนุมัติ
        <br><br>
        <a href='/pages/project_list.php' style='color: #2563eb; text-decoration: none;'>🔙 กลับไปยังหน้าโครงการทั้งหมด</a>
    </div>";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สนับสนุนโครงการ | JUSTDONATE</title>
  <link rel="stylesheet" href="/css/support.css">
</head>
<body>

<header class="navbar">
  <div class="navbar-inner">
    <a href="/index.php" class="logo">JUSTDONATE</a>

    <nav>
      <a href="/index.php">หน้าแรก</a>
      <a href="/pages/project_list.php">โครงการ</a>

      <?php if (isset($_SESSION['username'])): ?>
        <span class="user-info">
          👤 <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
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

<!-- 🔹 Main content for the project support -->
<div class="container">
  <div class="project-header">
    <h2 class="heading">🎁 สนับสนุนโครงการ</h2>
    <div class="project-image">
      <img src="/uploads/<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="project-img">
    </div>
  </div>

  <div class="project-info">
    <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
    <p class="project-description"><?= nl2br(htmlspecialchars($project['description'])) ?></p>

    <div class="progress-bar-container">
      <div class="progress-bar" style="width: <?= ($project['raised_amount'] / $project['goal_amount']) * 100 ?>%;"></div>
      <p class="progress-info">ยอดที่ระดมได้: <?= number_format($project['raised_amount']) ?> บาท / เป้าหมาย: <?= number_format($project['goal_amount']) ?> บาท</p>
    </div>

    <?php if (isset($error_message)): ?>
      <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form action="support.php?project_id=<?= $project['id'] ?>" method="POST" class="support-form">
      <label class="amount-label">💸 จำนวนเงินที่คุณต้องการสนับสนุน (บาท)</label>
      <input type="number" name="amount" min="1" required class="amount-input">
      <button type="submit" class="donate-button">✅ สนับสนุน</button>
    </form>
  </div>
</div>

</body>
</html>

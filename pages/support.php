<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สนับสนุนโครงการ | JUSTDONATE</title>
  <link rel="stylesheet" href="/css/support.css">
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
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
        </span>
        <a href="/pages/logout.php" class="btn-logout">🚪 ออกจากระบบ</a>
      <?php else: ?>
        <a href="/pages/login.php" class="btn-login">🔑 เข้าสู่ระบบ</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<div class="support-container">
  <div class="project-details">
    <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>
    <div class="project-image">
      <img src="/uploads/<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
    </div>
    <p class="project-description"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
    <p class="project-goal">🎯 เป้าหมาย: <?= number_format($project['goal_amount']) ?> บาท</p>
    <p class="project-raised">💰 ระดมทุนแล้ว: <?= number_format($project['raised_amount']) ?> บาท</p>
  </div>

  <div class="support-form">
    <form action="support.php?project_id=<?= $project['id'] ?>" method="POST">
      <label for="amount" class="amount-label">💸 จำนวนเงินที่คุณต้องการสนับสนุน (บาท)</label>
      <input type="number" name="amount" id="amount" min="1" required class="amount-input">
      <button type="submit" class="donate-button">✅ สนับสนุน</button>
    </form>
  </div>
</div>

</body>
</html>

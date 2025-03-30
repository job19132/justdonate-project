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
        <a href="/pages/create_project.php" class="btn-create-project">📝 เปิดโครงการใหม่</a>
        <a href="/pages/logout.php" class="btn-logout">🚪 ออกจากระบบ</a>
      <?php else: ?>
        <a href="/pages/login.php" class="btn-login">🔑 เข้าสู่ระบบ</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<?php
require '../config/db.php'; // เชื่อมต่อฐานข้อมูล

$username = trim($_POST['username']);
$password = $_POST['password'];

// เช็กว่าผู้ใช้ซ้ำไหม
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>
    alert('ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว');
    window.location.href = 'register.php';
    </script>";
    exit();
}

// เข้ารหัสรหัสผ่าน
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo "<script>
        alert('รหัสผ่านไม่ตรงกัน');
        window.location.href = 'register.php';
    </script>";
    exit();
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

// เพิ่มผู้ใช้ใหม่
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed);

if ($stmt->execute()) {
    echo "<script>
    alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
    window.location.href = 'login.php';
    </script>";
} else {
    echo "<script>
    alert('เกิดข้อผิดพลาด: ไม่สามารถสมัครได้');
    window.location.href = 'register.php';
    </script>";
}
?>

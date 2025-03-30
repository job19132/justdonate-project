<?php
session_start();
require '../config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่ามีผู้ใช้นี้หรือไม่
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ตรวจสอบรหัสผ่าน
    if (password_verify($password, $user['password'])) {
        // ✅ ล็อกอินสำเร็จ: บันทึกข้อมูลลง session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // เก็บ role เช่น admin หรือ user

        header("Location: ../index.php");
        exit();
    } else {
        // ❌ รหัสผ่านผิด
        echo "<script>
          alert('รหัสผ่านไม่ถูกต้อง');
          window.location.href = 'login.php';
        </script>";
        exit();
    }
} else {
    // ❌ ไม่พบบัญชีผู้ใช้
    echo "<script>
      alert('ไม่พบบัญชีผู้ใช้นี้ในระบบ');
      window.location.href = 'login.php';
    </script>";
    exit();
}
?>

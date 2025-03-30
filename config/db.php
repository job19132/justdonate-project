<?php
$host = '127.0.0.1';
$user = 'root';
$pass = ''; // ปล่อยว่าง ถ้า XAMPP ไม่มีรหัสผ่าน
$db   = 'justdonate';

$conn = new mysqli($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

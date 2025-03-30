<?php
session_start();
session_unset(); // ล้างตัวแปรทั้งหมดใน $_SESSION
session_destroy(); // ทำลาย session

header("Location: login.php"); // กลับไปหน้าเข้าสู่ระบบ
exit();

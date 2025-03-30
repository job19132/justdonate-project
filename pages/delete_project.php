<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $projectId = $_POST['project_id'];

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();

    header("Location: /index.php");
    exit();
} else {
    echo "ไม่ได้รับอนุญาตให้ลบ";
}

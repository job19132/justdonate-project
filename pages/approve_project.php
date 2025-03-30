<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $projectId = $_POST['project_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (in_array($action, ['approve', 'reject']) && is_numeric($projectId)) {
        $status = $action === 'approve' ? 'approved' : 'rejected';

        $stmt = $conn->prepare("UPDATE projects SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $projectId);
        $stmt->execute();

        header('Location: admin_projects.php');
        exit();
    } else {
        echo "พารามิเตอร์ไม่ถูกต้อง";
    }
} else {
    echo "คุณไม่มีสิทธิ์ทำรายการนี้";
}

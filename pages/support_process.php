<?php
session_start();
require '../config/db.php';

$project_id = $_POST['project_id'];
$amount = floatval($_POST['amount']);

if ($amount <= 0) {
    echo "จำนวนเงินไม่ถูกต้อง";
    exit();
}

// เช็กว่าโครงการมีอยู่จริง
$check = $conn->prepare("SELECT id FROM projects WHERE id = ?");
$check->bind_param("i", $project_id);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult->num_rows === 0) {
    echo "ไม่พบโครงการที่คุณต้องการสนับสนุน";
    exit();
}

// อัปเดตยอดเงินในตาราง projects
$stmt = $conn->prepare("UPDATE projects SET raised_amount = COALESCE(raised_amount, 0) + ? WHERE id = ?");
$stmt->bind_param("di", $amount, $project_id);
$stmt->execute();

header("Location: ../index.php");
exit();

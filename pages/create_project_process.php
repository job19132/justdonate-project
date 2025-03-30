<?php
require '../config/db.php';

$title = $_POST['title'];
$description = $_POST['description'];
$goal = $_POST['goal_amount'];
$image = '';

if (!empty($_FILES['image']['name'])) {
    $targetDir = '../uploads/';
    $image = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);
}

$sql = "INSERT INTO projects (title, description, goal_amount, image, status) VALUES (?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssds", $title, $description, $goal, $image);
$stmt->execute();

header('Location: project_list.php');
exit();
?>

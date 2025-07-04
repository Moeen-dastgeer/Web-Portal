<?php
session_start();
include 'db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'grand_super_admin') {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['error'] = "❌ Invalid campus ID.";
    header("Location: grand_super_admin_teachers.php");
    exit;
}

// disable the teacher 
$status = 0;

$conn->query("UPDATE teachers SET status = $status WHERE id = $id");




$_SESSION['success'] = "Teacher has been disabled!";
header("Location: grand_super_admin_teachers.php");
exit;
?>

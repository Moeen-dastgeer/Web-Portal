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
    header("Location: grand_super_admin_campuses.php");
    exit;
}

// First, disable the admin linked to this campus

$conn->query("update admins set status='0' WHERE campus_id = $id");



// Now disable the campus related teachers
$conn->query("UPDATE teachers SET status='0' WHERE campus_id = $id");


$_SESSION['success'] = "Campus its admin and its teachers has been disabled!";
header("Location: grand_super_admin_campuses.php");
exit;
?>

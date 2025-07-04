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

// First, delete the admin linked to this campus (but only if not super admin)
$conn->query("DELETE FROM admins WHERE campus_id = $id AND is_super = 0");

// then, select all students linked to this campus
$result = $conn->query("SELECT id FROM students WHERE campus_id = $id");

while ($row = $result->fetch_assoc()) {
    $student_id = $row['id'];
    // Delete attendance records for each student
    $conn->query("DELETE FROM attendance WHERE student_id = $student_id");
}

// then, select all teachers linked to this campus
$result1 = $conn->query("SELECT id FROM teachers WHERE campus_id = $id");

while ($row1 = $result1->fetch_assoc()) {
    $teacher_id = $row1['id'];
    // Delete leaves records for each teacher
    $conn->query("DELETE FROM leave_requests WHERE teacher_id = $teacher_id");
}

// Now delete the campus itself and related records
$conn->query("DELETE FROM teachers WHERE campus_id = $id");
$conn->query("DELETE FROM students WHERE campus_id = $id");
$conn->query("DELETE FROM campuses WHERE id = $id");

$_SESSION['success'] = "🗑️ Campus and its admin deleted!";
header("Location: grand_super_admin_campuses.php");
exit;
?>

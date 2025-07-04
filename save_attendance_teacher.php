<?php
session_start();
include 'db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'teacher') {
    exit("Unauthorized");
}

$student_id = intval($_POST['student_id']);
$teacher_id = $_SESSION['id'];
$teacher = $conn->query("SELECT * FROM teachers WHERE id = $teacher_id")->fetch_assoc();
$campus_id = $teacher['campus_id'];
$status = $_POST['status'];
$date = date('Y-m-d');

// Validate status input
$allowed_statuses = ['present', 'absent', 'late', 'leave'];
if (!in_array($status, $allowed_statuses)) {
    exit("❌ Invalid status.");
}

// Get student info
$student = $conn->query("SELECT course_id, shift_id, status FROM students WHERE id = $student_id")->fetch_assoc();
if (!$student) {
    exit("❌ Student not found.");
}

if ($student['status'] !== 'active') {
    exit("❌ Cannot mark attendance. Student is not active.");
}

// Validate teacher's assigned course-shift
$assigned = explode(',', $_SESSION['assigned_class']); // e.g. "1-2,2-1"
$current = $student['course_id'] . '-' . $student['shift_id'];

if (!in_array(trim($current), array_map('trim', $assigned))) {
    exit("❌ Unauthorized student (course-shift mismatch).");
}

// Insert or Update
$check = $conn->query("SELECT id FROM attendance WHERE student_id = $student_id AND date = '$date'");
if ($check->num_rows > 0) {
    $conn->query("UPDATE attendance SET status = '$status' WHERE student_id = $student_id AND date = '$date'");
    echo "✅ Updated to $status";
} else {
    $conn->query("INSERT INTO attendance (student_id, date, status,campus_id) VALUES ($student_id, '$date', '$status','$campus_id')");
    echo "✅ Marked $status";
}
?>

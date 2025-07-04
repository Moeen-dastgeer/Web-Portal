<?php
include 'db.php';

$student_id = intval($_POST['student_id']);
$new_campus_id = intval($_POST['new_campus_id']);

if ($student_id && $new_campus_id) {
    $conn->query("UPDATE students SET campus_id = $new_campus_id WHERE id = $student_id");
    echo "✅ Student migrated successfully!";
} else {
    echo "❌ Invalid data!";
}
?>

<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
include 'db.php';

$id = $_GET['id'];
$start = $_GET['start_date'] ?? '';
$end = $_GET['end_date'] ?? '';

$student = $conn->query("SELECT * FROM students WHERE id = $id")->fetch_assoc();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"Attendance Summary - {$student['name']}",0,1);

$pdf->SetFont('Arial','',12);
// $pdf->Cell(0,10,"Class: {$student['class']}");
$pdf->Cell(0,10,"Date Range: $start to $end",0,1);
$pdf->Ln();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,10,'Date',1);
$pdf->Cell(60,10,'Status',1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);

$summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'leave' => 0];

$query = "SELECT date, status FROM attendance WHERE student_id = $id AND date BETWEEN '$start' AND '$end' ORDER BY date";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40,10,$row['date'],1);
    $pdf->Cell(60,10,ucfirst($row['status']),1);
    $pdf->Ln();
    if (isset($summary[$row['status']])) {
        $summary[$row['status']]++;
    }
}

$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,"Summary",0,1);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Present: {$summary['present']}",0,1);
$pdf->Cell(0,10,"Absent: {$summary['absent']}",0,1);
$pdf->Cell(0,10,"Late: {$summary['late']}",0,1);
$pdf->Cell(0,10,"Late: {$summary['leave']}",0,1);

$pdf->Output();
?>

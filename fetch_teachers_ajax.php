<?php
include 'db.php';

$campus_id = $_POST['campus_id'] ?? '';
$search = $_POST['search_name'] ?? '';

$courseMap = [];
$shiftMap = [];
$courses = $conn->query("SELECT * FROM courses");
while ($c = $courses->fetch_assoc()) $courseMap[$c['id']] = $c['course_name'];

$shifts = $conn->query("SELECT * FROM shifts");
while ($s = $shifts->fetch_assoc()) $shiftMap[$s['id']] = $s['shift_name'];

$sql = "SELECT t.*, cam.name as campus_name 
        FROM teachers t 
        LEFT JOIN campuses cam ON t.campus_id = cam.id 
        WHERE 1=1";

if (!empty($campus_id)) {
  $sql .= " AND t.campus_id = " . intval($campus_id);
}
if (!empty($search)) {
  $search = $conn->real_escape_string($search);
  $sql .= " AND t.name LIKE '%$search%'";
}
$sql .= " ORDER BY t.name";

$result = $conn->query($sql);

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered table-hover'>";
echo "<thead class='table-dark'>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Phone</th>
          <th>Gender</th>
          <th>Campus</th>
          <th>Assigned Courses</th>";
           session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 'grand_super_admin') {
    echo "<th>Status</th>  <th>Action</th>";
} 
        echo "</tr>
      </thead><tbody>";

if ($result->num_rows > 0) {
  while ($t = $result->fetch_assoc()) {
    $combos = explode(',', $t['class_assigned']);
    $comboLabels = '';
    foreach ($combos as $combo) {
      [$cid, $sid] = explode('-', $combo);
      $cname = $courseMap[$cid] ?? 'Unknown';
      $sname = $shiftMap[$sid] ?? 'Unknown';
      $comboLabels .= "<span class='badge bg-primary me-1'>$cname - $sname</span>";
    }

  echo "<tr>
        <td>{$t['name']}</td>
        <td>{$t['username']}</td>
        <td>{$t['phone']}</td>
        <td>{$t['gender']}</td>
        <td>{$t['campus_name']}</td>
        <td>$comboLabels</td>";
    if($_SESSION['role'] == 'grand_super_admin') {
        echo "<td>" . ($t['status'] == 1 
            ? "<span class='badge bg-success'>Active</span>" 
            : "<span class='badge bg-danger'>Inactive</span>") . "</td>";
        echo "<td>";
        if ($t['status'] == 1) {
            echo "<a href='grand_super_admin_disable_teacher.php?id={$t['id']}' class='btn btn-sm btn-secondary' onclick='return confirm(\"Are you sure you want to disable this teacher?\")'>Disable</a>";
        } else {
            echo "<a href='grand_super_admin_enable_teacher.php?id={$t['id']}' class='btn btn-sm btn-success' onclick='return confirm(\"Are you sure you want to enable this teacher?\")'>Enable</a>";
        }
            echo "</td>";
    }

    echo "</tr>";

  }
} else {
  echo "<tr><td colspan='6' class='text-center'>No teachers found.</td></tr>";
}
echo "</tbody></table></div>";
?>

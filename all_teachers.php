<?php
include 'admin_header.php';
include 'db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit;
}

$campus_id = $_SESSION['campus_id'] ?? null;

// Course & Shift lookup for mapping IDs
$courseMap = [];
$shiftMap = [];

$courses = $conn->query("SELECT * FROM courses");
while ($c = $courses->fetch_assoc()) {
    $courseMap[$c['id']] = $c['course_name'];
}

$shifts = $conn->query("SELECT * FROM shifts");
while ($s = $shifts->fetch_assoc()) {
    $shiftMap[$s['id']] = $s['shift_name'];
}

// ✅ Main Query with campus filter
$teachers_sql = "SELECT * FROM teachers WHERE 1=1";
if ($campus_id) {
    $teachers_sql .= " AND campus_id = $campus_id";
}
$teachers_sql .= " ORDER BY name";

$teachers = $conn->query($teachers_sql);
?>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="card-title mb-4 fw-bold">👨‍🏫 All Registered Teachers</h3>

      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="teacherTable">
          <thead class="table-dark">
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Assigned Course+Shift</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while($t = $teachers->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($t['name']); ?></td>
              <td><?= htmlspecialchars($t['username']); ?></td>
              <td>
                <?php
                $comboList = explode(',', $t['class_assigned']);
                foreach ($comboList as $combo) {
                    $combo = trim($combo);
                    if (strpos($combo, '-') !== false) {
                        list($cid, $sid) = explode('-', $combo);
                        $courseName = $courseMap[$cid] ?? 'Unknown';
                        $shiftName = $shiftMap[$sid] ?? 'Unknown';
                        echo "<span class='badge bg-primary me-1'>{$courseName} - {$shiftName}</span>";
                    } else {
                        echo "<span class='badge bg-secondary me-1'>{$combo}</span>"; // fallback
                    }
                }
                ?>
              </td>
              <td>
                <a href="teacher_profile.php?id=<?= $t['id']; ?>" class="btn btn-sm btn-info">👁️ View</a>
                <a href="edit_teacher.php?id=<?= $t['id']; ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <a href="delete_teacher.php?id=<?= $t['id']; ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger">🗑️ Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function () {
    $('#teacherTable').DataTable({
      responsive: true,
      paging: true,
      ordering: true,
      info: true
    });
  });
</script>

<?php include 'admin_footer.php'; ?>

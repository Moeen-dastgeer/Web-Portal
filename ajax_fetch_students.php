<?php
session_start();
include 'db.php';

$campus_id = $_SESSION['campus_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$search = $_POST['search'] ?? '';
$course_id = $_POST['course_id'] ?? '';
$shift_id = $_POST['shift_id'] ?? '';
$campus_filter = $_POST['campus_id'] ?? '';
$status = $_POST['status'] ?? '';

$query = "SELECT s.*, c.course_name, sh.shift_name 
          FROM students s
          LEFT JOIN courses c ON s.course_id = c.id
          LEFT JOIN shifts sh ON s.shift_id = sh.id
          WHERE 1=1";

if ($role == 'admin' && $campus_id) {
  $query .= " AND s.campus_id = $campus_id";
} elseif ($campus_filter) {
  $query .= " AND s.campus_id = $campus_filter";
}

if ($course_id) {
  $query .= " AND s.course_id = $course_id";
}
if ($shift_id) {
  $query .= " AND s.shift_id = $shift_id";
}
if ($status != '') {
  $query .= " AND s.status = '$status'";
}


if ($search) {
  $search = $conn->real_escape_string($search);
  $query .= " AND s.name LIKE '%$search%'";
}

$query .= " ORDER BY s.name ASC";
$res = $conn->query($query);
?>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Course</th>
      <th>Shift</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res->fetch_assoc()): ?>
    <tr>
      <td>
        <?php if ($row['image']): ?>
          <img src="uploads/<?= $row['image'] ?>" width="50" class="img-thumbnail">
        <?php else: ?>
          -
        <?php endif; ?>
      </td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['course_name'] ?></td>
      <td><?= $row['shift_name'] ?></td>
      <td>
        <select class="form-select form-select-sm" onchange="updateStatus(<?= $row['id'] ?>, this.value)">
          <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>Active</option>
          <option value="passout" <?= $row['status'] == 'passout' ? 'selected' : '' ?>>Passout</option>
          <option value="blocked" <?= $row['status'] == 'blocked' ? 'selected' : '' ?>>Blocked</option>
        </select>
      </td>
     <td>
  <a href="student_profile.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">👤 View</a>
  <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mx-1">✏️ Edit</a>
  <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this student?')">🗑️ Delete</a>
  
  <!-- Migrate Button -->
  <button type="button" class="btn btn-sm btn-secondary mt-1" onclick="openMigrateModal(<?= $row['id'] ?>)">🔄 Migrate</button>
</td>

    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Migrate Modal -->
<div class="modal fade" id="migrateModal" tabindex="-1" aria-labelledby="migrateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="migrateForm">
        <div class="modal-header">
          <h5 class="modal-title" id="migrateModalLabel">🔄 Migrate Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="student_id" id="migrate_student_id">
          <div class="mb-3">
            <label class="form-label">Select New Campus</label>
            <select name="new_campus_id" id="new_campus_id" class="form-select" required>
              <option value="">-- Select Campus --</option>
              <?php
              $campuses2 = $conn->query("SELECT id, name FROM campuses ORDER BY name");
              while ($camp2 = $campuses2->fetch_assoc()) {
                echo "<option value='{$camp2['id']}'>{$camp2['name']}</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button"  class="btn btn-primary migrate">Migrate</button>
        </div>
      </form>
    </div>
  </div>
</div>


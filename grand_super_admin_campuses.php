<?php include 'grand_super_admin_header.php'; ?>
<?php include 'db.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>🏫 Manage Campuses</h3>
    <a href="grand_super_admin_add_campus.php" class="btn btn-primary">➕ Add Campus</a>
</div>
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Campus Name</th>
          <th>Admin Username</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("
          SELECT c.id, c.name,a.status,a.username AS admin_username 
          FROM campuses c
          LEFT JOIN admins a ON c.id = a.campus_id
        ");
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['admin_username'] ?? 'N/A'); ?></td>
            <td>
                <?php
                if($row['status'] == 1) {
                    echo '<span class="badge bg-success">Active</span>';
                } else {
                    echo '<span class="badge bg-secondary">Disabled</span>';
                }
                ?>
            </td>
            <td>
              <a href="grand_super_admin_edit_campus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
              <a href="grand_super_admin_delete_campus.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">🗑️ Delete</a>
              <?php if ($row['status'] == 1): ?>
                <a href="grand_super_admin_disable_campus.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to disable this campus and its admin?')" class="btn btn-sm btn-secondary">🔒Disable</a>
                <?php else: ?>
                <a href="grand_super_admin_enable_campus.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to enable this campus and its admin?')" class="btn btn-sm btn-success">🔐Enable</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'grand_super_admin_footer.php'; ?>

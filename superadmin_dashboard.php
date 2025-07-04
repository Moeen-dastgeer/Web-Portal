<?php
include 'superadmin_header.php';
include 'db.php';

// Counts
$total_campuses = $conn->query("SELECT COUNT(*) as total FROM campuses")->fetch_assoc()['total'];
$total_students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
$total_teachers = $conn->query("SELECT COUNT(*) as total FROM teachers")->fetch_assoc()['total'];
$total_shifts   = $conn->query("SELECT COUNT(*) as total FROM shifts")->fetch_assoc()['total'];
$total_courses  = $conn->query("SELECT COUNT(*) as total FROM courses")->fetch_assoc()['total'];
?>
<?php include 'superadmin_sidebar.php';?>
<div class="container-fluid py-4">
  <div class="row">
    <!-- Campuses -->
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="small-box bg-primary text-white">
        <div class="inner">
          <h3><?= $total_campuses ?></h3>
          <p>Total Campuses</p>
        </div>
        <div class="icon"><i class="nav-icon fas fa-school"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div> 

    <!-- Students -->
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="small-box bg-success text-white">
        <div class="inner">
          <h3><?= $total_students ?></h3>
          <p>Total Students</p>
        </div>
        <div class="icon"><i class="nav-icon fas fa-user-graduate"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Teachers -->
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="small-box bg-warning text-dark">
        <div class="inner">
          <h3><?= $total_teachers ?></h3>
          <p>Total Teachers</p>
        </div>
        <div class="icon"><i class="nav-icon fas fa-users"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Cources -->
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="small-box bg-danger text-white">
        <div class="inner">
          <h3><?= $total_courses ?></h3>
          <p>Total Cources</p>
        </div>
        <div class="icon"><i class="nav-icon fas fa-laptop"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Shifts -->
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="small-box bg-secondary text-white">
        <div class="inner">
          <h3><?= $total_shifts ?></h3>
          <p>Total Shifts</p>
        </div>
        <div class="icon"><i class="nav-icon fas fa-clock"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
</div>

<?php include 'superadmin_footer.php'; ?>

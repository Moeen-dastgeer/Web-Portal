<?php
session_set_cookie_params(86400 * 7);
session_start();
include 'db.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'super_admin') {
        header("Location: superadmin_dashboard.php");
        exit;
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
        exit;
    }
    elseif ($_SESSION['role'] === 'grand_super_admin') {
        header("Location: grand_super_admin_dashboard.php");
        exit;
    }
     elseif ($_SESSION['role'] === 'teacher') {
        header("Location: teacher_dashboard.php");
        exit;
    }
}
$error = "";
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check Admins (both super & regular)
    $admin = $conn->query("SELECT * FROM admins WHERE username = '$username'");
    if ($admin->num_rows == 1) {
        $a = $admin->fetch_assoc();
        if (password_verify($password, $a['password'])) {
            $_SESSION['loggedin'] = true;

            if ($a['is_super'] == 1) {
              if($a['status']==1) 
              {
                // Super admin
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'super_admin';
                $_SESSION['super_name'] = $a['name'];
                $_SESSION['id'] = $a['id'];
                header("Location: superadmin_dashboard.php");
              }
              else
              {
                $error = "❌ Your account is deactivated. Please contact the administrator.";
                header("Location: index.php?error=" . urlencode($error));
                exit;
              }       
            }
            else if ($a['is_super'] == 2) {
              // Grand super admin
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'grand_super_admin';
                $_SESSION['super_name'] = $a['name'];
                $_SESSION['id'] = $a['id'];
                header("Location: grand_super_admin_dashboard.php");
            
            } 
            else {
              if($a['status'] == 1) {
                // Regular admin
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'admin';
                $_SESSION['admin_name'] = $a['name'];
                $_SESSION['id'] = $a['id'];
                $_SESSION['campus_id'] = $a['campus_id'];
                header("Location: dashboard.php");
              } else {
                $error = "❌ Your account is deactivated. Please contact the administrator.";
                header("Location: index.php?error=" . urlencode($error));
                exit;
              }
            }
            exit;
        }
    }

    // Check Teachers
    $teacher = $conn->query("SELECT * FROM teachers WHERE username = '$username'");
    if ($teacher->num_rows == 1) {
        $t = $teacher->fetch_assoc();
        if (password_verify($password, $t['password'])) {
            if ($t['status'] == 0) {
                $error = "❌ Your account is deactivated. Please contact the administrator.";
                header("Location: index.php?error=" . urlencode($error));
                exit;
            }
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'teacher';
            $_SESSION['teacher_name'] = $t['name'];
            $_SESSION['id'] = $t['id'];
            $_SESSION['assigned_class'] = $t['class_assigned']; // e.g. "1-2,2-1"
            header("Location: teacher_dashboard.php");
            exit;
        }
    }

    $error = "❌ Invalid username or password";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Supder Admin/Admin/Teacher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body
    {
      background-image: url(ficer.jpeg);
      background-size: 180px 110px;
      background-position: 50% 50%;
      position: relative;
      width: 100%;
      height: 100vh;
    }
    body::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); 
}
.container
{
    z-index: 1;
    position:relative;
}
  </style>
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="card shadow p-4 w-100" style="max-width: 400px;">
    <div class="card-body">
      <div class="text-center mb-4">
        <img src="ficer.jpeg" alt="Logo" class="img-round mb-3" style="width: 35%;">
        <h5 class="">Fatima Institute Of Computer Education and Resources</h5>
      </div>  
      <h3 class="mb-3 text-center">🔐 Login</h3>
  
     <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
     <?php endif; ?>
  
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>

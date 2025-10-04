<?php
session_start();
include '../db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['login_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Get user with role 'admin'
    $query = $conn->query("SELECT * FROM users WHERE username = '$username' AND role = 'admin'");

    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['login_id'] = $user['id'];
            $_SESSION['login_name'] = $user['name'];
            $_SESSION['login_view_folder'] = 'admin/'; // for dynamic includes
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | LogTrack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #14532d, #166534);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .login-box {
      background-color: white;
      padding: 2rem;
      border-radius: 1rem;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      color: black;
    }

    .login-box h3 {
      color: #14532d;
      font-weight: bold;
    }

    .btn-login {
      background-color: #14532d;
      color: white;
    }

    .btn-login:hover {
      background-color: #0e3b1f;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h3 class="text-center mb-4">Admin Login</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username" class="form-control" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-login">Login</button>
      </div>
    </form>
  </div>

</body>
</html>

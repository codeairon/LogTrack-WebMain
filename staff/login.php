<?php
session_start();
require_once('../db_connect.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, fullname, email, password, employment_type FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                // Login successful – set session variables
                $_SESSION['staff_id'] = $user['id'];
                $_SESSION['staff_name'] = $user['fullname'];
                $_SESSION['staff_email'] = $user['email'];
                $_SESSION['staff_type'] = $user['employment_type'];

                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Incorrect password. Please try again.";
            }
        } else {
            $errors[] = "No account found with that email.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Login | LogTrack</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f8;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: #fff;
      padding: 35px 30px;
      border-radius: 14px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 420px;
    }
    .login-card img {
      display: block;
      margin: 0 auto 15px auto;
      height: 70px;
    }
    .login-card h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #14532d;
      font-weight: bold;
    }
    .btn-login {
      background-color: #14532d;
      color: #fff;
      font-weight: 500;
      padding: 12px;
      border-radius: 8px;
      transition: background 0.3s ease;
    }
    .btn-login:hover {
      background-color: #0e3b20;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
      font-weight: 500;
    }
    .links {
      text-align: center;
      margin-top: 15px;
    }
    .links a {
      color: #14532d;
      text-decoration: none;
      font-weight: 500;
    }
    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-card">
  <!-- DENR Logo -->
  <img src="../assets/img/denr-logo.png" alt="DENR Logo">

  <h3>Staff Login</h3>

  <?php if (!empty($errors)): ?>
    <div class="error"><?= implode('<br>', $errors) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-login w-100" type="submit">Login</button>
  </form>

  <div class="links">
    <p><a href="staff_forgot_password.php">Forgot Password?</a></p>
  </div>
  <div class="links">
    <p>don't have an account yet? <a href="register.php">Register here</a></p>
</div>

</body>
</html>

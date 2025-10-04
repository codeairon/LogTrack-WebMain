<?php
session_start();
require_once("../db_connect.php");

$message = "";
$successMessage = "";

// Show success alert after password reset
if (isset($_GET['reset']) && $_GET['reset'] === 'success') {
    $successMessage = "✅ Your password has been reset successfully. Please login with your new password.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM pnp_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'Approved') {
                $_SESSION['pnp_id'] = $user['id'];
                $_SESSION['pnp_name'] = $user['first_name'] . " " . $user['last_name'];
                $_SESSION['pnp_role'] = $user['role'];

                header("Location: pnp_dashboard.php");
                exit;
            } else {
                $message = "⏳ Your account is still <strong>{$user['status']}</strong>. Please wait for LogTrack admin review.";
            }
        } else {
            $message = "❌ Invalid email or password.";
        }
    } else {
        $message = "❌ No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PNP Login | LogTrack</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f0f4f3;
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
    /* Fade-out animation for success alerts */
    .fade-out {
      transition: opacity 1s ease-out;
      opacity: 1;
    }
    .fade-out.hide {
      opacity: 0;
    }
  </style>
</head>
<body>

<div class="login-card">
  <!-- DENR Logo -->
  <img src="../assets/img/denr-logo.png" alt="DENR Logo">

  <h3>PNP Officer Login</h3>

  <?php if ($successMessage): ?>
    <div id="successAlert" class="alert alert-success text-center fade-out">
      <?php echo $successMessage; ?>
    </div>
  <?php endif; ?>

  <?php if ($message): ?>
    <div class="alert alert-warning text-center"><?php echo $message; ?></div>
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
    <button type="submit" class="btn btn-login w-100">Login</button>
  </form>

  <div class="links">
    <p>Don’t have an account? <a href="pnp_register.php">Register here</a></p>
    <p><a href="pnp_forgot_password.php">Forgot Password?</a></p>
  </div>
</div>

<script>
  // Auto fade out success alert after 4 seconds
  window.addEventListener("DOMContentLoaded", function() {
    const alertBox = document.getElementById("successAlert");
    if (alertBox) {
      setTimeout(() => {
        alertBox.classList.add("hide");
        setTimeout(() => alertBox.remove(), 1000); 
      }, 4000);
    }
  });
</script>

</body>
</html>

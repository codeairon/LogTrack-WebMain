<?php
session_start();
require_once("../db_connect.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists in pnp_users
    $stmt = $conn->prepare("SELECT id FROM pnp_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in a new table
        $conn->query("CREATE TABLE IF NOT EXISTS pnp_password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            otp_code VARCHAR(6) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Save OTP
        $stmt = $conn->prepare("INSERT INTO pnp_password_resets (user_id, otp_code) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $otp);
        $stmt->execute();

        // TODO: Send OTP via email → For now, we just display it
        $_SESSION['reset_email'] = $email;
        $message = "✅ An OTP has been generated for your account. <br><strong>OTP: $otp</strong><br>Enter this to reset your password.";
    } else {
        $message = "❌ No PNP account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PNP Forgot Password | LogTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #14532d, #166534);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .forgot-card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .forgot-card h3 {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
      color: #14532d;
    }
    .btn-submit {
      background: #14532d;
      color: #fff;
    }
    .btn-submit:hover {
      background: #0e3b20;
    }
    .links {
      margin-top: 15px;
      text-align: center;
    }
    .links a {
      text-decoration: none;
      font-weight: 500;
      color: #14532d;
    }
  </style>
</head>
<body>

<div class="forgot-card">
  <h3>Forgot Password</h3>
  <?php if ($message): ?>
    <div class="alert alert-info text-center"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-submit w-100">Request OTP</button>
  </form>

  <div class="links">
    <p><a href="login.php">🔙 Back to Login</a></p>
  </div>
</div>

</body>
</html>

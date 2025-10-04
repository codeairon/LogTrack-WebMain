<?php
session_start();
require_once("../db_connect.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "❌ Passwords do not match.";
    } elseif (!isset($_SESSION['reset_email'])) {
        $message = "❌ Session expired. Please request OTP again.";
    } else {
        $email = $_SESSION['reset_email'];

        // Find the user
        $stmt = $conn->prepare("SELECT id FROM pnp_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['id'];

            // Validate OTP
            $stmt = $conn->prepare("SELECT id, created_at FROM pnp_password_resets 
                                    WHERE user_id = ? AND otp_code = ? 
                                    ORDER BY created_at DESC LIMIT 1");
            $stmt->bind_param("is", $user_id, $otp);
            $stmt->execute();
            $otp_result = $stmt->get_result();

            if ($otp_result && $otp_result->num_rows > 0) {
                // ✅ OTP is correct → update password
                $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE pnp_users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_pass, $user_id);

                if ($stmt->execute()) {
                    // Remove used OTP
                    $conn->query("DELETE FROM pnp_password_resets WHERE user_id = $user_id");

                    unset($_SESSION['reset_email']);
                    header("Location: login.php?reset=success");
                    exit;
                } else {
                    $message = "❌ Failed to update password. Try again.";
                }
            } else {
                $message = "❌ Invalid or expired OTP.";
            }
        } else {
            $message = "❌ Account not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password | PNP</title>
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
    .reset-card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .reset-card h3 {
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

<div class="reset-card">
  <h3>Reset Password</h3>
  <?php if ($message): ?>
    <div class="alert alert-info text-center"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Enter OTP</label>
      <input type="text" name="otp" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>New Password</label>
      <input type="password" name="new_password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-submit w-100">Reset Password</button>
  </form>

  <div class="links">
    <p><a href="login.php">🔙 Back to Login</a></p>
  </div>
</div>

</body>
</html>

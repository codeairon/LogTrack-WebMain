<?php
session_start();
require_once('../db_connect.php');
require_once('../vendor/autoload.php'); // Composer autoload for PHPMailer
require_once('send_sms.php'); // Your SMS function using Semaphore

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $position = trim($_POST['position']);
    $employment_type = $_POST['employment_type'];

    // Basic validation
    if ($password !== $confirm_password) {
        $errors[] = "❌ Passwords do not match.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "❌ Invalid email format.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $otp = rand(100000, 999999);

        // Save OTP to database
        try {
            $stmt = $conn->prepare("INSERT INTO staff_otp_verification (email, otp_code) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $otp);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }

        // Store user data in session for verification later
        $_SESSION['pending_registration'] = [
            'fullname' => $fullname,
            'email' => $email,
            'password' => $hashedPassword,
            'contact' => $contact,
            'position' => $position,
            'employment_type' => $employment_type
        ];

        // Prepare PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aironcammagay@gmail.com'; // replace
            $mail->Password   = 'phdp kkgn nbhg ljjv';     // replace
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('aironcammagay@gmail.com', 'LogTrack System');
            $mail->addAddress($email, $fullname);

            $mail->isHTML(true);
            $mail->Subject = 'Your LogTrack OTP Code';
            $mail->Body    = "
                <h3>Hello $fullname,</h3>
                <p>Your OTP code for staff registration is:</p>
                <h2 style='color:green;'>$otp</h2>
                <p>Please enter this code to complete your registration.</p>
                <p>– LogTrack System</p>
            ";

            $mail->send();
            header("Location: verify_otp.php");
            exit;
        } catch (Exception $e) {
            // If email fails, try sending SMS
            $smsMessage = "Hi $fullname! Your LogTrack OTP is: $otp";
            $smsSent = sendSMS($contact, $smsMessage);

            if ($smsSent) {
                header("Location: verify_otp.php");
                exit;
            } else {
                $errors[] = "❌ Failed to send OTP via Email and SMS. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Registration | LogTrack</title>
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f8;
      font-family: "Segoe UI", sans-serif;
    }
    .register-form {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    .register-form img {
      display: block;
      margin: 0 auto 15px;
      width: 80px;
    }
    .register-form h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2e7d32;
      font-weight: bold;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      font-weight: 600;
      margin-bottom: 6px;
      display: block;
    }
    input, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }
    input:focus, select:focus {
      border-color: #2e7d32;
      box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
      outline: none;
    }
    button {
      background: #2e7d32;
      color: white;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
    }
    button:hover {
      background: #1b5e20;
    }
    .message {
      margin: 15px 0;
      text-align: center;
      font-weight: bold;
    }
    .links {
      text-align: center;
      margin-top: 15px;
    }
    .links a {
      color: #2e7d32;
      font-weight: 600;
      text-decoration: none;
    }
    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="register-form">
  <!-- Logo -->
  <img src="../assets/img/denr-logo.png" alt="DENR Logo">
  <h2>Staff Registration</h2>

  <?php if (!empty($errors)): ?>
    <p class="message text-danger"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></p>
  <?php elseif (!empty($success)): ?>
    <p class="message text-success"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="fullname" required>
    </div>
    <div class="form-group">
      <label>Email (Username)</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>Contact Number</label>
      <input type="text" name="contact_number" placeholder="0917XXXXXXX" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" required>
    </div>
    <div class="form-group">
      <label>Position</label>
      <input type="text" name="position" placeholder="e.g., Forest Technician" required>
    </div>
    <div class="form-group">
      <label>Employment Type</label>
      <select name="employment_type" required>
        <option value="">-- Select Employment Type --</option>
        <option value="Regular">Regular</option>
        <option value="Contractual">Contractual</option>
      </select>
    </div>

    <button type="submit">Register Staff</button>
  </form>

  <div class="links">
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

</body>
</html>

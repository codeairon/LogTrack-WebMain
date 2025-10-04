<?php
session_start();
require_once('../db_connect.php');

$errors = [];
$success = "";

// Check if registration session exists
if (!isset($_SESSION['pending_registration'])) {
    header("Location: register.php");
    exit;
}

$userData = $_SESSION['pending_registration'];
$email = $userData['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputOtp = trim($_POST['otp']);

    // Get the latest OTP from the database
    $stmt = $conn->prepare("SELECT otp_code FROM staff_otp_verification WHERE email = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedOtp);
    $stmt->fetch();
    $stmt->close();

    // Compare entered OTP with latest stored OTP
    if ($storedOtp && $inputOtp === $storedOtp) {
        // Insert new staff
        $stmt = $conn->prepare("INSERT INTO staff (fullname, email, contact_number, password, position, employment_type, date_registered) 
                                VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param(
            "ssssss",
            $userData['fullname'],
            $userData['email'],
            $userData['contact'],
            $userData['password'],
            $userData['position'],
            $userData['employment_type']
        );

        if ($stmt->execute()) {
            // Remove OTP
            $delStmt = $conn->prepare("DELETE FROM staff_otp_verification WHERE email = ?");
            $delStmt->bind_param("s", $email);
            $delStmt->execute();
            $delStmt->close();

            // Clear session
            unset($_SESSION['pending_registration']);

            $success = "🎉 Registration complete! You can now <a href='login.php'>log in</a>.";
        } else {
            $errors[] = "⚠️ Failed to complete registration. Please try again.";
        }

        $stmt->close();
    } else {
        $errors[] = "❌ Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP – LogTrack</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f8f8f8;
        }

        form {
            background: white;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }

        .btn {
            background: #388e3c;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Verify OTP</h2>

    <form method="POST">
        <?php if (!empty($errors)): ?>
            <div class="error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <input type="text" name="otp" placeholder="Enter the 6-digit OTP" required>

        <button class="btn" type="submit">Verify</button>
    </form>

</body>
</html>

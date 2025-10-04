<?php
require_once("../db_connect.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Handle file upload (ID card or captured photo)
    $id_document = null;
    if (isset($_FILES['id_document']) && $_FILES['id_document']['error'] === 0) {
        $targetDir = "uploads/id_cards/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES['id_document']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['id_document']['tmp_name'], $targetFile)) {
            $id_document = $fileName;
        }
    }

    // Insert into pnp_users table
    $stmt = $conn->prepare("INSERT INTO pnp_users 
        (first_name, last_name, email, contact, address, password, status, id_document) 
        VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?)");
    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $contact, $address, $password, $id_document);

    if ($stmt->execute()) {
        $message = "✅ Registration successful! Please wait for LogTrack Admin approval.";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PNP Registration | LogTrack</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

    <link rel="stylesheet" href="../admin/style.css">
    <style>
        body { 
            background: #f4f6f8; 
            font-family: "Segoe UI", sans-serif; 
        }
        .register-form {
            max-width: 500px; 
            margin: 40px auto; 
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
        .form-group { margin-bottom: 15px; }
        label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
        }
        input, select {
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc;
            border-radius: 8px; 
            font-size: 15px;
        }
        input:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
            outline: none;
        }
        .upload-box {
            border: 2px dashed #ccc; 
            padding: 15px; 
            text-align: center; 
            border-radius: 10px;
        }
        .upload-box input { border: none; }
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
        button:hover { background: #1b5e20; }
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
        <h2>PNP Officer Registration</h2>

        <?php if ($message) echo "<p class='message'>$message</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="form-group">
                <label>Email (Username)</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group upload-box">
                <label>Upload ID (for verification)</label>
                <input type="file" name="id_document" accept="image/*" capture="environment" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="links">
            <p>Already have an account? <a href="pnp_login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>


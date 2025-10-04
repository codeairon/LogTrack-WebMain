<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $error = "❌ Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->bind_param("sss", $name, $username, $password);
        $stmt->execute();
        $success = "✅ Admin registered successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Admin | LogTrack</title>

  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --brand: #2e7d32;
      --brand-dark: #1b5e20;
      --bg: #f4f6f8;
      --card: #ffffff;
      --text: #222;
      --muted: #6b7280;
      --shadow: 0 2px 8px rgba(0,0,0,0.08);
      --radius: 14px;
    }
    body {
      font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      margin: 0;
    }
    .navbar {
      background: var(--card);
      box-shadow: var(--shadow);
      padding: 0.75rem 1.25rem;
    }
    .navbar-brand {
      font-weight: 700;
      color: var(--brand) !important;
      display: flex; align-items: center; gap: 8px;
    }
    .navbar-brand img {
      width: 38px; height: 38px; object-fit: contain;
    }
    .card {
      border: none;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background: var(--card);
      padding: 24px;
    }
    .card-title {
      color: var(--brand-dark);
      font-weight: 700;
      text-align: center;
    }
    .form-control:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
    }
    .btn-theme {
      background: var(--brand);
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      transition: all 0.25s ease;
      padding: 10px 14px;
    }
    .btn-theme:hover {
      background: var(--brand-dark);
      color: #fff;
    }
    .alert {
      font-size: 14px;
      padding: 10px;
      border-radius: 8px;
    }
    .btn-secondary {
      border-radius: 8px;
      font-weight: 600;
    }
  </style>
</head>
<body>

<!-- Header/Navbar -->
<nav class="navbar">
  <a class="navbar-brand" href="dashboard.php">
    <img src="../assets/img/denr-logo.png" alt="DENR Logo">
    LogTrack | Admin Panel
  </a>
</nav>

<!-- Register Form -->
<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
  <div class="card" style="max-width: 500px; width: 100%;">
    <h4 class="card-title mb-4">➕ Register New Admin</h4>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success text-center"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-theme w-100">Register Admin</button>
        <a href="dashboard.php" class="btn btn-secondary w-100">⬅ Back to Dashboard</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>

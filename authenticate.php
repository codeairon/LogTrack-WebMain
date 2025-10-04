<?php
session_start();
require_once 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password, role FROM logtrack_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect based on role
        switch ($role) {
            case 'admin': header("Location: admin/dashboard.php"); break;
            case 'pnp': header("Location: pnp/dashboard.php"); break;
            case 'staff': header("Location: staff/dashboard.php"); break;
            case 'user': header("Location: user/dashboard.php"); break;
        }
        exit;
    }
}

echo "❌ Invalid credentials.";
?>

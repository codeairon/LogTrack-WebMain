<?php
require_once("../db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $status = 'Approved';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } else {
        die("Invalid action.");
    }

    // Update the status in the new pnp_users table
    $stmt = $conn->prepare("UPDATE pnp_users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $user_id);

    if ($stmt->execute()) {
        header("Location: pnp_accounts.php?success=1");
        exit;
    } else {
        echo "❌ Error updating user: " . $conn->error;
    }
}
?>

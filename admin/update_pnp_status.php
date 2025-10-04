<?php
require_once("../db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE pnp_users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: pnp_accounts.php?msg=success");
    } else {
        header("Location: pnp_accounts.php?msg=error");
    }
    exit;
}
?>

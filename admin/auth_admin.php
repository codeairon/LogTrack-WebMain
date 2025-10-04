<?php
// admin/auth_admin.php
session_start();

// Ensure user is logged in and role is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized access.";
    exit;
}

<?php
// admin/verify_contribution.php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = intval($_POST['staff_id']);

    // Example: mark all contributions of this staff as verified
    $sql = $conn->query("
        UPDATE staff_contributions
        SET status = 'Verified'
        WHERE staff_id = $staff_id
    ");

    if ($sql) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>

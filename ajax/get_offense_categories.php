<?php
require_once('../db_connect.php');

$stmt = $conn->prepare("SELECT id, name FROM offense_categories ORDER BY name ASC");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

header('Content-Type: application/json');
echo json_encode($categories);
exit;

<?php
session_start();
require_once('../db_connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['login_id'])) {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

$district_id = intval($_GET['district_id'] ?? 0);
if (!$district_id) {
    echo json_encode([]);
    exit;
}

$result = $conn->query("SELECT id, name FROM municipalities WHERE district_id = $district_id ORDER BY name");

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

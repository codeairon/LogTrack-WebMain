<?php
session_start();
require_once('../db_connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['login_id'])) {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

$municipality_id = intval($_GET['municipality_id'] ?? 0);
if (!$municipality_id) {
    echo json_encode([]);
    exit;
}

$result = $conn->query("SELECT id, name FROM barangays WHERE municipality_id = $municipality_id ORDER BY name");

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

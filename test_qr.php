<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/qr_helper.php';

$conn = new mysqli("localhost", "root", "", "logtrack_db");
if ($conn->connect_error) die("Connection failed");

$id = 12345;  // Fake ID
$result = makeLogQr($conn, $id);
echo "QR generated: $result";

<?php
require_once '../db_connect.php';
$id = intval($_GET['id'] ?? 0);
$log = $conn->query("SELECT qrFileName FROM apprehended_logs WHERE id=$id")->fetch_assoc();
if(!$log){ http_response_code(404); exit('QR not found'); }
$path = __DIR__.'/assets/qrcodes/'.$log['qrFileName'];
header('Content-Type: image/png');
header('Content-Disposition: inline; filename="'.$log['qrFileName'].'"');
readfile($path);

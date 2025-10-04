<?php
session_start();
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Custom error log file
$logFile = __DIR__ . "/error_log.txt";

function logError($msg) {
    global $logFile;
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] " . $msg . PHP_EOL, FILE_APPEND);
}

if (!isset($_SESSION['staff_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access. Please log in."
    ]);
    exit;
}

require_once('../db_connect.php');

// Debug: check what came from POST
file_put_contents("debug_post.txt", print_r($_POST, true));


$staff_id = $_SESSION['staff_id'];
$month    = $_POST['month'] ?? null;
$species  = $_POST['species'] ?? [];
$quantity = $_POST['quantity'] ?? [];
$year     = date("Y");

// ✅ Validate inputs
if (!$month || empty($species) || empty($quantity)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input. Please complete the form."
    ]);
    exit;
}

// ✅ Calculate total
$total = 0;
foreach ($quantity as $q) {
    $total += (int)$q;
}
if ($total < 300) {
    echo json_encode([
        "success" => false,
        "message" => "❌ Failed to meet the required contribution (300 seedlings)."
    ]);
    exit;
}

// Build report_date from year + month
$report_date = sprintf("%04d-%02d-01", $year, $month);

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("
        INSERT INTO staff_contributions (staff_id, report_date, species, quantity, total)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        logError("Prepare failed: " . $conn->error);
        throw new Exception("Prepare failed: " . $conn->error);
    }

    for ($i = 0; $i < count($species); $i++) {
        $sp = trim($species[$i]);
        $qt = (int)$quantity[$i];
        if ($sp === "" || $qt <= 0) continue;

        if (!$stmt->bind_param("issii", $staff_id, $report_date, $sp, $qt, $total)) {
            logError("Bind failed: " . $stmt->error);
            throw new Exception("Bind failed: " . $stmt->error);
        }

        if (!$stmt->execute()) {
            logError("Execute failed: " . $stmt->error);
            throw new Exception("Execute failed: " . $stmt->error);
        }
    }

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "✅ Contribution submitted successfully! Wait for admin verification."
    ]);
}  catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage() . 
                     " | SQLSTATE: " . $conn->sqlstate . 
                     " | Error: " . $conn->error
    ]);
}



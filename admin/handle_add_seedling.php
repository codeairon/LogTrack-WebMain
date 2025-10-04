<?php
session_start();
require_once('../db_connect.php');

$created_by = $_SESSION['login_id'] ?? null;
$category   = $_POST['category'] ?? '';
$month      = intval($_POST['report_month'] ?? date('n'));
$year       = intval($_POST['report_year'] ?? date('Y'));

$prepared_by      = $_POST['prepared_by'] ?? '';
$reviewed_by      = $_POST['reviewed_by'] ?? '';
$attested_by      = $_POST['attested_by'] ?? '';
$regular_contrib  = intval($_POST['regular_contrib'] ?? 0);
$contractual_contrib = intval($_POST['contractual_contrib'] ?? 0);

// ✅ Category-specific targets
$rmc_target     = isset($_POST['rmc_total_target']) ? intval($_POST['rmc_total_target']) : 0;
$nursery_target = isset($_POST['nursery_total_target']) ? intval($_POST['nursery_total_target']) : 0;

if (!$category || !$month || !$year) {
  die("Missing required data.");
}
if (!isset($_POST['species']) || !is_array($_POST['species'])) {
  die("Missing species data.");
}

$report_date = sprintf('%04d-%02d-01', $year, $month);

// --- Step 1: Insert personnel summary ---
$stmt1 = $conn->prepare("INSERT INTO personnel_summary (report_date, regular_personnel, contractual_personnel) VALUES (?, ?, ?)");
$stmt1->bind_param("sii", $report_date, $regular_contrib, $contractual_contrib);
$stmt1->execute();
$stmt1->close();

// --- Step 2: Insert report metadata ---
if ($category === 'RMC-2014-01') {
  $stmt2 = $conn->prepare("INSERT INTO report_metadata (report_date, prepared_by, reviewed_by, attested_by, rmc_target)
                           VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("ssssi", $report_date, $prepared_by, $reviewed_by, $attested_by, $rmc_target);
} elseif ($category === 'Nursery Maintenance') {
  $stmt2 = $conn->prepare("INSERT INTO report_metadata (report_date, prepared_by, reviewed_by, attested_by, nursery_target)
                           VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("ssssi", $report_date, $prepared_by, $reviewed_by, $attested_by, $nursery_target);
} else {
  $stmt2 = $conn->prepare("INSERT INTO report_metadata (report_date, prepared_by, reviewed_by, attested_by)
                           VALUES (?, ?, ?, ?)");
  $stmt2->bind_param("ssss", $report_date, $prepared_by, $reviewed_by, $attested_by);
}
$stmt2->execute();
$stmt2->close();

// --- Step 3: Insert seedling inventory rows ---
$speciesArr = $_POST['species'];

foreach ($speciesArr as $species) {
    if (empty($species['name'])) continue;

    if ($category === 'RMC-2014-01') {
        $prev    = intval($species['prev'] ?? 0);
        $prod    = intval($species['produced'] ?? 0);
        $disp    = intval($species['disposed'] ?? 0);
        $mort    = intval($species['mortality'] ?? 0);
        $remarks = $species['remarks'] ?? '';

        $stmt3 = $conn->prepare("INSERT INTO seedling_inventory (
            category, report_date, target, species,
            previous_stock, produced_this_month,
            disposed_this_month, mortality_this_month,
            remarks, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("ssisiisiis",
            $category, $report_date, $rmc_target, $species['name'],
            $prev, $prod, $disp, $mort,
            $remarks, $created_by
        );

    } elseif ($category === 'TCP Replacement') {
        $prev    = intval($species['prev'] ?? 0);
        $received = intval($species['received'] ?? 0);
        $disp    = intval($species['disposed'] ?? 0);
        $mort    = intval($species['mortality'] ?? 0);
        $remarks = $species['remarks'] ?? '';

        $stmt3 = $conn->prepare("INSERT INTO seedling_inventory (
            category, report_date, species,
            previous_stock, produced_this_month,
            disposed_this_month, mortality_this_month,
            remarks, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("sssiiiisi",
            $category, $report_date, $species['name'],
            $prev, $received, $disp, $mort,
            $remarks, $created_by
        );

    } elseif ($category === 'Nursery Maintenance') {
        $disposed = intval($species['disposed'] ?? 0);
        $remarks  = $species['remarks'] ?? '';

        $stmt3 = $conn->prepare("INSERT INTO seedling_inventory (
            category, report_date, target, species,
            disposed_this_month, remarks, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("ssisiis",
            $category, $report_date, $nursery_target, $species['name'],
            $disposed, $remarks, $created_by
        );
    }

    $stmt3->execute();
    $stmt3->close();
}

header('Location: seedling_details.php');
exit;

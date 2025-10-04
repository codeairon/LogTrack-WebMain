<?php
session_start();
require_once('../db_connect.php');

$created_by = $_SESSION['login_id'] ?? null;

// --- Step 1: Period and Personnel Info ---
$period = $_SESSION['seedling_period'] ?? [];
$month = intval($period['month'] ?? 0);
$year = intval($period['year'] ?? 0);
$regular = intval($period['regular'] ?? 0);
$contractual = intval($period['contractual'] ?? 0);
$prepared = trim($period['prepared_by'] ?? '');
$reviewed = trim($period['reviewed_by'] ?? '');
$attested = trim($period['attested_by'] ?? '');

// Validate
if (!$month || !$year || !$created_by) {
  die("❌ Invalid session data. Please restart the process.");
}

// --- Step 2: RMC Entries ---
$rmc_species = $_SESSION['seedling_rmc']['rmc_species'] ?? [];
$rmc_count = $_SESSION['seedling_rmc']['rmc_count'] ?? [];

// --- Step 3: TCP Entries ---
$tcp_species = $_SESSION['seedling_tcp']['tcp_species'] ?? [];
$tcp_count = $_SESSION['seedling_tcp']['tcp_count'] ?? [];

// --- Step 4: Nursery Entries ---
$nur_species = $_POST['nursery_species'] ?? [];
$nur_count = $_POST['nursery_count'] ?? [];

// --- Save personnel_summary ---
$stmt = $conn->prepare("INSERT INTO personnel_summary (report_date, regular_personnel, contractual_personnel, created_at)
                        VALUES (?, ?, ?, NOW())");
$report_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
$stmt->bind_param("sii", $report_date, $regular, $contractual);
$stmt->execute();
$stmt->close();

// --- Save report_metadata ---
$stmt = $conn->prepare("INSERT INTO report_metadata (report_date, prepared_by, reviewed_by, attested_by, created_at)
                        VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $report_date, $prepared, $reviewed, $attested);
$stmt->execute();
$stmt->close();

// --- Insert seedlings per category ---
function insertSeedlings($conn, $category, $speciesArr, $countArr, $month, $year, $created_by) {
  $stmt = $conn->prepare("INSERT INTO seedling_inventory
    (category, report_month, report_year, species, target, previous_stock,
     produced_this_month, seedling_received_this_month, disposed_this_month,
     mortality_this_month, remarks, created_by)
    VALUES (?, ?, ?, ?, 0, 0, 0, ?, 0, 0, ?, ?)");

  $remark = "Regular personnel required 300 seedlings and Contractual is 150 seedlings annually";

  foreach ($speciesArr as $i => $species) {
    $recv = intval($countArr[$i] ?? 0);
    $cleanSpecies = trim($species);
    if (!$cleanSpecies || $recv <= 0) continue;

    $stmt->bind_param("siisissi", $category, $month, $year, $cleanSpecies, $recv, $remark, $created_by);
    $stmt->execute();
  }

  $stmt->close();
}

insertSeedlings($conn, 'RMC-2014-01', $rmc_species, $rmc_count, $month, $year, $created_by);
insertSeedlings($conn, 'TCP Replacement', $tcp_species, $tcp_count, $month, $year, $created_by);
insertSeedlings($conn, 'Nursery Maintenance', $nur_species, $nur_count, $month, $year, $created_by);

// ✅ Done – clear session
unset($_SESSION['seedling_period']);
unset($_SESSION['seedling_rmc']);
unset($_SESSION['seedling_tcp']);

header("Location: seedling_details.php?category=RMC-2014-01&month=$month&year=$year&success=1");
exit;

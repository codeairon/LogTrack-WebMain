<?php
/* ------------ PHP: fetch data ------------ */
session_start();
require_once('../db_connect.php');

if (!isset($_GET['id'])) { echo "No log selected."; exit; }
$id   = intval($_GET['id']);

$log        = $conn->query("SELECT * FROM apprehended_logs WHERE id = $id")->fetch_assoc();
$products   = $conn->query("SELECT * FROM log_forest_products WHERE log_id = $id");
$conveyance = $conn->query("SELECT * FROM log_conveyance       WHERE log_id = $id");
$equipment  = $conn->query("SELECT * FROM log_equipment        WHERE log_id = $id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apprehension Receipt – LogTrack</title>
    <!-- Favicon (Logo on Browser Tab) -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body{font-family:'Segoe UI',sans-serif;background:#fff;padding:35px;color:#000;}
    h2,h3{margin:0;text-align:left}
    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{border:1px solid #000;padding:6px;font-size:13px;vertical-align:top}
    th{background:#f0f0f0}
    .header{text-align:center;margin-bottom:20px}
    .header img{width:80px;display:block;margin:0 auto 10px auto}
    .print-btn{float:right;padding:8px 16px;background:#2e7d32;color:#fff;border:none;border-radius:6px;cursor:pointer}
    .signatures{margin-top:40px}
    .sign-line{margin-top:40px;border-top:1px solid #000;width:300px;margin-left:auto;margin-right:auto}
    .sign-label{text-align:center;font-size:14px;margin-top:4px}
    .row{display:flex;justify-content:space-between;margin-top:40px}

    /* ---------- print styles ---------- */
    @media print{
      @page  { size:A4 portrait; margin:15mm; }
      .print-btn{display:none !important}
      body{padding:0}
    }
  </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">🖨️ Print Receipt</button>

<div class="print-scale-wrapper">

  <!-- Centered DENR header -->
  <div class="header">
    <img src="../assets/img/denr-logo.png" alt="DENR Logo">
    <div>
      Republic of the Philippines<br>
      <strong>Department of Environment and Natural Resources</strong><br>
      Community Environment and Natural Resources Office<br>
      <strong>OFFICE OF THE CENRO</strong><br>
      Cansan, Cabagan, Isabela
    </div>
  </div>

  <p style="text-align:center;font-weight:bold;margin-bottom:20px">
    APPREHENSION RECEIPT
  </p>

<?php
// Build Nature of Offense (same logic as earlier)
$offenseCategory = '';
$offenseType = '';
$offenseCustom = trim($log['offense_custom'] ?? '');

if (!empty($log['offense_category_id'])) {
  $res = $conn->query("SELECT name FROM offense_categories WHERE id=".(int)$log['offense_category_id']);
  if ($row = $res->fetch_assoc()) $offenseCategory = $row['name'];
}

if (!empty($log['offense_type_id'])) {
  $res = $conn->query("SELECT name FROM offense_types WHERE id=".(int)$log['offense_type_id']);
  if ($row = $res->fetch_assoc()) $offenseType = $row['name'];
}

$offenseFull = '';
if ($offenseCategory && $offenseType) {
  $offenseFull = "$offenseCategory – $offenseType";
} elseif ($offenseCategory) {
  $offenseFull = $offenseCategory;
} elseif ($offenseType) {
  $offenseFull = $offenseType;
}
if ($offenseCustom) {
  $offenseFull .= ($offenseFull ? " / " : "") . $offenseCustom;
}
?>

<p>
  This APPREHENSION RECEIPT is hereby issued for violation of 
  <strong><?= htmlspecialchars($offenseFull ?: 'Sec. 68 of PD 705 and related forestry laws') ?></strong>, 
  pursuant to Section 68 of Presidential Decree No. 705 (Revised Forestry Code of the Philippines) 
  and other applicable forestry laws.
</p>

  <div>
    <p><strong>Date & Time of Apprehension:</strong> <?= date('F d, Y – h:i A', strtotime($log['date_time'])) ?></p>
<?php
// Build Place of Apprehension
$districtName = '';
$municipalityName = '';
$barangayName = '';

// Get District name
if (!empty($log['district_id'])) {
  $res = $conn->query("SELECT name FROM districts WHERE id=".(int)$log['district_id']);
  if ($row = $res->fetch_assoc()) $districtName = $row['name'];
}

// Get Municipality name
if (!empty($log['municipality_id'])) {
  $res = $conn->query("SELECT name FROM municipalities WHERE id=".(int)$log['municipality_id']);
  if ($row = $res->fetch_assoc()) $municipalityName = $row['name'];
}

// Get Barangay name
if (!empty($log['barangay_id'])) {
  $res = $conn->query("SELECT name FROM barangays WHERE id=".(int)$log['barangay_id']);
  if ($row = $res->fetch_assoc()) $barangayName = $row['name'];
}

// Combine
$placeParts = array_filter([$districtName, $barangayName, $municipalityName]);
$placeFull = implode(', ', $placeParts) . ', Isabela';
?>
<p><strong>Place of Apprehension:</strong> <?= htmlspecialchars($placeFull) ?></p>

<td><?= htmlspecialchars($row['species_form'] ?? '') ?></td>
<td><?= htmlspecialchars($row['species_custom'] ?? '') ?></td>
<td><?= htmlspecialchars($row['form'] ?? '') ?></td>
<td><?= htmlspecialchars($row['form_custom'] ?? '') ?></td>
<td><?= htmlspecialchars($row['size'] ?? '') ?></td>
<td><?= htmlspecialchars($row['size_custom'] ?? '') ?></td>
<td><?= $row['no_of_pieces'] ?? '' ?></td>
<td><?= $row['volume'] ?? '' ?></td>
<td>₱<?= isset($row['estimated_value']) ? number_format($row['estimated_value'],2) : '0.00' ?></td>
<td><?= htmlspecialchars($row['origin'] ?? '') ?></td>
<td><?= nl2br(htmlspecialchars($row['owner_info'] ?? '')) ?></td>
  </div>
<!-- ===== FOREST PRODUCTS ===== -->
<h3>A. Forest Products</h3>
<table>
  <thead><tr>
    <th>Species / Form / Size</th>
    <th>No. of Pieces</th>
    <th>Volume (cu m)</th>
    <th>Est. Value (₱)</th>
    <th>Origin</th>
    <th>Owner / Other Offenders</th>
  </tr></thead>
  <tbody>
  <?php while($row = $products->fetch_assoc()): ?>
    <?php
      // Build combined text
      $species = trim(($row['species_form'] ?: '') . ' ' . ($row['species_custom'] ?: ''));
      $form    = trim(($row['form'] ?: '') . ' ' . ($row['form_custom'] ?: ''));
      $size    = trim(($row['size'] ?: '') . ' ' . ($row['size_custom'] ?: ''));

      $combined = trim($species . ' ' . $form . ' ' . $size);
    ?>
    <tr>
      <td><?= htmlspecialchars($combined) ?></td>
      <td><?= $row['no_of_pieces'] ?></td>
      <td><?= $row['volume'] ?></td>
      <td>₱<?= number_format($row['estimated_value'],2) ?></td>
      <td><?= htmlspecialchars($row['origin']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['owner_info'])) ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

  <!-- ===== CONVEYANCE ===== -->
  <h3>B. Conveyance</h3>
  <table>
    <thead><tr>
      <th>Kind</th><th>Plate No.</th><th>Engine/Chassis No.</th>
      <th>Est. Value (₱)</th><th>Driver / Registered Owner</th>
    </tr></thead>
    <tbody>
    <?php while($row = $conveyance->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['kind']) ?></td>
        <td><?= htmlspecialchars($row['plate_no']) ?></td>
        <td><?= htmlspecialchars($row['engine_chassis_no']) ?></td>
        <td>₱<?= number_format($row['estimated_value'],2) ?></td>
        <td><?= nl2br(htmlspecialchars($row['driver_owner_info'])) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- ===== EQUIPMENT ===== -->
  <h3>C. Equipment</h3>
  <table>
    <thead><tr>
      <th>Details</th><th>Features</th><th>Est. Value (₱)</th><th>Owner / Address</th>
    </tr></thead>
    <tbody>
    <?php while($row = $equipment->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['equipment_details']) ?></td>
        <td><?= htmlspecialchars($row['features']) ?></td>
        <td>₱<?= number_format($row['estimated_value'],2) ?></td>
        <td><?= nl2br(htmlspecialchars($row['owner_address'])) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Remarks -->
  <div style="margin-top:20px">
    <strong>Remarks / Other Information:</strong><br><br>
    <?= nl2br(htmlspecialchars($log['remarks'])) ?>
  </div>

  <!-- SIGNATURES -->
  <div class="signatures">
    <div class="row">
      <div>
        <div class="sign-line"></div>
        <div class="sign-label">Apprehending Officer: <?= htmlspecialchars($log['officer_name']) ?></div>
      </div>
      <div>
        <div class="sign-line"></div>
        <div class="sign-label">Witness: <?= htmlspecialchars($log['witness_name']) ?></div>
      </div>
    </div>
    <div class="row">
      <div>
        <div class="sign-line"></div>
        <div class="sign-label">Signature over Printed Name</div>
      </div>
      <div>
        <div class="sign-line"></div>
        <div class="sign-label">Signature over Printed Name</div>
      </div>
    </div>
  </div>

  <div style="margin-top:25px">
    <p><strong>Issued this:</strong> <?= htmlspecialchars($log['issue_date']) ?></p>
    <p><strong>CONFORM:</strong> <?= htmlspecialchars($log['conform_by']) ?></p>
  </div>

</div><!-- /print-scale-wrapper -->

</body>
</html>

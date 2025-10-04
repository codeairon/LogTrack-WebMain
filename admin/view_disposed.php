<?php
session_start();
require_once('../db_connect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Main disposed log with joins
$sql = "
  SELECT dl.*, 
         d.name AS district_name,
         m.name AS municipality_name,
         b.name AS barangay_name,
         oc.name AS offense_category,
         ot.name AS offense_type
  FROM disposed_logs dl
  LEFT JOIN districts d ON dl.district_id = d.id
  LEFT JOIN municipalities m ON dl.municipality_id = m.id
  LEFT JOIN barangays b ON dl.barangay_id = b.id
  LEFT JOIN offense_categories oc ON dl.offense_category_id = oc.id
  LEFT JOIN offense_types ot ON dl.offense_type_id = ot.id
  WHERE dl.id = $id
";
$log = $conn->query($sql)->fetch_assoc();
if (!$log) { echo "Disposed log not found."; exit; }

// Children
$forest = $conn->query("SELECT * FROM disposed_forest_products WHERE log_id = $id");
$convey = $conn->query("SELECT * FROM disposed_conveyance WHERE log_id = $id");
$equip  = $conn->query("SELECT * FROM disposed_equipment WHERE log_id = $id");

// Build place
$placeParts = array_filter([$log['district_name'], $log['barangay_name'], $log['municipality_name']]);
$placeFull = implode(', ', $placeParts) . ', Isabela';

// Build offense
$offense = [];
if (!empty($log['offense_category'])) $offense[] = $log['offense_category'];
if (!empty($log['offense_type'])) $offense[] = $log['offense_type'];
$offenseText = implode(" – ", $offense);
if (!empty($log['offense_custom'])) {
  $offenseText .= ($offenseText ? " / " : "") . $log['offense_custom'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Disposed Log Receipt – LogTrack</title>
    <!-- Favicon (Logo on Browser Tab) -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      padding: 35px;
      color: #000;
    }
    h2,h3 { margin:0; text-align:left }
    table { width:100%; border-collapse:collapse; margin-top:10px }
    th,td { border:1px solid #000; padding:6px; font-size:13px; vertical-align:top }
    th { background:#f0f0f0 }
    .header { text-align:center; margin-bottom:20px }
    .header img { width:80px; display:block; margin:0 auto 10px auto }
    .print-btn { float:right; padding:8px 16px; background:#2e7d32; color:#fff; border:none; border-radius:6px; cursor:pointer }
    .disposed-label { text-align:center; font-weight:bold; font-size:18px; color:#b71c1c; margin-bottom:15px }
    .signatures { margin-top:40px }
    .sign-line { margin-top:40px; border-top:1px solid #000; width:300px; margin-left:auto; margin-right:auto }
    .sign-label { text-align:center; font-size:14px; margin-top:4px }
    .row { display:flex; justify-content:space-between; margin-top:40px }

    @media print {
      @page { size:A4 portrait; margin:15mm; }
      .print-btn { display:none !important }
      body { padding:0 }
    }
  </style>
</head>
<body>

<button class="print-btn no-print" onclick="window.print()">🖨️ Print Disposed Receipt</button>

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

<div class="disposed-label">🗑️ DISPOSED APPREHENSION RECEIPT</div>

<p>
  This APPREHENSION RECEIPT pertains to forest products and/or conveyances that have been 
  formally marked as <strong>Disposed</strong>, in connection with the violation of 
  <strong><?= htmlspecialchars($offenseText ?: 'Sec. 68 of PD 705 and related forestry laws') ?></strong>, 
  pursuant to Section 68 of Presidential Decree No. 705 (Revised Forestry Code of the Philippines) 
  and other applicable forestry laws.
</p>

<div>
  <p><strong>Date & Time of Apprehension:</strong> <?= date('F d, Y – h:i A', strtotime($log['date_time'])) ?></p>
  <p><strong>Place of Apprehension:</strong> <?= htmlspecialchars($placeFull) ?></p>
</div>

<!-- A. Forest Products -->
<h3>A. Forest Products</h3>
<table>
  <thead>
    <tr>
      <th>Species / Form / Size</th>
      <th>No. of Pieces</th>
      <th>Volume (cu m)</th>
      <th>Est. Value (₱)</th>
      <th>Origin</th>
      <th>Owner / Other Offenders</th>
    </tr>
  </thead>
  <tbody>
    <?php while($r = $forest->fetch_assoc()): ?>
      <?php
        $species = trim(($r['species_form'] ?: '') . ' ' . ($r['species_custom'] ?: ''));
        $form    = trim(($r['form'] ?: '') . ' ' . ($r['form_custom'] ?: ''));
        $size    = trim(($r['size'] ?: '') . ' ' . ($r['size_custom'] ?: ''));
        $combined = trim($species . ' ' . $form . ' ' . $size);
      ?>
      <tr>
        <td><?= htmlspecialchars($combined) ?></td>
        <td><?= $r['no_of_pieces'] ?></td>
        <td><?= $r['volume'] ?></td>
        <td>₱<?= number_format($r['estimated_value'], 2) ?></td>
        <td><?= htmlspecialchars($r['origin']) ?></td>
        <td><?= nl2br(htmlspecialchars($r['owner_info'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- B. Conveyance -->
<h3>B. Conveyance</h3>
<table>
  <thead>
    <tr>
      <th>Kind</th>
      <th>Plate No.</th>
      <th>Engine/Chassis No.</th>
      <th>Est. Value (₱)</th>
      <th>Driver / Registered Owner</th>
    </tr>
  </thead>
  <tbody>
    <?php while($r = $convey->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['kind']) ?></td>
        <td><?= htmlspecialchars($r['plate_no']) ?></td>
        <td><?= htmlspecialchars($r['engine_chassis_no']) ?></td>
        <td>₱<?= number_format($r['estimated_value'], 2) ?></td>
        <td><?= nl2br(htmlspecialchars($r['driver_owner_info'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- C. Equipment -->
<h3>C. Equipment</h3>
<table>
  <thead>
    <tr>
      <th>Details</th>
      <th>Features</th>
      <th>Est. Value (₱)</th>
      <th>Owner / Address</th>
    </tr>
  </thead>
  <tbody>
    <?php while($r = $equip->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['equipment_details']) ?></td>
        <td><?= htmlspecialchars($r['features']) ?></td>
        <td>₱<?= number_format($r['estimated_value'], 2) ?></td>
        <td><?= nl2br(htmlspecialchars($r['owner_address'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Remarks -->
<div style="margin-top:20px">
  <strong>Remarks / Other Information:</strong><br><br>
  <?= nl2br(htmlspecialchars($log['remarks'])) ?>
</div>

<!-- Signatures -->
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

</body>
</html>

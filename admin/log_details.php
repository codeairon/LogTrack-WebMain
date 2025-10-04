<?php
/* -------------- security & DB -------------- */
session_start();
if (!isset($_SESSION['login_id'])) {
  header("Location: login.php");
  exit;
}
require_once('../db_connect.php');

/* grab all logs with joins */
$sql = "
  SELECT l.id, l.date_time, l.remarks, l.status, l.qr_filename,
         l.officer_name,
         -- Place
         d.name AS district_name,
         m.name AS municipality_name,
         b.name AS barangay_name,
         -- Offense
         oc.name AS offense_category,
         ot.name AS offense_type,
         l.offense_custom
  FROM apprehended_logs l
  LEFT JOIN districts d ON l.district_id = d.id
  LEFT JOIN municipalities m ON l.municipality_id = m.id
  LEFT JOIN barangays b ON l.barangay_id = b.id
  LEFT JOIN offense_categories oc ON l.offense_category_id = oc.id
  LEFT JOIN offense_types ot ON l.offense_type_id = ot.id
  ORDER BY l.date_time DESC
";

$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>LogTrack – Log Details</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

  <link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/log_details.css">
</head>

<body>
  <div class="layout">
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main-wrapper" id="mainWrapper">
    <header>
      <div class="header-content">
        <span class="menu-icon" onclick="toggleSidebar()">☰</span>
        <h2>LogTrack</h2>
      </div>
      <div class="right-icons">
        <div class="notification" title="Notifications">🔔</div>
      </div>
    </header>

    <div class="content">
      <!-- header row -->
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
        <h3 style="margin:4px 0;color:#2e7d32">Apprehended Log Details</h3>

        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <input id="searchBox" type="text" placeholder="Search..."
            style="padding:8px 10px;border:1px solid #ccc;border-radius:4px;min-width:230px">
          <button class="add-btn" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>
      </div>

      <!-- table -->
      <table id="tblLogs">
        <thead>
          <tr>
            <th>Date & Time</th>
            <th>Place</th>
            <th>Officer</th>
            <th>Violation</th>
            <th>Remarks</th>
            <th>Status</th>
            <th style="width:60px">QR</th>
            <th style="width:50px">Edit</th>
            <th style="width:60px">Disposed</th>
          </tr>
        </thead>
        <tbody id="logBody">
          <?php while ($row = $res->fetch_assoc()): ?>
            <tr class="log-row" data-id="<?= $row['id'] ?>" style="cursor:pointer">
              <td><?= date('F d, Y h:i A', strtotime($row['date_time'])) ?></td>
              <td>
                <?= htmlspecialchars($row['barangay_name'] ?? 'N/A') ?>, 
                <?= htmlspecialchars($row['municipality_name'] ?? '') ?> 
                Isabela
              </td>
              <td><?= htmlspecialchars($row['officer_name'] ?: 'N/A') ?></td>
              <td>
                <?php
                  $offense = [];
                   if (!empty($row['offense_custom'])) {
      echo htmlspecialchars($row['offense_custom']);
    } else {
      $parts = [];
      if (!empty($row['offense_category'])) $parts[] = $row['offense_category'];
      if (!empty($row['offense_type'])) $parts[] = $row['offense_type'];
      echo htmlspecialchars(implode(" – ", $parts));
    }
                ?>
              </td>
              <td><?= htmlspecialchars($row['remarks']) ?></td>
              <td>
                <?= $row['status'] === 'Closed'
                  ? '<span style="color:#43a047;font-weight:600">Closed</span>'
                  : '<span style="color:#1e88e5;font-weight:600">Active</span>'; ?>
              </td>
              <td style="text-align:center">
                <?php if (!empty($row['qr_filename']) && file_exists("../assets/qrcodes/{$row['qr_filename']}")): ?>
                  <img src="../assets/qrcodes/<?= $row['qr_filename'] ?>" width="60" alt="QR Code">
                <?php else: ?>
                  <span style="color:gray;font-size:12px">No QR</span>
                <?php endif; ?>
              </td>
              <td style="text-align:center">
                <i class="fas fa-pencil-alt" style="color:#1565c0;cursor:pointer"
                   onclick="event.stopPropagation(); openEditModal(<?= $row['id'] ?>)"></i>
              </td>
              <td style="text-align:center">
                <i class="fas fa-trash-alt" style="color:#b71c1c;cursor:pointer"
                   onclick="event.stopPropagation(); confirmDispose(<?= $row['id'] ?>)"></i>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div><!-- /main-wrapper -->

  <!-- Add Modal -->
  <?php include 'add_log_modal.php'; ?>

  <!-- Dispose confirm -->
  <div id="disposeModal" class="modal-flex" style="display:none">
    <div style="background:#fff;padding:25px;border-radius:6px;width:320px;text-align:center">
      <p>Dispose this log?<br><small>(You can still view it in Disposed Logs)</small></p>
      <button id="confirmBtn" style="background:#b71c1c;color:#fff;padding:6px 14px;border:none;border-radius:4px">Dispose</button>
      <button onclick="hideModal()" style="margin-left:12px">Cancel</button>
    </div>
  </div>

  <!-- Loader -->
  <div id="pageLoader" class="modal-flex" style="display:none;background:rgba(255,255,255,.6)">
    <div style="font-size:22px;color:#2e7d32;font-weight:600">Loading…</div>
  </div>
</div>
<script src="../assets/js/log_details.js"></script>
                
</body>
</html>

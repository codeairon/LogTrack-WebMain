<?php
session_start();
if (!isset($_SESSION['login_id'])) {
  header("Location: login.php");
  exit;
}

// prevent back button caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../db_connect.php');

// ---- Live KPIs ----
function fetch_one($conn, $sql) {
  $res = $conn->query($sql);
  if (!$res) return 0;
  $row = $res->fetch_assoc();
  return (int) array_values($row)[0];
}

$totalSeedlings = fetch_one($conn, "SELECT COALESCE(SUM(stock_to_date),0) FROM seedling_inventory");
$totalLogCases  = fetch_one($conn, "SELECT COUNT(*) FROM apprehended_logs");
$activeCases    = fetch_one($conn, "SELECT COUNT(*) FROM apprehended_logs WHERE status='Active'");
$staffCount     = fetch_one($conn, "SELECT COUNT(*) FROM staff");

// ---- Recent items ----
$recentLogs = $conn->query("
  SELECT l.id, l.status, l.created_at,
         CONCAT(
            COALESCE(b.name, ''), 
            CASE WHEN b.name IS NOT NULL THEN ', ' ELSE '' END,
            COALESCE(m.name, ''), 
            ' Isabela'
         ) AS place
  FROM apprehended_logs l
  LEFT JOIN barangays b ON l.barangay_id = b.id
  LEFT JOIN municipalities m ON l.municipality_id = m.id
  ORDER BY l.created_at DESC
  LIMIT 5
");

$recentSeedlings = $conn->query("
  SELECT species, category, stock_to_date, created_at
  FROM seedling_inventory
  ORDER BY created_at DESC
  LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon (Logo on Browser Tab) -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

<title>LogTrack - Admin Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<!-- ✅ FIX: Wrap sidebar + main in .layout -->
<div class="layout">

  <?php include 'sidebar.php'; ?>

  <div class="main-wrapper" id="mainWrapper">
    <header>
      <div style="display:flex; align-items:center;">
        <span class="menu-icon">☰</span>
        <h2>LogTrack – Admin Dashboard</h2>
      </div>
      <div title="Notifications" style="font-size:20px; color:#9ca3af;">🔔</div>
    </header>

    <main class="page">
      <h3>Dashboard Overview</h3>

      <section class="kpis">
        <div class="kpi seedlings">
          <div class="icon"><i class="fas fa-seedling"></i></div>
          <div><h4>Total Seedlings <br>(Stock-to-date)</br></h4><div class="num"><?= number_format($totalSeedlings) ?></div></div>
        </div>
        <div class="kpi logs">
          <div class="icon"><i class="fas fa-tree"></i></div>
          <div><h4>Total Log Cases</h4><div class="num"><?= number_format($totalLogCases) ?></div></div>
        </div>
        <div class="kpi staff">
          <div class="icon"><i class="fas fa-users"></i></div>
          <div><h4>Staff Accounts</h4><div class="num"><?= number_format($staffCount) ?></div></div>
        </div>
        <div class="kpi active">
          <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
          <div><h4>Active Cases</h4><div class="num"><?= number_format($activeCases) ?></div></div>
        </div>
      </section>

      <section class="grid-2">
        <div class="card">
          <h4><i class="fas fa-clipboard-list"></i> Recent Log Cases</h4>
          <ul class="list">
            <?php if ($recentLogs && $recentLogs->num_rows): ?>
              <?php while ($r = $recentLogs->fetch_assoc()): ?>
                <?php $status = strtoupper(trim($r['status'] ?? 'Active'));
                      $badge  = $status === 'CLOSED' ? 'status-closed' : 'status-active';
                      $when   = date('M d, Y h:i A', strtotime($r['created_at'])); ?>
                <li>
                  <i class="fas fa-file-alt" style="color: var(--brand); margin-top:2px;"></i>
                  <div>
                    <div><strong>Log #<?= (int)$r['id'] ?></strong>
                      <span class="pill <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                    </div>
                    <div class="place muted"><?= htmlspecialchars($r['place'] ?? '—') ?></div>
                    <div class="muted"><?= $when ?></div>
                  </div>
                </li>
              <?php endwhile; ?>
            <?php else: ?><li class="muted">No recent log cases.</li><?php endif; ?>
          </ul>
          <div class="footer-note">Showing latest 5 created cases.</div>
        </div>

        <div class="card">
          <h4><i class="fas fa-leaf"></i> Recent Seedling Entries</h4>
          <ul class="list">
            <?php if ($recentSeedlings && $recentSeedlings->num_rows): ?>
              <?php while ($s = $recentSeedlings->fetch_assoc()): ?>
                <?php $when = date('M d, Y h:i A', strtotime($s['created_at'])); ?>
                <li>
                  <i class="fas fa-seedling" style="color: var(--brand); margin-top:2px;"></i>
                  <div style="width:100%;">
                    <div style="display:flex; gap:8px; align-items:center;">
                      <strong><?= htmlspecialchars($s['species']) ?></strong>
                      <span class="pill"><?= htmlspecialchars($s['category']) ?></span>
                      <span class="pill" style="margin-left:auto;">Stock: <?= number_format((int)$s['stock_to_date']) ?></span>
                    </div>
                    <div class="muted"><?= $when ?></div>
                  </div>
                </li>
              <?php endwhile; ?>
            <?php else: ?><li class="muted">No recent seedling activity.</li><?php endif; ?>
          </ul>
          <div class="footer-note">Pulled from <code>seedling_inventory</code>, latest 5 rows.</div>
        </div>
      </section>
    </main>
  </div> <!-- end .main-wrapper -->

</div> <!-- ✅ end .layout -->

<script>
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const menuIcon = document.querySelector(".menu-icon");

  menuIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
  });

  // Dropdown Toggle
  document.querySelectorAll(".dropdown > a.nav-link").forEach(dropdown => {
    dropdown.addEventListener("click", function (e) {
      e.preventDefault();
      const container = this.nextElementSibling;
      container.style.display = (container.style.display === "flex") ? "none" : "flex";
    });
  });
});
</script>

</body>
</html>

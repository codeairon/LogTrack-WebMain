<?php
session_start();
if (!isset($_SESSION['login_id'])) {
  header("Location: login.php");
  exit;
}
require_once('../db_connect.php');

/* ✅ Correct merge: seedling_inventory + verified staff_contributions */
$sql = "
  SELECT 
      base.species,
      SUM(base.total_stock) AS total_stock
  FROM (
      /* Inventory calculation */
      SELECT 
          s.species,
          (
            COALESCE(SUM(s.previous_stock),0)
            + COALESCE(SUM(s.produced_this_month),0)
            + COALESCE(SUM(s.seedling_received_this_month),0)
            - COALESCE(SUM(s.disposed_this_month),0)
            - COALESCE(SUM(s.mortality_this_month),0)
          ) AS total_stock
      FROM seedling_inventory s
      GROUP BY s.species

      UNION ALL

      /* Staff contributions (only verified) */
      SELECT 
          sc.species,
          SUM(sc.quantity) AS total_stock
      FROM staff_contributions sc
      WHERE sc.status = 'verified'
      GROUP BY sc.species
  ) AS base
  GROUP BY base.species
  ORDER BY base.species ASC
";
$res = $conn->query($sql);

// accumulate grand total
$grandTotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Seedling Inventory – LogTrack</title>
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/seedlings.css">
</head>
<body>
  <div class="layout">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper" id="mainWrapper">
      <!-- Header -->
      <header>
        <div class="header-content">
          <span class="menu-icon" onclick="toggleSidebar()">☰</span>
          <h2>LogTrack</h2>
        </div>
      </header>

      <!-- Page Content -->
      <div class="content">
        <div class="table-header">
          <h3>Seedling Inventory</h3>
          <input id="searchBox" type="text" class="search-input" placeholder="Search species...">
        </div>

        <!-- Inventory Table -->
        <table id="tblSeedlings">
          <thead>
            <tr>
              <th>Species</th>
              <th>Total Stock</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $res->fetch_assoc()):
              $grandTotal += (int)$row['total_stock'];
            ?>
            <tr>
              <td><?= htmlspecialchars($row['species']) ?></td>
              <td><?= number_format((int)$row['total_stock']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
          <tfoot>
            <tr>
              <td style="text-align:right;font-weight:600">Grand Total:</td>
              <td><?= number_format($grandTotal) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

<script>
/* ✅ Sidebar toggle */
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const mainWrapper = document.getElementById('mainWrapper');
  sidebar.classList.toggle('active');
  mainWrapper.classList.toggle('shifted');
}

/* ✅ Live search */
document.getElementById('searchBox').addEventListener('input', e=>{
  const q = e.target.value.toLowerCase();
  document.querySelectorAll('#tblSeedlings tbody tr').forEach(tr=>{
    tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
</script>
</body>
</html>

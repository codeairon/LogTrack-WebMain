<?php
session_start();
if (!isset($_SESSION['login_id'])) {
  header("Location: login.php");
  exit;
}
require_once('../db_connect.php');

/* Inventory grouped by species */
$sql = "
  SELECT fp.species_form AS species,
         SUM(fp.no_of_pieces) AS total_pieces,
         SUM(fp.volume) AS total_volume
  FROM apprehended_logs l
  INNER JOIN log_forest_products fp ON l.id = fp.log_id
  WHERE l.status='Closed'
  GROUP BY fp.species_form
  ORDER BY fp.species_form ASC
";
$res = $conn->query($sql);

// accumulate totals
$grandPieces = $grandVolume = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log Inventory – LogTrack</title>
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/log_details.css">
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
          <h3>Log Inventory (Closed Cases)</h3>
          <input id="searchBox" type="text" class="search-input" placeholder="Search species...">
        </div>

        <!-- Inventory Table -->
        <table id="tblInventory">
          <thead>
            <tr>
              <th>Species</th>
              <th>Total Pieces</th>
              <th>Total Volume (cu. m.)</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row=$res->fetch_assoc()):
              $grandPieces += (int)$row['total_pieces'];
              $grandVolume += (float)$row['total_volume'];
            ?>
            <tr>
              <td><?= htmlspecialchars($row['species']) ?></td>
              <td><?= (int)$row['total_pieces'] ?></td>
              <td><?= number_format((float)$row['total_volume'],2) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
          <tfoot>
            <tr>
              <td style="text-align:right;font-weight:600">Grand Total:</td>
              <td><?= $grandPieces ?></td>
              <td><?= number_format($grandVolume,2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

<script>
document.getElementById('searchBox').addEventListener('input', e=>{
  const q=e.target.value.toLowerCase();
  document.querySelectorAll('#tblInventory tbody tr').forEach(tr=>{
    tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const mainWrapper = document.getElementById('mainWrapper');
  sidebar.classList.toggle('active');
  mainWrapper.classList.toggle('shifted');
}

</script>
</body>
</html>

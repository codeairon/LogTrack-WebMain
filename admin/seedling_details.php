<?php
session_start();
require_once('../db_connect.php');

// Default filters
$category = $_GET['category'] ?? 'RMC-2014-01';
$month = $_GET['month'] ?? date('n');
$year = $_GET['year'] ?? date('Y');

// ✅ Check completion status for each category
$categories = ['RMC-2014-01','TCP Replacement','Nursery Maintenance'];
$completed = [];

foreach ($categories as $cat) {
  $checkStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM seedling_inventory 
    WHERE category = ? 
    AND MONTH(report_date) = ? 
    AND YEAR(report_date) = ?");
  $checkStmt->bind_param("sii", $cat, $month, $year);
  $checkStmt->execute();
  $res = $checkStmt->get_result()->fetch_assoc();
  if ($res['cnt'] > 0) {
    $completed[] = $cat;
  }
}

// ✅ Get personnel summary
$report_date = sprintf('%04d-%02d-01', $year, $month);
$persStmt = $conn->prepare("SELECT * FROM personnel_summary WHERE report_date = ?");
$persStmt->bind_param("s", $report_date);
$persStmt->execute();
$personnel = $persStmt->get_result()->fetch_assoc();

// ✅ Fetch seedlings
$stmt = $conn->prepare("SELECT * FROM seedling_inventory 
  WHERE category = ? 
  AND MONTH(report_date) = ? 
  AND YEAR(report_date) = ?
  ORDER BY species ASC");
$stmt->bind_param("sii", $category, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

// Totals
$totalPrev = $totalProduced = $totalDisposed = $totalMortality = $totalStock = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seedling Inventory – LogTrack</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <!-- Icons + Global Styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css"> <!-- global -->
  <link rel="stylesheet" href="../assets/css/seedlings.css"> <!-- custom for seedlings -->
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main-wrapper">
    
    <!-- Header -->
    <header>
      <div class="header-content">
        <span class="menu-icon">☰</span>
        <h2>Seedling Inventory</h2>
      </div>
      <div class="right-icons">
        <div class="notification"><i class="fas fa-bell"></i></div>
      </div>
    </header>

    <!-- Content -->
    <div class="content">

      <!-- Table Header -->
      <div class="table-header">
        <h3>
          <?= htmlspecialchars($category) ?> – 
          <?= date('F', mktime(0, 0, 0, $month, 1)) ?> <?= $year ?>
        </h3>

        <div class="table-actions">
          <form method="GET" class="filter-form">
            <select name="category" required>
              <option value="RMC-2014-01" <?= $category == 'RMC-2014-01' ? 'selected' : '' ?>>RMC-2014-01</option>
              <option value="TCP Replacement" <?= $category == 'TCP Replacement' ? 'selected' : '' ?>>TCP Replacement</option>
              <option value="Nursery Maintenance" <?= $category == 'Nursery Maintenance' ? 'selected' : '' ?>>Nursery Maintenance</option>
            </select>

            <select name="month">
              <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= $month == $m ? 'selected' : '' ?>>
                  <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                </option>
              <?php endfor; ?>
            </select>

            <select name="year">
              <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
              <?php endfor; ?>
            </select>

            <input type="text" id="searchInput" class="search-input" placeholder="Search species...">
            <button type="submit" class="action-btn"><i class="fas fa-search"></i></button>
          </form>

          <button class="action-btn" onclick="openStep1Modal()">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>
      </div>

      <!-- ✅ Personnel Summary -->
      <?php if ($personnel): ?>
      <div class="personnel-summary">
        <p><strong>Regular Personnel:</strong> <?= (int)$personnel['regular_personnel'] ?></p>
        <p><strong>Contractual Personnel:</strong> <?= (int)$personnel['contractual_personnel'] ?></p>
      </div>
      <?php endif; ?>

      <!-- Table -->
      <div class="table-container">
        <table id="seedlingTable">
          <thead>
            <tr>
              <th>Species</th>
              <th>Previous Stock</th>
              <th>Produced</th>
              <th>Disposed</th>
              <th>Mortality</th>
              <th>Stock to Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): 
              $totalPrev     += (int)$row['previous_stock'];
              $totalProduced += (int)$row['produced_this_month'];
              $totalDisposed += (int)$row['disposed_this_month'];
              $totalMortality+= (int)$row['mortality_this_month'];
              $totalStock    += (int)$row['stock_to_date'];
            ?>
              <tr>
                <td><?= htmlspecialchars($row['species']) ?></td>
                <td><?= $row['previous_stock'] ?></td>
                <td><?= $row['produced_this_month'] ?></td>
                <td><?= $row['disposed_this_month'] ?></td>
                <td><?= $row['mortality_this_month'] ?></td>
                <td><strong><?= $row['stock_to_date'] ?></strong></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Total</th>
              <th><?= $totalPrev ?></th>
              <th><?= $totalProduced ?></th>
              <th><?= $totalDisposed ?></th>
              <th><?= $totalMortality ?></th>
              <th><?= $totalStock ?></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Alerts Section -->
      <div class="alerts">
        <?php foreach ($categories as $cat): ?>
          <?php if (in_array($cat, $completed)): ?>
            <div class="alert success">
              <i class="fas fa-check-circle"></i> <?= $cat ?> – Completed
            </div>
          <?php else: ?>
            <div class="alert warning">
              <i class="fas fa-exclamation-triangle"></i> <?= $cat ?> – Not yet submitted
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

    </div><!-- content -->
  </div><!-- main-wrapper -->
</div><!-- layout -->

<!-- ✅ Only keep the new Category Selection Modal -->
<?php include 'add_seedling_modal.php'; ?>

<script>
// Sidebar toggle
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const menuIcon = document.querySelector(".menu-icon");
  menuIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
  });
});

// Live search
document.getElementById('searchInput').addEventListener('input', function () {
  const term = this.value.toLowerCase();
  document.querySelectorAll('#seedlingTable tbody tr').forEach(row => {
    const species = row.cells[0].textContent.toLowerCase();
    row.style.display = species.includes(term) ? '' : 'none';
  });
});

function openStep1Modal() {
  document.getElementById('categoryModal').style.display = 'flex';
}

function openSeedlingForm(type) {
  document.getElementById('categoryModal').style.display = 'none';
  if (type === 'rmc') {
    document.getElementById('step2RmcModal').style.display = 'flex';
  } else if (type === 'tcp') {
    document.getElementById('step3TCPModal').style.display = 'flex';
  } else if (type === 'nursery') {
    document.getElementById('step4NurseryModal').style.display = 'flex';
  }
  else if (type === 'personnel') {
  document.getElementById('personnelModal').style.display = 'flex';
}
}

function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}
</script>
</body>
</html>

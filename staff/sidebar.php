<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="../assets/img/denr-logo.png" alt="DENR Logo" />
    <span>Staff</span>
  </div>

  <!-- Home -->
  <a href="dashboard.php" class="nav-link active">
    <i class="fas fa-home"></i> Home
  </a>

  <!-- Log Section -->
  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-file-alt"></i> Log Case</a>
    <div class="dropdown-container">
      <a href="log_details.php">Log Details</a>
      <a href="disposed_log.php">Disposed Logs</a>
      <a href="log_inventory.php">Log Inventory</a>
    </div>
  </div>

  <!-- Seedling Section -->
  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-seedling"></i> Seedlings</a>
    <div class="dropdown-container">
      <a href="contributions.php">My Contributions</a>
      <a href="requests.php">Seedling Requests</a>
    </div>
  </div>

  <!-- Reports -->
  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-chart-line"></i> Reports</a>
    <div class="dropdown-container">
      <a href="reports.php">My Reports</a>
    </div>
  </div>

  <!-- Staff Account Section -->
  <div class="admin-section">
    <div class="admin-info">
      <i class="fas fa-user-circle"></i>
      <div class="user-meta">
        <strong><?php echo htmlspecialchars($_SESSION['staff_name']); ?></strong><br>
        <small>(<?php echo htmlspecialchars($_SESSION['staff_type']); ?>)</small><br>
      </div>
    </div>
    <a href="settings.php" class="nav-link text-info">
      <i class="fas fa-cog"></i> Account Settings
    </a>
    <a href="logout.php" class="logout-btn">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</div>

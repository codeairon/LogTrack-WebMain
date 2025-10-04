<!-- admin/sidebar.php -->
<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="../assets/img/denr-logo.png" alt="DENR Logo" />
    <span>DENR</span>
  </div>

  <a href="dashboard.php" class="nav-link active">
    <i class="fas fa-home"></i> Home
  </a>

  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-file-alt"></i> Log Case</a>
    <div class="dropdown-container">
      <a href="log_details.php">Log Details</a>
      <a href="disposed_log.php">Disposed Logs</a>
      <a href="log_inventory.php">Log Inventory</a>
    </div>
  </div>

  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-seedling"></i> Seedling</a>
    <div class="dropdown-container">
      <a href="seedling_personnel.php">Personnel Contribution</a>
      <a href="seedlings_rmc.php">RMC Contribution</a>
      <a href="seedling_tcp.php">TCP Contribution</a>
      <a href="seedling_nursery.php">Nursery Contribution</a>
      <a href="seedling_details.php">Seedling Details</a>
      <a href="#">Seedling Request</a>
    </div>
  </div>

  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-chart-line"></i> Reports</a>
    <div class="dropdown-container">
      <a href="#">Generate Reports</a>
      <a href="#">Send Manual Alerts</a>
    </div>
  </div>

  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-users-cog"></i> User Management</a>
    <div class="dropdown-container">
      <a href="#">Manage Accounts</a>
       <a href="pnp_accounts.php">PNP Accounts</a>
      <a href="#">Role & Access Control</a>
    </div>
  </div>

  <div class="dropdown">
    <a class="nav-link"><i class="fas fa-cogs"></i> Settings</a>
    <div class="dropdown-container">
      <a href="#">Backup & Restore</a>
    </div>
  </div>

  <div class="admin-section">
    <div class="admin-info">
      <i class="fas fa-user-circle"></i>
      <span><?php echo $_SESSION['login_name']; ?></span>
    </div>
    <a href="admin_register.php" class="nav-link text-success">
      <i class="fas fa-user-plus"></i> Register Admin
    </a>
    <a href="logout.php" class="logout-btn">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</div>

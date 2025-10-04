<!-- pnp/sidebar.php -->
<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="../assets/img/denr-logo.png" alt="DENR Logo" />
    <span>DENR – PNP</span>
  </div>

  <a href="pnp_dashboard.php" class="nav-link active">
    <i class="fas fa-home"></i> Home
  </a>

  <div class="dropdown">
    <a href="pnp_apprehension_form.php" class="nav-link">
      <i class="fas fa-file-alt"></i> Apprehension Form
    </a>
  </div>

  <div class="dropdown">
    <a href="pnp_view_logs.php" class="nav-link">
      <i class="fas fa-list"></i> View Log Details
    </a>
  </div>

  <div class="dropdown">
    <a href="pnp_view_seedlings.php" class="nav-link">
      <i class="fas fa-seedling"></i> View Seedlings
    </a>
  </div>

  <div class="dropdown">
    <a href="pnp_request_seedlings.php" class="nav-link">
      <i class="fas fa-hand-holding"></i> Request Seedlings
    </a>
  </div>

  <div class="dropdown">
    <a href="pnp_notifications.php" class="nav-link">
      <i class="fas fa-bell"></i> Notifications
    </a>
  </div>

  <div class="dropdown">
    <a href="pnp_qr_scan.php" class="nav-link">
      <i class="fas fa-qrcode"></i> QR Scan
    </a>
  </div>

  <div class="admin-section">
    <div class="admin-info">
      <i class="fas fa-user-circle"></i>
      <span><?php echo $_SESSION['pnp_name'] ?? 'PNP Officer'; ?></span>
    </div>
    <a href="pnp_logout.php" class="logout-btn">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</div>

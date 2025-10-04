<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
  header('Location: login.php');
  exit;
}

$name  = $_SESSION['staff_name'];
$type  = $_SESSION['staff_type'];
$email = $_SESSION['staff_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <title>Staff Dashboard – LogTrack</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="layout">

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <div class="main-wrapper" id="mainWrapper">
    <!-- Header -->
    <header>
      <div style="display:flex; align-items:center;">
        <span class="menu-icon">☰</span>
        <h2>🌱 Staff Dashboard</h2>
      </div>
    </header>

    <!-- Page Content -->
    <main class="page">
      <h3>Quick Access</h3>
      <div class="card-grid">
        <div class="card">
          <i class="fas fa-tree"></i>
          <h3>My Seedling Contributions</h3>
          <p>View your submitted seedling data.</p>
        </div>
        <div class="card">
          <i class="fas fa-file-alt"></i>
          <h3>Apprehended Logs</h3>
          <p>Check logs related to your station or unit.</p>
        </div>
        <div class="card">
          <i class="fas fa-bell"></i>
          <h3>Notifications</h3>
          <p>See important reminders or contribution alerts.</p>
        </div>
      </div>
    </main>
  </div><!-- end .main-wrapper -->

</div><!-- end .layout -->

<script>
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const menuIcon = document.querySelector(".menu-icon");

  menuIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
  });

  // Dropdown Toggle (same as admin)
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

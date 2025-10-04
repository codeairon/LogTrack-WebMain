<?php
session_start();
if (!isset($_SESSION['pnp_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PNP Dashboard | LogTrack</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <!-- FontAwesome + Styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-wrapper">
  <header>
    <div class="header-content">
      <span class="menu-icon">☰</span>
      <h2>LogTrack – PNP Dashboard</h2>
    </div>
    <div class="right-icons">
      <div class="notification" title="Notifications">🔔</div>
    </div>
  </header>

  <div class="content">
    <h2>Welcome, <?php echo $_SESSION['pnp_name']; ?> 👋</h2>
    <p>This is your PNP Dashboard. Features will be added here.</p>
  </div>
</div>

<script>
  const menuIcon = document.querySelector(".menu-icon");
  const sidebar = document.querySelector(".sidebar");

  menuIcon.addEventListener("click", function() {
    sidebar.classList.toggle("active");
    // no need for mainWrapper.shifted if using sibling selector in CSS
  });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LogTrack | Landing Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/denr-logo.png">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --brand: #2e7d32;
    --brand-dark: #1b5e20;
    --bg: #f4f6f8;
    --card: #ffffff;
    --text: #222;
    --muted: #6b7280;
    --shadow: 0 2px 8px rgba(0,0,0,0.08);
    --radius: 14px;
  }

  body {
    margin: 0;
    font-family: "Segoe UI", system-ui, sans-serif;
    background: var(--bg);
    color: var(--text);
  }

  /* Hero with background image */
  .landing-content {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    height: calc(100vh - 70px);
    text-align: center;
    padding: 20px;

    /* bg image + gradient overlay */
    background: 
      linear-gradient(rgba(21, 83, 45, 0.8), rgba(22, 101, 52, 0.9)),
      url("assets/img/bg.png") center/cover no-repeat;
    color: #fff;
  }

  .landing-content h1 {
    font-size: 3.5rem; font-weight: 800;
    letter-spacing: -1px;
    text-shadow: 0 3px 6px rgba(0,0,0,0.5);
  }
  .landing-content h1 span {
    color: #a7f3d0;
  }
  .landing-content p {
    font-size: 1.2rem;
    color: #f0fdf4;
    text-shadow: 0 2px 4px rgba(0,0,0,0.4);
  }
  .btn-arrow {
    margin-top: 40px;
    background: #22c55e;
    color: #fff;
    border-radius: 50%;
    padding: 14px 18px;
    font-size: 1.5rem;
    transition: all .3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
  }
  .btn-arrow:hover {
    background: #16a34a;
    transform: translateY(3px);
  }
  /* Navbar */
.navbar {
  background: var(--card);
  box-shadow: var(--shadow);
  height: 70px;              /* Fixed height */
  padding: 0 1rem !important;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.navbar-brand {
  font-weight: 700;
  font-size: 1.1rem;
  color: var(--brand) !important;
  display: flex;
  align-items: center;
}

.navbar-brand img {
  width: 36px;
  height: 36px;
  object-fit: contain;
  margin-right: 8px;
}

.navbar .btn {
  font-weight: 600;
  font-size: 0.9rem;
  padding: 6px 14px;
  border-radius: 8px;
}

</style>

</head>

<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-4">
  <a class="navbar-brand d-flex align-items-center" href="#top">
    <img src="assets/img/denr-logo.png" alt="DENR Logo" class="me-2">
    DENR – CENRO | LogTrack
  </a>
  <div class="ms-auto d-flex align-items-center">

    <!-- Login Dropdown -->
    <div class="dropdown me-2">
      <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Login
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow">
        <li><a class="dropdown-item" href="admin/login.php">Admin</a></li>
        <li><a class="dropdown-item" href="pnp/login.php">PNP</a></li>
        <li><a class="dropdown-item" href="staff/login.php">Staff</a></li>
        <li><a class="dropdown-item" href="user/login.php">Guest/User</a></li>
      </ul>
    </div>

    <!-- Register Dropdown -->
    <div class="dropdown">
      <button class="btn btn-theme dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Register
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow">
        <li><a class="dropdown-item" href="staff/register.php">Staff</a></li>
        <li><a class="dropdown-item" href="pnp/pnp_register.php">PNP</a></li>
        <li><a class="dropdown-item" href="#">User</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div id="top" class="landing-content">
  <h1><span>Log</span>Track</h1>
  <p class="mt-3">A Web & Mobile System for Seedling Monitoring and Log Case Tracking</p>
  <p>Developed for CENRO Cabagan under DENR.</p>
  
  <a href="#about" class="btn btn-arrow"><i class="fas fa-chevron-down"></i></a>
</div>

<!-- About Us Section -->
<section id="about" class="about-section py-5">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Left: Image -->
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="assets/img/DENR.jpg" alt="LogTrack Team" class="img-fluid">
      </div>

      <!-- Right: Text -->
      <div class="col-md-6">
        <h2 class="mb-3">About LogTrack</h2>
        <p><strong>LogTrack</strong> is a web and mobile-based system designed to assist the Department of Environment and Natural Resources (DENR) – CENRO Cabagan in monitoring seedling inventories and managing illegal log apprehension cases efficiently.</p>
        <p>Built with modern technologies, LogTrack enhances transparency, data tracking, and operational speed between DENR personnel, PNP authorities, and the community. Our platform ensures accurate documentation, secure authentication, and real-time data access.</p>

        <a href="#top" class="btn btn-theme mt-4">Back to Top</a>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

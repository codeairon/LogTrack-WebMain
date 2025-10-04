<?php
session_start();
require_once("../db_connect.php");

// Fetch all PNP users
$query = "SELECT * FROM pnp_users ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PNP Accounts – LogTrack</title>

  <!-- Favicon (Logo on Browser Tab) -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css"> <!-- your admin CSS -->
   <link rel="stylesheet" href="../assets/css/seedling.css"> <!-- your admin CSS -->

  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      overflow-y: auto;
    }

    .main-wrapper {
      margin-left: 0;
      padding: 20px;
      min-height: 100vh;
      overflow-x: auto;
      transition: margin-left 0.3s ease;
    }

    .sidebar.active + .main-wrapper {
      margin-left: 220px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #388e3c;
      color: #fff;
    }

    tr:hover { background: #f9f9f9; }

    .badge { padding: 4px 8px; border-radius: 6px; font-size: 13px; color: #fff; }
    .badge-pending { background: #ff9800; }
    .badge-approved { background: #4caf50; }
    .badge-rejected { background: #f44336; }

    .action-btn { padding: 5px 10px; border-radius: 6px; cursor: pointer; border: none; font-size: 13px; }
    .approve { background: #4caf50; color: #fff; }
    .reject { background: #f44336; color: #fff; }
  </style>
</head>
<body>
<div class="layout">
<?php include 'sidebar.php'; ?>

<div class="main-wrapper">
  <header>
    <div class="header-content">
      <span class="menu-icon" onclick="document.querySelector('.sidebar').classList.toggle('active')">☰</span>
      <h2>LogTrack – PNP Accounts</h2>
    </div>
  </header>

  <div class="content">
    <h2>PNP Accounts</h2>

    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>ID Document</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['contact']) ?></td>
              <td><?= htmlspecialchars($row['address']) ?></td>
              <td>
                <?php if ($row['id_document']): ?>
                  <a href="../pnp/uploads/id_cards/<?= $row['id_document'] ?>" target="_blank">View</a>
                <?php else: ?>
                  N/A
                <?php endif; ?>
              </td>
              <td>
                <span class="badge badge-<?= strtolower($row['status']) ?>">
                  <?= $row['status'] ?>
                </span>
              </td>
              <td>
                <?php if ($row['status'] === 'Pending'): ?>
                  <form action="process_pnp_user.php" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="action-btn approve">Approve</button>
                  </form>
                  <form action="process_pnp_user.php" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="action-btn reject">Reject</button>
                  </form>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" style="text-align:center;">No PNP accounts found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</div>

</body>
</html>

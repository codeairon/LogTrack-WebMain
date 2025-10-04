<?php
session_start();
require_once('../db_connect.php');

if (!isset($_SESSION['login_id'])) {
  header("Location: login.php");
  exit;
}

// join with reference tables
$sql = "
  SELECT dl.*, 
         d.name AS district_name,
         m.name AS municipality_name,
         b.name AS barangay_name,
         oc.name AS offense_category,
         ot.name AS offense_type
  FROM disposed_logs dl
  LEFT JOIN districts d ON dl.district_id = d.id
  LEFT JOIN municipalities m ON dl.municipality_id = m.id
  LEFT JOIN barangays b ON dl.barangay_id = b.id
  LEFT JOIN offense_categories oc ON dl.offense_category_id = oc.id
  LEFT JOIN offense_types ot ON dl.offense_type_id = ot.id
  ORDER BY dl.disposed_at DESC
";
$rows = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Disposed Logs – LogTrack</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Global Styles -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/disposed_log.css">
</head>
<body>
<div class="layout">
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main -->
  <div class="main-wrapper" id="mainWrapper">
    <header>
      <div class="header-content">
        <span class="menu-icon" onclick="toggleSidebar()">☰</span>
        <h2>LogTrack – Disposed Logs</h2>
      </div>
    </header>

    <main class="page">
      <div class="table-header">
        <h3>Disposed Logs</h3>
        <input id="search" class="search-input" placeholder="Search place / offense...">
      </div>

      <table id="tbl">
        <thead>
          <tr>
            <th>Disposed At</th>
            <th>Place</th>
            <th>Violation</th>
            <th>Officer</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while($r=$rows->fetch_assoc()): ?>
          <?php
            // Build place string
            $placeParts = array_filter([$r['district_name'], $r['barangay_name'], $r['municipality_name']]);
            $place = implode(', ', $placeParts) . ', Isabela';

            // Build offense string
            $offense = [];
            if (!empty($r['offense_category'])) $offense[] = $r['offense_category'];
            if (!empty($r['offense_type'])) $offense[] = $r['offense_type'];
            $offenseText = implode(" – ", $offense);
            if (!empty($r['offense_custom'])) {
              $offenseText .= ($offenseText ? " / " : "") . $r['offense_custom'];
            }
          ?>
          <tr>
            <td><?= date('F d, Y',strtotime($r['disposed_at'])) ?></td>
            <td><?= htmlspecialchars($place) ?></td>
            <td><?= htmlspecialchars($offenseText) ?></td>
            <td><?= htmlspecialchars($r['officer_name']) ?></td>
            <td class="actions">
              <a href="view_disposed.php?id=<?= $r['id'] ?>" class="btn-icon">
                <i class="fas fa-eye"></i>
              </a>
              <button class="btn-icon danger" onclick="askDelete(<?= $r['id'] ?>)">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </main>
  </div>
</div>

<!-- Delete Modal -->
<div id="delModal" class="modal-overlay" style="display:none;">
  <div class="modal-box">
    <p>Delete this disposed record permanently?<br>
       <small>(cannot be undone)</small></p>
    <div class="modal-actions">
      <button id="delYes" class="btn danger">Delete</button>
      <button onclick="hideDel()" class="btn secondary">Cancel</button>
    </div>
  </div>
</div>

<script>
const inp=document.getElementById('search');
inp.addEventListener('input',()=>{
  const q=inp.value.toLowerCase();
  document.querySelectorAll('#tbl tbody tr').forEach(tr=>{
    const rowText = tr.textContent.toLowerCase();
    tr.style.display = rowText.includes(q) ? '' : 'none';
  });
});
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('active');
  document.getElementById('mainWrapper').classList.toggle('shifted');
}
let delId = 0;
function askDelete(id){
  delId = id;
  document.getElementById('delModal').style.display='flex';
}
function hideDel(){ document.getElementById('delModal').style.display='none'; }

document.getElementById('delYes').onclick = () => {
  fetch('delete_disposed.php', {
     method:'POST',
     headers:{'Content-Type':'application/x-www-form-urlencoded'},
     body:'id='+delId})
  .then(r=>r.json()).then(res=>{
     if(res.ok){ location.reload(); }
     else{ alert('Error: '+res.msg); hideDel(); }
  });
};
</script>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
  header('Location: login.php');
  exit;
}

require_once('../db_connect.php');

$staff_id = $_SESSION['staff_id'];
$name     = $_SESSION['staff_name'];
$year = date('Y');

$stmt = $conn->prepare("
    SELECT DISTINCT MONTH(report_date) AS month
    FROM staff_contributions
    WHERE staff_id = ? AND YEAR(report_date) = ?
");
$stmt->bind_param("ii", $staff_id, $year);
$stmt->execute();
$result = $stmt->get_result();

$contributedMonths = [];
while ($row = $result->fetch_assoc()) {
  $contributedMonths[] = (int)$row['month'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../assets/img/denr-logo.png">
  <title>My Contributions – LogTrack</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">    
  <link rel="stylesheet" href="../assets/css/staff_contribution.css">
  <style>
    /* Modal */
    .modal {
      display: none; 
      position: fixed; 
      z-index: 1000; 
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center; align-items: center;
    }
    .modal-content {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      width: 90%;
      max-width: 600px;
      box-shadow: var(--shadow);
      animation: fadeIn .3s ease;
    }
    @keyframes fadeIn { from {opacity:0; transform:scale(.9);} to {opacity:1; transform:scale(1);} }
    .close {
      float: right; font-size: 22px; cursor: pointer; color: #999;
    }
    .close:hover { color: #000; }
    table { width: 100%; margin-top: 1rem; border-collapse: collapse; }
    th, td { padding: 8px; border-bottom: 1px solid #eee; text-align: center; }
    input[type="number"], select, input[type="text"] {
      padding: 5px; width: 90%;
    }
    .toast {
      position: fixed; bottom: 20px; right: 20px;
      background: #333; color: #fff; padding: 10px 20px;
      border-radius: 6px; display: none;
    }
  </style>
</head>
<body>
<div class="layout">

  <?php include 'sidebar.php'; ?>

  <div class="main-wrapper" id="mainWrapper">
    <header>
      <div style="display:flex; align-items:center;">
        <span class="menu-icon">☰</span>
        <h2>🌱 My Contributions</h2>
      </div>
    </header>

    <main class="page">
      <h3>Contribution Status – <?= $year ?></h3>

      <div class="contribution-grid">
        <?php
        for ($m = 1; $m <= 12; $m++) {
          $monthName = date("F", mktime(0, 0, 0, $m, 1));
          $hasContribution = in_array($m, $contributedMonths);
          ?>
          <div class="contribution-card <?= $hasContribution ? 'done' : 'pending' ?>">
            <h4><?= $monthName ?></h4>
            <?php if ($hasContribution): ?>
              <p><i class="fas fa-check-circle"></i> Submitted</p>
            <?php else: ?>
              <p><i class="fas fa-exclamation-circle"></i> Missing</p>
              <button class="btn-add" data-month="<?= $m ?>">Add Contribution</button>
            <?php endif; ?>
          </div>
        <?php } ?>
      </div>
    </main>
  </div>
</div>

<!-- Contribution Modal -->
<div class="modal" id="contributionModal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Add Contribution for <span id="monthLabel"></span></h3>
    <form id="contributionForm">
      <input type="hidden" name="month" id="monthInput">
      <table id="speciesTable">
        <thead>
          <tr><th>Species</th><th>Quantity</th><th>Action</th></tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" name="species[]" required></td>
            <td><input type="number" name="quantity[]" min="1" required></td>
            <td><button type="button" class="removeRow">❌</button></td>
          </tr>
        </tbody>
      </table>
      <button type="button" id="addRow">+ Add Row</button>
      <p style="margin-top:10px; font-weight:600;">Total: <span id="totalDisplay">0</span> seedlings</p>
      <p style="color:#e53935;">⚠ Minimum requirement: 300 seedlings</p>
      <button type="submit" class="btn-submit">Submit Contribution</button>
    </form>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("contributionModal");
  const monthLabel = document.getElementById("monthLabel");
  const monthInput = document.getElementById("monthInput");
  const toast = document.getElementById("toast");

  // Open modal
  document.querySelectorAll(".btn-add").forEach(btn => {
    btn.addEventListener("click", function () {
      const month = this.getAttribute("data-month");
      monthLabel.textContent = new Date(2025, month-1, 1).toLocaleString('default',{month:'long'});
      monthInput.value = month;  // ✅ hidden input gets value
      modal.style.display = "flex";
    });
  });

  document.querySelector(".close").onclick = () => modal.style.display = "none";
  window.onclick = e => { if (e.target == modal) modal.style.display = "none"; };

  // Add/remove rows
  document.getElementById("addRow").addEventListener("click", () => {
    const row = `<tr>
      <td><input type="text" name="species[]" required></td>
      <td><input type="number" name="quantity[]" min="1" required></td>
      <td><button type="button" class="removeRow">❌</button></td>
    </tr>`;
    document.querySelector("#speciesTable tbody").insertAdjacentHTML("beforeend", row);
  });
  document.getElementById("speciesTable").addEventListener("click", e => {
    if (e.target.classList.contains("removeRow")) {
      e.target.closest("tr").remove();
      updateTotal();
    }
  });

  // Auto update total
  document.getElementById("speciesTable").addEventListener("input", updateTotal);
  function updateTotal() {
    let total = 0;
    document.querySelectorAll('input[name="quantity[]"]').forEach(q => total += parseInt(q.value||0));
    document.getElementById("totalDisplay").textContent = total;
  }

  // Submit form via AJAX
  document.getElementById("contributionForm").addEventListener("submit", function(e){
    e.preventDefault();
    let total = parseInt(document.getElementById("totalDisplay").textContent);
    if (total < 300) {
      showToast("❌ Failed to meet the required contribution");
      return;
    }
    const formData = new FormData(this);

    // Debug: log what is being sent
    for (let pair of formData.entries()) {
      console.log(pair[0]+ ': ' + pair[1]);
    }

    fetch("handle_add_contribution.php", {
      method: "POST", body: formData
    })
    .then(r=>r.json())
    .then(res=>{
      showToast(res.message);
      if (res.success) { setTimeout(()=>location.reload(), 2000); }
    })
    .catch(err=>showToast("Error submitting contribution"));
  });

  function showToast(msg) {
    toast.textContent = msg;
    toast.style.display = "block";
    setTimeout(()=>toast.style.display="none", 3000);
  }
});
</script>
</body>
</html>

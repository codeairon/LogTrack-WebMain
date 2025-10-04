<!-- 🔹 Global Species List (used in all forms) -->
<datalist id="speciesList">
  <option value="Narra"></option>
  <option value="Mahogany"></option>
  <option value="Acacia"></option>
  <option value="Ipil-ipil"></option>
  <option value="Molave"></option>
  <option value="Tuai"></option>
  <option value="Gmelina"></option>
  <option value="Bamboo"></option>
  <!-- You can add more here -->
</datalist>

<!-- Category Selection Modal -->
<div id="categoryModal" class="modal" style="display:none;">
  <div class="modal-content">
    <h3>Select Seedling Category</h3>
    <div class="category-options">
      <button onclick="openSeedlingForm('rmc')" class="category-btn">🌱 RMC-2014-01</button>
      <button onclick="openSeedlingForm('tcp')" class="category-btn">🌿 TCP Replacement</button>
      <button onclick="openSeedlingForm('nursery')" class="category-btn">🌳 Nursery Maintenance</button>
      <button onclick="openSeedlingForm('personnel')" class="category-btn">👥 Personnel</button>
    </div>
    <button class="close-btn" onclick="closeModal('categoryModal')">Cancel</button>
  </div>
</div>

<!-- 🔹 RMC Modal -->
<div class="modal" id="step2RmcModal">
  <div class="modal-content wide">
    <h2>🌱 RMC Monthly Report</h2>

    <form id="rmcForm" action="handle_add_seedling.php" method="POST">
      <input type="hidden" name="category" value="RMC-2014-01">
      <input type="hidden" id="reportMonthField" name="report_month">
      <input type="hidden" id="reportYearField" name="report_year">

      <!-- Reporting Period -->
      <label for="reportMonth"><strong>Reporting Month:</strong></label>
      <input type="month" id="reportMonth" required>

      <!-- Target for this month -->
      <label for="target"><strong>Target for this Month:</strong></label>
      <input type="number" id="target" name="rmc_total_target" value="0" min="0" required>
      <span id="targetStatus" style="margin-left:10px; font-weight:bold;"></span>

      <table class="seedling-table">
        <thead>
          <tr>
            <th>Species</th>
            <th>Previous Stock</th>
            <th>Produced</th>
            <th>Disposed</th>
            <th>Mortality</th>
            <th>Stock To Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="speciesRows">
          <tr>
            <td><input list="speciesList" type="text" name="species[0][name]" placeholder="e.g. Narra" required></td>
            <td><input type="number" name="species[0][prev]" value="0"></td>
            <td><input type="number" name="species[0][produced]" value="0"></td>
            <td><input type="number" name="species[0][disposed]" value="0"></td>
            <td><input type="number" name="species[0][mortality]" value="0"></td>
            <td><input type="text" readonly></td>
            <td><button type="button" class="remove-btn" onclick="removeRow(this)">❌</button></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th>—</th>
            <th id="totalProduced">0</th>
            <th id="totalDisposed">0</th>
            <th id="totalMortality">0</th>
            <th>—</th>
            <th>—</th>
          </tr>
        </tfoot>
      </table>

      <!-- Add Row Button -->
      <button type="button" class="add-btn" onclick="addRow()">➕ Add Species</button>
      <br><br>
      <button type="submit" class="save-btn">Save Report</button>
      <button type="button" class="close-btn" onclick="closeModal('step2RmcModal')">Cancel</button>
    </form>
  </div>
</div>

<!-- 🔹 TCP Replacement Modal -->
<div class="modal" id="step3TCPModal" style="display:none;">
  <div class="modal-content wide">
    <h2>🌿 TCP Replacement Report</h2>

    <form id="tcpForm" action="handle_add_seedling.php" method="POST">
      <input type="hidden" name="category" value="TCP Replacement">
      <input type="hidden" id="tcpReportMonthField" name="report_month">
      <input type="hidden" id="tcpReportYearField" name="report_year">

      <!-- Reporting Period -->
      <label for="tcpReportMonth"><strong>Reporting Month:</strong></label>
      <input type="month" id="tcpReportMonth" required>

      <table class="seedling-table">
        <thead>
          <tr>
            <th>Species</th>
            <th>Previous Stock</th>
            <th>Seedling Replacement Received This Month</th>
            <th>Disposed This Month</th>
            <th>Mortality This Month</th>
            <th>Stock To Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="tcpSpeciesRows">
          <tr>
            <td><input list="speciesList" type="text" name="species[0][name]" placeholder="e.g. Tuai" required></td>
            <td><input type="number" name="species[0][prev]" value="0"></td>
            <td><input type="number" name="species[0][produced]" value="0"></td>
            <td><input type="number" name="species[0][disposed]" value="0"></td>
            <td><input type="number" name="species[0][mortality]" value="0"></td>
            <td><input type="text" readonly></td>
            <td><button type="button" class="remove-btn" onclick="removeTcpRow(this)">❌</button></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th>—</th>
            <th id="tcpTotalReceived">0</th>
            <th id="tcpTotalDisposed">0</th>
            <th id="tcpTotalMortality">0</th>
            <th>—</th>
            <th>—</th>
          </tr>
        </tfoot>
      </table>

      <!-- Add Row Button -->
      <button type="button" class="add-btn" onclick="addTcpRow()">➕ Add Species</button>
      <br><br>
      <button type="submit" class="save-btn">Save Report</button>
      <button type="button" class="close-btn" onclick="closeModal('step3TCPModal')">Cancel</button>
    </form>
  </div>
</div>

<!-- 🔹 Nursery Maintenance Modal -->
<div id="step4NurseryModal" class="modal" style="display:none;">
  <div class="modal-content wide">
    <h2>🌳 Nursery Maintenance Report</h2>

    <form id="nurseryForm" action="handle_add_seedling.php" method="POST">
      <input type="hidden" name="category" value="Nursery Maintenance">
      <input type="hidden" id="nurseryReportMonthField" name="report_month">
      <input type="hidden" id="nurseryReportYearField" name="report_year">

      <!-- Reporting Period -->
      <label for="nurseryReportMonth"><strong>Reporting Month:</strong></label>
      <input type="month" id="nurseryReportMonth" required>

      <!-- Target for this month -->
      <label for="nurseryTarget"><strong>Target for this Month:</strong></label>
      <input type="number" id="nurseryTarget" name="nursery_total_target" value="0" min="0" required>
      <span id="nurseryTargetStatus" style="margin-left:10px; font-weight:bold;"></span>

      <table class="seedling-table">
        <thead>
          <tr>
            <th>Species</th>
            <th>Previous Stock</th>
            <th>Produced This Month</th>
            <th>Disposed This Month</th>
            <th>Mortality This Month</th>
            <th>Stock To Date</th>
            <th>Remarks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="nurserySpeciesRows">
          <tr>
            <td><input list="speciesList" type="text" name="species[0][name]" placeholder="e.g. Narra" required></td>
            <td><input type="number" name="species[0][prev]" value="0"></td>
            <td><input type="number" name="species[0][produced]" value="0"></td>
            <td><input type="number" name="species[0][disposed]" value="0"></td>
            <td><input type="number" name="species[0][mortality]" value="0"></td>
            <td><input type="text" readonly></td>
            <td><input type="text" name="species[0][remarks]" placeholder="Optional"></td>
            <td><button type="button" class="remove-btn" onclick="removeNurseryRow(this)">❌</button></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th>—</th>
            <th id="nurseryTotalProduced">0</th>
            <th id="nurseryTotalDisposed">0</th>
            <th id="nurseryTotalMortality">0</th>
            <th>—</th>
            <th>—</th>
            <th>—</th>
          </tr>
        </tfoot>
      </table>

      <!-- Add Row Button -->
      <button type="button" class="add-btn" onclick="addNurseryRow()">➕ Add Species</button>
      <br><br>
      <button type="submit" class="save-btn">Save Report</button>
      <button type="button" class="close-btn" onclick="closeModal('step4NurseryModal')">Cancel</button>
    </form>
  </div>
</div>

<!-- 🔹 Personnel Modal -->
<div id="personnelModal" class="modal" style="display:none;">
  <div class="modal-content wide">
    <h2>👥 Personnel Contribution Verification</h2>

    <form id="personnelForm" method="POST" action="personnel_detail.php">
      <!-- Hidden Year/Month -->
      <input type="hidden" name="report_year" id="personnelReportYearField">
      <input type="hidden" name="report_month" id="personnelReportMonthField">

      <!-- Reporting Period -->
      <label for="personnelReportMonth"><strong>Reporting Period</strong></label>
      <input type="month" id="personnelReportMonth" name="report_month_display" required>
      <button type="button" id="loadPersonnelBtn" class="add-btn">🔄 Load List</button>

      <!-- Staff contribution list (auto-refreshes here) -->
      <div id="personnelList" style="margin-top:20px; max-height:300px; overflow-y:auto;">
        <p style="color:gray;">Select a month/year and click "Load List" to see contributions.</p>
      </div>

      <!-- Actions -->
      <div class="form-actions">
        <button type="submit" class="save-btn">Verify Personnel</button>
        <button type="button" class="close-btn" onclick="closeModal('personnelModal')">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- 🔹 Personnel Detail Modal -->
<div id="personnelDetailModal" class="modal" style="display:none;">
  <div class="modal-content wide">
    <h2>👤 Personnel Contribution Details</h2>
    <div id="personnelDetailContent">
      <p style="color:gray;">Loading...</p>
    </div>
    <button type="button" class="close-btn" onclick="closeModal('personnelDetailModal')">Close</button>
  </div>
</div>





<style>
.category-options {
  display: flex;
  justify-content: space-around;
  margin: 20px 0;
  gap: 15px;
  flex-wrap: wrap;
}
.category-btn {
  background: #2e7d32;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
  transition: 0.2s ease;
}
.category-btn:hover {
  background: #1b5e20;
}
.close-btn {
  background: #ccc;
  color: #333;
  padding: 8px 14px;
  border: none;
  border-radius: 4px;
  margin-top: 15px;
  cursor: pointer;
}
.close-btn:hover {
  background: #999;
}

/* 🔹 Base Modal Style */
.modal {
  display: none;
  position: fixed;
  z-index: 1000; /* stays on top */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background: rgba(0,0,0,0.5); /* dark overlay */
  justify-content: center;
  align-items: center;
}

/* 🔹 Modal Content */
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 90%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.modal-content.wide {
  max-width: 900px;
  width: 95%;
}

.seedling-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}
.seedling-table th, .seedling-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}
.add-btn, .save-btn {
  background: #2e7d32;
  color: #fff;
  border: none;
  padding: 10px 15px;
  margin-top: 10px;
  border-radius: 6px;
  cursor: pointer;
}
.add-btn:hover, .save-btn:hover {
  background: #1b5e20;
}
.remove-btn {
  background: #e53935;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}
.remove-btn:hover {
  background: #b71c1c;
}

</style>

<script>
let globalRowId = 0; // shared counter across all forms

// 🔹 Utility: create input with datalist for species
function speciesInput(name) {
  return `<input list="speciesList" type="text" name="${name}[name]" placeholder="Species" required>`;
}

// 🔹 Utility: reset tbody for a given modal
function resetTbody(tbodyId, defaultRowHtml) {
  const tbody = document.getElementById(tbodyId);
  tbody.innerHTML = defaultRowHtml;
}

// ========== RMC ==========
function addRow() {
  let tbody = document.getElementById("speciesRows");
  let id = globalRowId++;
  let newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${speciesInput(`species[${id}]`)}</td>
    <td><input type="number" name="species[${id}][prev]" value="0"></td>
    <td><input type="number" name="species[${id}][produced]" value="0"></td>
    <td><input type="number" name="species[${id}][disposed]" value="0"></td>
    <td><input type="number" name="species[${id}][mortality]" value="0"></td>
    <td><input type="text" readonly></td>
    <td><button type="button" class="remove-btn" onclick="removeRow(this)">❌</button></td>`;
  tbody.appendChild(newRow);
  updateCalculations();
}
function removeRow(btn) {
  btn.closest("tr").remove();
  updateCalculations();
}
function updateCalculations() {
  let totalProduced = 0, totalDisposed = 0, totalMortality = 0;
  document.querySelectorAll("#speciesRows tr").forEach(row => {
    let prev = +row.querySelector("input[name*='[prev]']").value || 0;
    let produced = +row.querySelector("input[name*='[produced]']").value || 0;
    let disposed = +row.querySelector("input[name*='[disposed]']").value || 0;
    let mortality = +row.querySelector("input[name*='[mortality]']").value || 0;
    row.querySelector("td:nth-child(6) input").value = prev + produced - disposed - mortality;
    totalProduced += produced; totalDisposed += disposed; totalMortality += mortality;
  });
  document.getElementById("totalProduced").innerText = totalProduced;
  document.getElementById("totalDisposed").innerText = totalDisposed;
  document.getElementById("totalMortality").innerText = totalMortality;

  let target = +document.getElementById("target").value || 0;
  let statusEl = document.getElementById("targetStatus");
  statusEl.innerText = target > 0
    ? (totalProduced >= target ? "✅ Target Met" : "⚠️ Target Not Met")
    : "";
  statusEl.style.color = totalProduced >= target ? "green" : "red";
}
document.getElementById("rmcForm").addEventListener("submit", e => {
  const monthInput = document.getElementById("reportMonth").value;
  if (monthInput) {
    let [year, month] = monthInput.split("-");
    document.getElementById("reportYearField").value = year;
    document.getElementById("reportMonthField").value = month;
  }
});

// ========== TCP ==========
function addTcpRow() {
  let tbody = document.getElementById("tcpSpeciesRows");
  let id = globalRowId++;
  let newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${speciesInput(`species[${id}]`)}</td>
    <td><input type="number" name="species[${id}][prev]" value="0"></td>
    <td><input type="number" name="species[${id}][received]" value="0"></td>
    <td><input type="number" name="species[${id}][disposed]" value="0"></td>
    <td><input type="number" name="species[${id}][mortality]" value="0"></td>
    <td><input type="text" readonly></td>
    <td><button type="button" class="remove-btn" onclick="removeTcpRow(this)">❌</button></td>`;
  tbody.appendChild(newRow);
  updateTcpCalculations();
}
function removeTcpRow(btn) { btn.closest("tr").remove(); updateTcpCalculations(); }
function updateTcpCalculations() {
  let totalReceived = 0, totalDisposed = 0, totalMortality = 0;
  document.querySelectorAll("#tcpSpeciesRows tr").forEach(row => {
    let prev = +row.querySelector("input[name*='[prev]']").value || 0;
    let received = +row.querySelector("input[name*='[received]']").value || 0;
    let disposed = +row.querySelector("input[name*='[disposed]']").value || 0;
    let mortality = +row.querySelector("input[name*='[mortality]']").value || 0;
    row.querySelector("td:nth-child(6) input").value = prev + received - disposed - mortality;
    totalReceived += received; totalDisposed += disposed; totalMortality += mortality;
  });
  document.getElementById("tcpTotalReceived").innerText = totalReceived;
  document.getElementById("tcpTotalDisposed").innerText = totalDisposed;
  document.getElementById("tcpTotalMortality").innerText = totalMortality;
}
document.getElementById("tcpForm").addEventListener("submit", e => {
  const monthInput = document.getElementById("tcpReportMonth").value;
  if (monthInput) {
    let [year, month] = monthInput.split("-");
    document.getElementById("tcpReportYearField").value = year;
    document.getElementById("tcpReportMonthField").value = month;
  }
});

// ========== Nursery ==========
function addNurseryRow() {
  let tbody = document.getElementById("nurserySpeciesRows");
  let id = globalRowId++;
  let newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${speciesInput(`species[${id}]`)}</td>
    <td><input type="number" name="species[${id}][prev]" value="0"></td>
    <td><input type="number" name="species[${id}][produced]" value="0"></td>
    <td><input type="number" name="species[${id}][disposed]" value="0"></td>
    <td><input type="number" name="species[${id}][mortality]" value="0"></td>
    <td><input type="text" readonly></td>
    <td><input type="text" name="species[${id}][remarks]" placeholder="Optional"></td>
    <td><button type="button" class="remove-btn" onclick="removeNurseryRow(this)">❌</button></td>`;
  tbody.appendChild(newRow);
  updateNurseryCalculations();
}
function removeNurseryRow(btn) { btn.closest("tr").remove(); updateNurseryCalculations(); }
function updateNurseryCalculations() {
  let totalProduced = 0, totalDisposed = 0, totalMortality = 0;
  document.querySelectorAll("#nurserySpeciesRows tr").forEach(row => {
    let prev = +row.querySelector("input[name*='[prev]']").value || 0;
    let produced = +row.querySelector("input[name*='[produced]']").value || 0;
    let disposed = +row.querySelector("input[name*='[disposed]']").value || 0;
    let mortality = +row.querySelector("input[name*='[mortality]']").value || 0;
    row.querySelector("td:nth-child(6) input").value = prev + produced - disposed - mortality;
    totalProduced += produced; totalDisposed += disposed; totalMortality += mortality;
  });
  document.getElementById("nurseryTotalProduced").innerText = totalProduced;
  document.getElementById("nurseryTotalDisposed").innerText = totalDisposed;
  document.getElementById("nurseryTotalMortality").innerText = totalMortality;

  let target = +document.getElementById("nurseryTarget").value || 0;
  let statusEl = document.getElementById("nurseryTargetStatus");
  statusEl.innerText = target > 0
    ? (totalProduced >= target ? "✅ Target Met" : "⚠️ Target Not Met")
    : "";
  statusEl.style.color = totalProduced >= target ? "green" : "red";
}
document.getElementById("nurseryForm").addEventListener("submit", e => {
  const monthInput = document.getElementById("nurseryReportMonth").value;
  if (monthInput) {
    let [year, month] = monthInput.split("-");
    document.getElementById("nurseryReportYearField").value = year;
    document.getElementById("nurseryReportMonthField").value = month;
  }
});

// ========== Personnel ==========
document.getElementById("personnelForm").addEventListener("submit", e => {
  const monthInput = document.getElementById("personnelReportMonth").value;
  if (monthInput) {
    let [year, month] = monthInput.split("-");
    document.getElementById("personnelReportYearField").value = year;
    document.getElementById("personnelReportMonthField").value = month;
  }
});

// 🔹 Reset function for modals
function resetRmcRows() {
  globalRowId++;
  document.getElementById("speciesRows").innerHTML = `
    <tr>
      <td>${speciesInput(`species[${globalRowId}]`)}</td>
      <td><input type="number" name="species[${globalRowId}][prev]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][produced]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][disposed]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][mortality]" value="0"></td>
      <td><input type="text" readonly></td>
      <td><button type="button" class="remove-btn" onclick="removeRow(this)">❌</button></td>
    </tr>`;
  updateCalculations();
}
function resetTcpRows() {
  globalRowId++;
  document.getElementById("tcpSpeciesRows").innerHTML = `
    <tr>
      <td>${speciesInput(`species[${globalRowId}]`)}</td>
      <td><input type="number" name="species[${globalRowId}][prev]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][received]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][disposed]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][mortality]" value="0"></td>
      <td><input type="text" readonly></td>
      <td><button type="button" class="remove-btn" onclick="removeTcpRow(this)">❌</button></td>
    </tr>`;
  updateTcpCalculations();
}
function resetNurseryRows() {
  globalRowId++;
  document.getElementById("nurserySpeciesRows").innerHTML = `
    <tr>
      <td>${speciesInput(`species[${globalRowId}]`)}</td>
      <td><input type="number" name="species[${globalRowId}][prev]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][produced]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][disposed]" value="0"></td>
      <td><input type="number" name="species[${globalRowId}][mortality]" value="0"></td>
      <td><input type="text" readonly></td>
      <td><input type="text" name="species[${globalRowId}][remarks]" placeholder="Optional"></td>
      <td><button type="button" class="remove-btn" onclick="removeNurseryRow(this)">❌</button></td>
    </tr>`;
  updateNurseryCalculations();
}

document.getElementById("step2RmcModal")?.addEventListener("show.bs.modal", resetRmcRows);
document.getElementById("step3TCPModal")?.addEventListener("show.bs.modal", resetTcpRows);
document.getElementById("step4NurseryModal")?.addEventListener("show.bs.modal", resetNurseryRows);


// 🔹 Personnel Fix
// Example roles for dropdown
document.addEventListener("DOMContentLoaded", () => {
  const personnelSelect = document.getElementById("personnelRole");
  if (personnelSelect && personnelSelect.options.length === 0) {
    ["Leader", "Assistant", "Staff"].forEach(role => {
      let opt = document.createElement("option");
      opt.value = role;
      opt.textContent = role;
      personnelSelect.appendChild(opt);
    });
  }
});

// ========== Personnel ==========

// Auto-split report period into year + month before submit
document.getElementById("personnelForm").addEventListener("submit", e => {
  const monthInput = document.getElementById("personnelReportMonth").value;
  if (monthInput) {
    let [year, month] = monthInput.split("-");
    document.getElementById("personnelReportYearField").value = year;
    document.getElementById("personnelReportMonthField").value = month;
  }
});

// 🔹 Load Personnel Contributions
document.getElementById("loadPersonnelBtn").addEventListener("click", () => {
  const monthInput = document.getElementById("personnelReportMonth").value;
  if (!monthInput) {
    alert("Please select a reporting period first.");
    return;
  }

  let [year, month] = monthInput.split("-");
  document.getElementById("personnelReportYearField").value = year;
  document.getElementById("personnelReportMonthField").value = month;

  // AJAX call to fetch personnel data
  fetch(`fetch_personnel.php?year=${year}&month=${month}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById("personnelList").innerHTML = html;
    })
    .catch(err => {
      document.getElementById("personnelList").innerHTML =
        `<p style="color:red;">⚠️ Error loading personnel list.</p>`;
      console.error(err);
    });
});

// 🔹 Show Personnel Detail in modal
function showPersonnelDetail(id) {
  document.getElementById("personnelDetailModal").style.display = "flex";
  document.getElementById("personnelDetailContent").innerHTML = "<p>Loading...</p>";

  fetch(`personnel_detail.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById("personnelDetailContent").innerHTML = html;
    })
    .catch(err => {
      document.getElementById("personnelDetailContent").innerHTML =
        `<p style="color:red;">⚠️ Error loading details.</p>`;
      console.error(err);
    });
}

function verifyContribution(staffId) {
  if (!confirm("Are you sure you want to verify this staff's contribution?")) return;

  fetch('verify_contribution.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'staff_id=' + staffId
  })
  .then(res => res.text())
  .then(data => {
    if (data.trim() === 'success') {
      alert("Contribution verified successfully ✅");
      // Reload the details to show updated status
      showPersonnelDetail(staffId);
    } else {
      alert("❌ Verification failed: " + data);
    }
  });
}


</script>

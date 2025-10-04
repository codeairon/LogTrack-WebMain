<div id="addSeedlingModal" class="modal" style="display:none">
  <div class="modal-content">
    <span class="close" onclick="closeSeedlingModal()">&times;</span>
    <h2 style="color:#2e7d32">Add Seedling Inventory</h2>

    <form action="handle_add_seedling.php" method="POST">
      <!-- CATEGORY SELECTOR -->
      <label><strong>Category:</strong></label>
      <select name="category" required>
        <option value="">-- Select Category --</option>
        <option value="RMC-2014-01">RMC-2014-01</option>
        <option value="TCP Replacement">TCP Replacement</option>
        <option value="Nursery Maintenance">Nursery Maintenance</option>
      </select>

      <div style="display: flex; gap: 20px; margin-bottom: 20px;">
  <div>
    <label><strong>Report Month:</strong></label>
    <select name="report_month" required>
      <?php for ($m = 1; $m <= 12; $m++): ?>
        <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div>
    <label><strong>Report Year:</strong></label>
    <select name="report_year" required>
      <?php for ($y = date('Y') + 1; $y >= 2020; $y--): ?>
        <option value="<?= $y ?>"><?= $y ?></option>
      <?php endfor; ?>
    </select>
  </div>
</div>

      <!-- Seedling Entry Table -->
      <table id="seedlingTable">
        <thead>
          <tr>
            <th>Species</th>
            <th>Target</th>
            <th>Previous Stock</th>
            <th>Produced</th>
            <th>Received</th>
            <th>Disposed</th>
            <th>Mortality</th>
            <th>Remarks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="seedlingRows">
          <tr>
            <td><input name="species[]" required></td>
            <td><input name="target[]" type="number" value="0"></td>
            <td><input name="previous_stock[]" type="number" value="0"></td>
            <td><input name="produced[]" type="number" value="0"></td>
            <td><input name="received[]" type="number" value="0"></td>
            <td><input name="disposed[]" type="number" value="0"></td>
            <td><input name="mortality[]" type="number" value="0"></td>
            <td><input name="remarks[]"></td>
            <td><button type="button" onclick="removeRow(this)">🗑️</button></td>
          </tr>
        </tbody>
      </table>

      <button type="button" onclick="addSeedlingRow()">➕ Add Row</button>
      <br><br>
      <button type="submit" class="btn-save">💾 Save Records</button>
    </form>
  </div>
</div>

<style>
.modal {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.4); display: none;
  align-items: center; justify-content: center; z-index: 3500;
}
.modal-content {
  background: #fff; padding: 30px; width: 90%; max-width: 1100px;
  border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  max-height: 90vh; overflow-y: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}
th, td {
  border: 1px solid #ccc;
  padding: 8px;
}
input, textarea, select {
  width: 100%;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.btn-save {
  background: #2e7d32;
  color: white;
  padding: 10px 16px;
  border: none;
  border-radius: 4px;
}
.close {
  float: right; font-size: 24px; font-weight: bold; cursor: pointer;
}
</style>

<script>
function openSeedlingModal() {
  document.getElementById('addSeedlingModal').style.display = 'flex';
}
function closeSeedlingModal() {
  document.getElementById('addSeedlingModal').style.display = 'none';
}
function addSeedlingRow() {
  const row = `
    <tr>
      <td><input name="species[]" required></td>
      <td><input name="target[]" type="number" value="0"></td>
      <td><input name="previous_stock[]" type="number" value="0"></td>
      <td><input name="produced[]" type="number" value="0"></td>
      <td><input name="received[]" type="number" value="0"></td>
      <td><input name="disposed[]" type="number" value="0"></td>
      <td><input name="mortality[]" type="number" value="0"></td>
      <td><input name="remarks[]"></td>
      <td><button type="button" onclick="removeRow(this)">🗑️</button></td>
    </tr>`;
  document.getElementById('seedlingRows').insertAdjacentHTML('beforeend', row);
}
function removeRow(btn) {
  btn.closest('tr').remove();
}
</script>

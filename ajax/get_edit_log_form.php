<?php
/* /ajax/get_edit_log_form.php */
session_start();
require_once('../db_connect.php');
if (!isset($_SESSION['login_id'])) { http_response_code(403); exit; }

$id = intval($_GET['id'] ?? 0);
$log = $conn->query("SELECT * FROM apprehended_logs WHERE id=$id")->fetch_assoc();
if(!$log){ echo 'Log not found'; exit; }

/* fetch child-tables so we can render rows */
$fp  = $conn->query("SELECT * FROM log_forest_products WHERE log_id=$id");
$cv  = $conn->query("SELECT * FROM log_conveyance      WHERE log_id=$id");
$eq  = $conn->query("SELECT * FROM log_equipment       WHERE log_id=$id");

/* also fetch dropdown data */
$districts = $conn->query("SELECT * FROM districts ORDER BY name");
$offense_categories = $conn->query("SELECT * FROM offense_categories ORDER BY name");

/* Get current municipality + barangay + offense type names */
$municipality_name = '';
$barangay_name = '';
$offense_type_name = '';

if ($log['municipality_id']) {
  $res = $conn->query("SELECT name FROM municipalities WHERE id=".$log['municipality_id']);
  if ($row = $res->fetch_assoc()) $municipality_name = $row['name'];
}

if ($log['barangay_id']) {
  $res = $conn->query("SELECT name FROM barangays WHERE id=".$log['barangay_id']);
  if ($row = $res->fetch_assoc()) $barangay_name = $row['name'];
}

if ($log['offense_type_id']) {
  $res = $conn->query("SELECT name FROM offense_types WHERE id=".$log['offense_type_id']);
  if ($row = $res->fetch_assoc()) $offense_type_name = $row['name'];
}

?>
<!-- ===== EDIT MODAL ===== -->
<div id="editLogModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditModal()">&times;</span>
    <h2 style="color:#2e7d32">Edit Apprehension Log – #<?= $id ?></h2>

    <form id="editLogForm">
      <input type="hidden" name="id" value="<?= $id ?>">

      <!-- ——— Header fields ——— -->
      <label>Date & Time of Apprehension:</label>
      <input type="datetime-local" name="date_time"
             value="<?= date('Y-m-d\TH:i',strtotime($log['date_time'])) ?>" required>

      <!-- Location -->
      <label>District:</label>
      <select name="district_id" id="editDistrict" required>
        <option value="">-- Select District --</option>
        <?php while($d=$districts->fetch_assoc()): ?>
          <option value="<?= $d['id'] ?>" <?= $d['id']==$log['district_id']?'selected':'' ?>>
            <?= htmlspecialchars($d['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>

<label>Municipality:</label>
<select name="municipality_id" id="editMunicipality" data-selected="<?= $log['municipality_id'] ?>" required>
  <option value="">-- Select Municipality --</option>
  <?php
    if ($log['district_id']) {
      $munis = $conn->query("SELECT * FROM municipalities WHERE district_id=".$log['district_id']." ORDER BY name");
      while($m = $munis->fetch_assoc()):
  ?>
    <option value="<?= $m['id'] ?>" <?= $m['id']==$log['municipality_id']?'selected':'' ?>>
      <?= htmlspecialchars($m['name']) ?>
    </option>
  <?php endwhile; } ?>
</select>
<label>Barangay:</label>
<select name="barangay_id" id="editBarangay" data-selected="<?= $log['barangay_id'] ?>" required>
  <option value="">-- Select Barangay --</option>
  <?php
    if ($log['municipality_id']) {
      $brgys = $conn->query("SELECT * FROM barangays WHERE municipality_id=".$log['municipality_id']." ORDER BY name");
      while($b = $brgys->fetch_assoc()):
  ?>
    <option value="<?= $b['id'] ?>" <?= $b['id']==$log['barangay_id']?'selected':'' ?>>
      <?= htmlspecialchars($b['name']) ?>
    </option>
  <?php endwhile; } ?>
</select>


      <!-- Offense -->
      <label>Offense Category:</label>
      <select name="offense_category_id" id="editOffenseCategory">
        <option value="">-- Select Category --</option>
        <?php while($oc=$offense_categories->fetch_assoc()): ?>
          <option value="<?= $oc['id'] ?>" <?= $oc['id']==$log['offense_category_id']?'selected':'' ?>>
            <?= htmlspecialchars($oc['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>

<label>Offense Type:</label>
<select name="offense_type_id" id="editOffenseType" data-selected="<?= $log['offense_type_id'] ?>">
  <option value="">-- Select Offense --</option>
  <?php
    if ($log['offense_category_id']) {
      $types = $conn->query("SELECT * FROM offense_types WHERE category_id=".$log['offense_category_id']." ORDER BY name");
      while($t = $types->fetch_assoc()):
  ?>
    <option value="<?= $t['id'] ?>" <?= $t['id']==$log['offense_type_id']?'selected':'' ?>>
      <?= htmlspecialchars($t['name']) ?>
    </option>
  <?php endwhile; } ?>
</select>
      <label>Custom Offense (if not in list):</label>
      <input type="text" name="offense_custom" value="<?= htmlspecialchars($log['offense_custom']) ?>">

      <label>Remarks:</label>
      <textarea name="remarks"><?= htmlspecialchars($log['remarks']) ?></textarea>

      <label>Case Status:</label>
      <select name="status">
        <option value="Active" <?= $log['status']=='Active'?'selected':'' ?>>Active</option>
        <option value="Closed" <?= $log['status']=='Closed'?'selected':'' ?>>Closed</option>
      </select>

      <!-- ——— A. Forest Products ——— -->
      <h4>A. Forest Products</h4>
      <table id="forestTable">
        <tr>
          <th>Species Form</th><th>Species Custom</th><th>Form</th><th>Form Custom</th>
          <th>Size</th><th>Size Custom</th><th>No. of Pieces</th><th>Volume</th>
          <th>Value</th><th>Origin</th><th>Owner</th>
        </tr>
        <?php if($fp->num_rows): ?>
          <?php while($r=$fp->fetch_assoc()): ?>
          <tr>
            <td><input name="species_form[]" value="<?= htmlspecialchars($r['species_form']) ?>"></td>
            <td><input name="species_custom[]" value="<?= htmlspecialchars($r['species_custom']) ?>"></td>
            <td><input name="form[]" value="<?= htmlspecialchars($r['form']) ?>"></td>
            <td><input name="form_custom[]" value="<?= htmlspecialchars($r['form_custom']) ?>"></td>
            <td><input name="size[]" value="<?= htmlspecialchars($r['size']) ?>"></td>
            <td><input name="size_custom[]" value="<?= htmlspecialchars($r['size_custom']) ?>"></td>
            <td><input name="pieces[]" type="number" value="<?= $r['no_of_pieces'] ?>"></td>
            <td><input name="volume[]" type="number" step="0.01" value="<?= $r['volume'] ?>"></td>
            <td><input name="value[]" type="number" step="0.01" value="<?= $r['estimated_value'] ?>"></td>
            <td><input name="origin[]" value="<?= htmlspecialchars($r['origin']) ?>"></td>
            <td><input name="owner[]" value="<?= htmlspecialchars($r['owner_info']) ?>"></td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td><input name="species_form[]"></td>
            <td><input name="species_custom[]"></td>
            <td><input name="form[]"></td>
            <td><input name="form_custom[]"></td>
            <td><input name="size[]"></td>
            <td><input name="size_custom[]"></td>
            <td><input name="pieces[]" type="number"></td>
            <td><input name="volume[]" type="number" step="0.01"></td>
            <td><input name="value[]" type="number" step="0.01"></td>
            <td><input name="origin[]"></td>
            <td><input name="owner[]"></td>
          </tr>
        <?php endif; ?>
      </table>
      <button type="button" class="add-row" onclick="addRow('forest')">➕ Add Row</button>

      <!-- ——— B. Conveyance ——— -->
      <h4>B. Conveyance</h4>
      <table id="conveyanceTable">
        <tr><th>Kind</th><th>Plate No.</th><th>Engine/Chassis</th><th>Value</th><th>Driver/Owner</th></tr>
        <?php if($cv->num_rows): ?>
          <?php while($r=$cv->fetch_assoc()): ?>
          <tr>
            <td><input name="kind[]" value="<?= htmlspecialchars($r['kind']) ?>"></td>
            <td><input name="plate[]" value="<?= htmlspecialchars($r['plate_no']) ?>"></td>
            <td><input name="engine[]" value="<?= htmlspecialchars($r['engine_chassis_no']) ?>"></td>
            <td><input name="vehicle_value[]" type="number" step="0.01" value="<?= $r['estimated_value'] ?>"></td>
            <td><input name="driver[]" value="<?= htmlspecialchars($r['driver_owner_info']) ?>"></td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td><input name="kind[]"></td>
            <td><input name="plate[]"></td>
            <td><input name="engine[]"></td>
            <td><input name="vehicle_value[]" type="number" step="0.01"></td>
            <td><input name="driver[]"></td>
          </tr>
        <?php endif; ?>
      </table>
      <button type="button" class="add-row" onclick="addRow('conveyance')">➕ Add Row</button>

      <!-- ——— C. Equipment ——— -->
      <h4>C. Equipment</h4>
      <table id="equipmentTable">
        <tr><th>Details</th><th>Features</th><th>Value</th><th>Owner Info</th></tr>
        <?php if($eq->num_rows): ?>
          <?php while($r=$eq->fetch_assoc()): ?>
          <tr>
            <td><input name="equipment[]" value="<?= htmlspecialchars($r['equipment_details']) ?>"></td>
            <td><input name="equipment_features[]" value="<?= htmlspecialchars($r['features']) ?>"></td>
            <td><input name="equipment_value[]" type="number" step="0.01" value="<?= $r['estimated_value'] ?>"></td>
           <td><input name="equipment_owner[]" value="<?= htmlspecialchars($r['owner_address']) ?>"></td>

          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td><input name="equipment[]"></td>
            <td><input name="equipment_features[]"></td>
            <td><input name="equipment_value[]" type="number" step="0.01"></td>
            <td><input name="equipment_owner[]"></td>
          </tr>
        <?php endif; ?>
      </table>
      <button type="button" class="add-row" onclick="addRow('equipment')">➕ Add Row</button>

      <!-- ——— Signatures ——— -->
      <h4>Signatures</h4>
      <label>Apprehending Officer:</label>
      <input name="officer" value="<?= htmlspecialchars($log['officer_name']) ?>" required>

      <label>Witness:</label>
      <input name="witness" value="<?= htmlspecialchars($log['witness_name']) ?>">

      <label>Date Issued:</label>
      <input name="issue_date" type="date" value="<?= $log['issue_date'] ?>">

      <label>Conform by:</label>
      <input name="conform" value="<?= htmlspecialchars($log['conform_by']) ?>">

      <br><br>
      <button type="submit" class="btn-save">💾 Save Changes</button>
    </form>
  </div>
</div>

<script>
/* Add row handlers */
function addRow(type){
  let html='';
  if(type==='forest'){
    html=`<tr>
       <td><input name="species_form[]"></td>
       <td><input name="species_custom[]"></td>
       <td><input name="form[]"></td>
       <td><input name="form_custom[]"></td>
       <td><input name="size[]"></td>
       <td><input name="size_custom[]"></td>
       <td><input name="pieces[]" type="number"></td>
       <td><input name="volume[]" type="number" step="0.01"></td>
       <td><input name="value[]" type="number" step="0.01"></td>
       <td><input name="origin[]"></td>
       <td><input name="owner[]"></td></tr>`;
    document.getElementById('forestTable').insertAdjacentHTML('beforeend', html);
  }
  else if(type==='conveyance'){
    html=`<tr>
       <td><input name="kind[]"></td>
       <td><input name="plate[]"></td>
       <td><input name="engine[]"></td>
       <td><input name="vehicle_value[]" type="number" step="0.01"></td>
       <td><input name="driver[]"></td></tr>`;
    document.getElementById('conveyanceTable').insertAdjacentHTML('beforeend', html);
  }
  else if(type==='equipment'){
    html=`<tr>
       <td><input name="equipment[]"></td>
       <td><input name="equipment_features[]"></td>
       <td><input name="equipment_value[]" type="number" step="0.01"></td>
       <td><input name="equipment_owner[]"></td></tr>`;
    document.getElementById('equipmentTable').insertAdjacentHTML('beforeend', html);
  }
}

function addRow(type){
  let html='';
  if(type==='forest'){
    html=`<tr>
       <td><input name="species_form[]"></td>
       <td><input name="species_custom[]"></td>
       <td><input name="form[]"></td>
       <td><input name="form_custom[]"></td>
       <td><input name="size[]"></td>
       <td><input name="size_custom[]"></td>
       <td><input name="pieces[]" type="number"></td>
       <td><input name="volume[]" type="number" step="0.01"></td>
       <td><input name="value[]" type="number" step="0.01"></td>
       <td><input name="origin[]"></td>
       <td><input name="owner[]"></td></tr>`;
    document.getElementById('forestTable').insertAdjacentHTML('beforeend', html);
  }
  else if(type==='conveyance'){
    html=`<tr>
       <td><input name="kind[]"></td>
       <td><input name="plate[]"></td>
       <td><input name="engine[]"></td>
       <td><input name="vehicle_value[]" type="number" step="0.01"></td>
       <td><input name="driver[]"></td></tr>`;
    document.getElementById('conveyanceTable').insertAdjacentHTML('beforeend', html);
  }
  else if(type==='equipment'){
    html=`<tr>
       <td><input name="equipment[]"></td>
       <td><input name="equipment_features[]"></td>
       <td><input name="equipment_value[]" type="number" step="0.01"></td>
       <td><input name="equipment_owner[]"></td></tr>`;
    document.getElementById('equipmentTable').insertAdjacentHTML('beforeend', html);
  }
}
// ---- AJAX for dependent dropdowns ----
document.addEventListener("DOMContentLoaded", function() {
  const districtSel = document.getElementById('editDistrict');
  const municipalitySel = document.getElementById('editMunicipality');
  const barangaySel = document.getElementById('editBarangay');
  const offenseCatSel = document.getElementById('editOffenseCategory');
  const offenseTypeSel = document.getElementById('editOffenseType');

  // ---- Load Districts ----
  function loadDistricts(selectedId = null) {
    fetch(`../ajax/get_districts.php`)
      .then(res => res.json())
      .then(data => {
        districtSel.innerHTML = "<option value=''>-- Select District --</option>";
        data.forEach(d => {
          districtSel.innerHTML += `<option value="${d.id}">${d.name}</option>`;
        });
        if (selectedId) {
          districtSel.value = selectedId;
          districtSel.dispatchEvent(new Event("change")); // cascade
        }
      });
  }

  // ---- Load Municipalities ----
  function loadMunicipalities(districtId, selectedId = null) {
    municipalitySel.innerHTML = "<option value=''>-- Select Municipality --</option>";
    barangaySel.innerHTML = "<option value=''>-- Select Barangay --</option>";
    municipalitySel.disabled = true;
    barangaySel.disabled = true;

    if (districtId) {
      fetch(`../ajax/get_municipalities.php?district_id=${districtId}`)
        .then(res => res.json())
        .then(data => {
          municipalitySel.disabled = false;
          data.forEach(m => {
            municipalitySel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
          });
          if (selectedId) {
            municipalitySel.value = selectedId;
            municipalitySel.dispatchEvent(new Event("change"));
          }
        });
    }
  }

  // ---- Load Barangays ----
  function loadBarangays(muniId, selectedId = null) {
    barangaySel.innerHTML = "<option value=''>-- Select Barangay --</option>";
    barangaySel.disabled = true;

    if (muniId) {
      fetch(`../ajax/get_barangays.php?municipality_id=${muniId}`)
        .then(res => res.json())
        .then(data => {
          barangaySel.disabled = false;
          data.forEach(b => {
            barangaySel.innerHTML += `<option value="${b.id}">${b.name}</option>`;
          });
          if (selectedId) {
            barangaySel.value = selectedId;
          }
        });
    }
  }

  // ---- Load Offense Types ----
  function loadOffenseTypes(catId, selectedId = null) {
    offenseTypeSel.innerHTML = "<option value=''>-- Select Offense --</option>";
    offenseTypeSel.disabled = true;

    if (catId) {
      fetch(`../ajax/get_offense_types.php?category_id=${catId}`)
        .then(res => res.json())
        .then(data => {
          offenseTypeSel.disabled = false;
          data.forEach(off => {
            offenseTypeSel.innerHTML += `<option value="${off.id}">${off.name}</option>`;
          });
          if (selectedId) {
            offenseTypeSel.value = selectedId;
          }
        });
    }
  }

  // ---- Attach listeners ----
  districtSel.addEventListener("change", () => {
    loadMunicipalities(districtSel.value, municipalitySel.dataset.selected);
  });
  municipalitySel.addEventListener("change", () => {
    loadBarangays(municipalitySel.value, barangaySel.dataset.selected);
  });
  offenseCatSel.addEventListener("change", () => {
    loadOffenseTypes(offenseCatSel.value, offenseTypeSel.dataset.selected);
  });

  // ---- Initial refresh ----
  loadDistricts(districtSel.dataset.selected);
  if (offenseCatSel.value) {
    loadOffenseTypes(offenseCatSel.value, offenseTypeSel.dataset.selected);
  }
});
</script>

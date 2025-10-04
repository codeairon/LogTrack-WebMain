<!-- === Modal HTML === -->
<div id="addLogModal" class="modal" style="display:none">
  <div class="modal-content">
    <span class="close" onclick="closeAddModal()">&times;</span>
    <h2 style="color:#2e7d32">Add Apprehension Log</h2>

    <form method="POST" action="handle_add_log.php" id="addForm">

      <!-- Date & Time -->
      <label>Date & Time of Apprehension:</label>
      <input type="datetime-local" name="date_time" required>

      <!-- Place of Apprehension -->
      <label>Place of Apprehension:</label>
      <div class="place-fields">
        <select id="district" name="district_id" required>
          <option value="">-- Select District --</option>
          <option value="1">1st District</option>
          <option value="2">2nd District</option>
          <option value="3">3rd District</option>
          <option value="4">4th District</option>
          <option value="5">5th District</option>
          <option value="6">6th District</option>
        </select>

        <select id="municipality" name="municipality_id" required disabled>
          <option value="">-- Select Municipality --</option>
        </select>

        <select id="barangay" name="barangay_id" required disabled>
          <option value="">-- Select Barangay --</option>
        </select>
      </div>

      <!-- Offense Section -->
      <label>Nature of Offense / Violation:</label>
      <div class="offense-fields">
        <select id="offenseCategory" name="offense_category_id">
          <option value="">-- Select Category --</option>
          <option value="1">PD 705 – Revised Forestry Code</option>
          <option value="2">RA 9175 – Chainsaw Act</option>
          <option value="3">Protected Areas & Wildlife</option>
          <option value="4">Community-Based & Sustainable Forestry</option>
          <option value="5">Indigenous Rights</option>
          <option value="6">Environmental Overlaps</option>
        </select>

        <select id="offenseDetail" name="offense_type_id" disabled>
          <option value="">-- Select Offense --</option>
        </select>

        <input type="text" name="offense_custom" id="offenseInput" placeholder="Other / Custom offense">
      </div>

      <!-- Remarks -->
      <label>Remarks:</label>
      <textarea name="remarks"></textarea>

      <!-- Forest Products -->
      <h4>A. Forest Products</h4>
<table id="forestTable">
  <tr>
    <th>Species & Form</th>
    <th>No. of Pieces</th>
    <th>Volume</th>
    <th>Value</th>
    <th>Origin</th>
    <th>Name/address of Owner & Offenders</th>
  </tr>
  <tr>
  <td>
    <!-- Species -->
    <select name="species_form[]" class="speciesSelect" onchange="toggleCustomSpecies(this)">
      <option value="">-- Select Species --</option>
      <option value="Narra">Narra</option>
      <option value="Molave">Molave</option>
      <option value="Dao">Dao</option>
      <option value="Kamagong">Kamagong</option>
      <option value="Ipil">Ipil</option>
      <option value="Akle">Akle</option>
      <option value="Apanit">Apanit</option>
      <option value="Banuyo">Banuyo</option>
      <option value="Ebony">Ebony</option>
      <option value="Kalantas">Kalantas</option>
      <option value="Supa">Supa</option>
      <option value="Batikuling">Batikuling</option>
      <option value="Betis">Betis</option>
      <option value="Bolong-eta">Bolong-eta</option>
      <option value="Teak">Teak</option>
      <option value="Tindalo">Tindalo</option>
      <option value="Manggis">Manggis</option>
      <option value="Almaciga">Almaciga</option>
      <option value="Lanete">Lanete</option>
      <option value="Lambayao">Lambayao</option>
      <option value="Sangilo">Sangilo</option>
      <option value="Other">Other (Specify)</option>
    </select>
    <input type="text" name="species_custom[]" class="customSpecies" 
           placeholder="Specify other species" style="display:none;margin-top:6px;">

    <!-- Form -->
    <select name="form[]" class="formSelect" onchange="toggleCustomForm(this)" style="margin-top:6px;">
      <option value="">-- Select Form --</option>
      <option value="Flitches">Flitches</option>
      <option value="Round Logs">Round Logs</option>
      <option value="Lumber">Lumber</option>
      <option value="Timber">Timber</option>
      <option value="Charcoal">Charcoal</option>
      <option value="Other">Other (Specify)</option>
    </select>
    <input type="text" name="form_custom[]" class="customForm" 
           placeholder="Specify other form" style="display:none;margin-top:6px;">

    <!-- Size -->
    <select name="size[]" class="sizeSelect" style="margin-top:6px;">
      <option value="">-- Size --</option>
      <option value="S">S</option>
      <option value="M">M</option>
      <option value="L">L</option>
      <option value="Custom">Other</option>
    </select>
    <input type="text" name="size_custom[]" class="customSize" 
           placeholder="Specify size" style="display:none;margin-top:6px;">
  </td>
  <td><input name="pieces[]" type="number"></td>
  <td><input name="volume[]" type="number" step="0.01"></td>
  <td><input name="value[]" type="number" step="0.01"></td>
  <td><input name="origin[]"></td>
  <td><textarea name="owner[]"></textarea></td>
</tr>
</table>
<button type="button" class="add-row" onclick="addRow('forest')">➕ Add Row</button>


      <!-- Conveyance -->
      <h4>B. Conveyance</h4>
      <table id="conveyanceTable">
        <tr><th>Kind</th><th>Plate No.</th><th>Engine/Chassis</th><th>Value</th><th>Driver / Owner</th></tr>
        <tr>
          <td><input name="kind[]"></td>
          <td><input name="plate[]"></td>
          <td><input name="engine[]"></td>
          <td><input name="vehicle_value[]" type="number" step="0.01"></td>
          <td><textarea name="driver[]"></textarea></td>
        </tr>
      </table>
      <button type="button" class="add-row" onclick="addRow('conveyance')">➕ Add Row</button>

      <!-- Equipment -->
      <h4>C. Equipment</h4>
      <table id="equipmentTable">
        <tr><th>Type</th><th>Features</th><th>Value</th><th>Owner Address</th></tr>
        <tr>
          <td><input name="equipment[]"></td>
          <td><input name="equipment_features[]"></td>
          <td><input name="equipment_value[]" type="number" step="0.01"></td>
          <td><textarea name="equipment_owner[]"></textarea></td>
        </tr>
      </table>
      <button type="button" class="add-row" onclick="addRow('equipment')">➕ Add Row</button>

      <!-- Signatures -->
      <h4>Signatures</h4>
      <label>Apprehending Officer:</label>
      <input name="officer" required>

      <label>Witness:</label>
      <input name="witness">

      <label>Date Issued:</label>
      <input name="issue_date" type="date" required>

      <label>Conform by:</label>
      <input name="conform">

      <br><br>
      <button type="submit" class="btn-save">💾 Save Log</button>
    </form>
  </div>
</div>

<style>
.modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center;z-index:3500}
.modal-content{background:#fff;padding:30px;width:80%;max-width:900px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.3);max-height:75vh;overflow-y:auto}
.close{float:right;font-size:24px;font-weight:bold;cursor:pointer}
input,textarea,select{width:100%;padding:8px;margin:6px 0 12px;border:1px solid #ccc;border-radius:4px}
table{width:100%;margin-top:10px;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:6px}
.add-row{background:#4caf50;color:#fff;padding:6px 12px;border:none;border-radius:4px;margin-top:10px}
.btn-save{background:#2e7d32;color:#fff;padding:10px 16px;border:none;border-radius:4px}
.offense-fields{display:flex;flex-direction:column;gap:8px;margin:10px 0 20px}
.offense-fields select,.offense-fields input{padding:10px 12px;font-size:14px;border:1px solid #ccc;border-radius:4px}
.offense-fields select:focus,.offense-fields input:focus{border-color:#2e7d32;box-shadow:0 0 4px rgba(46,125,50,0.4);outline:none}
label{font-weight:600;color:#2e7d32;margin-top:10px;display:block}
</style>

<script>
function openAddModal() {
  // reset the form every time modal opens
  const form = document.getElementById('addForm');
  form.reset();

  // clear dynamic tables (forest, conveyance, equipment) back to first row
  document.getElementById("forestTable").innerHTML = `
    <tr>
      <th>Species & Form</th>
      <th>No. of Pieces</th>
      <th>Volume</th>
      <th>Value</th>
      <th>Origin</th>
      <th>Name/address of Owner & Offenders</th>
    </tr>
    <tr>
      <td>
        <select name="species_form[]" class="speciesSelect" onchange="toggleCustomSpecies(this)">
          <option value="">-- Select Species --</option>
          <option value="Narra">Narra</option>
          <option value="Molave">Molave</option>
          <option value="Dao">Dao</option>
          <option value="Kamagong">Kamagong</option>
          <option value="Ipil">Ipil</option>
          <option value="Akle">Akle</option>
          <option value="Apanit">Apanit</option>
          <option value="Banuyo">Banuyo</option>
          <option value="Ebony">Ebony</option>
          <option value="Kalantas">Kalantas</option>
          <option value="Supa">Supa</option>
          <option value="Batikuling">Batikuling</option>
          <option value="Betis">Betis</option>
          <option value="Bolong-eta">Bolong-eta</option>
          <option value="Teak">Teak</option>
          <option value="Tindalo">Tindalo</option>
          <option value="Manggis">Manggis</option>
          <option value="Almaciga">Almaciga</option>
          <option value="Lanete">Lanete</option>
          <option value="Lambayao">Lambayao</option>
          <option value="Sangilo">Sangilo</option>
          <option value="Other">Other (Specify)</option>
        </select>
        <input type="text" name="species_custom[]" class="customSpecies" placeholder="Specify other species" style="display:none;margin-top:6px;">
        <select name="form[]" class="formSelect" onchange="toggleCustomForm(this)" style="margin-top:6px;">
          <option value="">-- Select Form --</option>
          <option value="Flitches">Flitches</option>
          <option value="Round Logs">Round Logs</option>
          <option value="Lumber">Lumber</option>
          <option value="Timber">Timber</option>
          <option value="Charcoal">Charcoal</option>
          <option value="Other">Other (Specify)</option>
        </select>
        <input type="text" name="form_custom[]" class="customForm" placeholder="Specify other form" style="display:none;margin-top:6px;">
        <select name="size[]" class="sizeSelect" style="margin-top:6px;">
          <option value="">-- Size --</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="Custom">Other</option>
        </select>
        <input type="text" name="size_custom[]" class="customSize" placeholder="Specify size" style="display:none;margin-top:6px;">
      </td>
      <td><input name="pieces[]" type="number"></td>
      <td><input name="volume[]" type="number" step="0.01"></td>
      <td><input name="value[]" type="number" step="0.01"></td>
      <td><input name="origin[]"></td>
      <td><textarea name="owner[]"></textarea></td>
    </tr>
  `;

  document.getElementById("conveyanceTable").innerHTML = `
    <tr><th>Kind</th><th>Plate No.</th><th>Engine/Chassis</th><th>Value</th><th>Driver / Owner</th></tr>
    <tr>
      <td><input name="kind[]"></td>
      <td><input name="plate[]"></td>
      <td><input name="engine[]"></td>
      <td><input name="vehicle_value[]" type="number" step="0.01"></td>
      <td><textarea name="driver[]"></textarea></td>
    </tr>
  `;

  document.getElementById("equipmentTable").innerHTML = `
    <tr><th>Type</th><th>Features</th><th>Value</th><th>Owner Address</th></tr>
    <tr>
      <td><input name="equipment[]"></td>
      <td><input name="equipment_features[]"></td>
      <td><input name="equipment_value[]" type="number" step="0.01"></td>
      <td><textarea name="equipment_owner[]"></textarea></td>
    </tr>
  `;

  // reload offense categories fresh
  loadOffenseCategories();

  // show modal
  document.getElementById('addLogModal').style.display = 'flex';
}

function closeAddModal() {
  document.getElementById('addLogModal').style.display = 'none';
  // optional: also reset form on close
  document.getElementById('addForm').reset();
}


function addRow(type){
  const rows = {
    forest: `<tr>
      <td>
        <select name="species_form[]" class="speciesSelect" onchange="toggleCustomSpecies(this)">
          <option value="">-- Select Species & Form --</option>
          <option value="Narra">Narra</option>
          <option value="Molave">Molave</option>
          <option value="Dao">Dao</option>
          <option value="Kamagong">Kamagong</option>
          <option value="Ipil">Ipil</option>
          <option value="Akle">Akle</option>
          <option value="Apanit">Apanit</option>
          <option value="Banuyo">Banuyo</option>
          <option value="Ebony">Ebony</option>
          <option value="Kalantas">Kalantas</option>
          <option value="Supa">Supa</option>
          <option value="Batikuling">Batikuling</option>
          <option value="Betis">Betis</option>
          <option value="Bolong-eta">Bolong-eta</option>
          <option value="Teak">Teak</option>
          <option value="Tindalo">Tindalo</option>
          <option value="Manggis">Manggis</option>
          <option value="Almaciga">Almaciga</option>
          <option value="Lanete">Lanete</option>
          <option value="Lambayao">Lambayao</option>
          <option value="Sangilo">Sangilo</option>
          <option value="Other">Other (Specify)</option>
        </select>
        <input type="text" name="species_custom[]" class="customSpecies" 
               placeholder="Specify other species" 
               style="display:none;margin-top:6px;">
       <select name="form[]" class="formSelect" onchange="toggleCustomForm(this)" style="margin-top:6px;">
    <option value="">-- Select Form --</option>
    <option value="Flitches">Flitches</option>
    <option value="Round Logs">Round Logs</option>
    <option value="Lumber">Lumber</option>
    <option value="Timber">Timber</option>
    <option value="Charcoal">Charcoal</option>
    <option value="Other">Other (Specify)</option>
  </select>
  <input type="text" name="form_custom[]" class="customForm" 
         placeholder="Specify other form" style="display:none;margin-top:6px;">
  
  <select name="size[]" class="sizeSelect" style="margin-top:6px;">
    <option value="">-- Size --</option>
    <option value="S">S</option>
    <option value="M">M</option>
    <option value="L">L</option>
    <option value="Custom">Other</option>
  </select>
  <input type="text" name="size_custom[]" class="customSize" 
         placeholder="Specify size" style="display:none;margin-top:6px;">
</td>
      <td><input name="pieces[]" type="number"></td>
      <td><input name="volume[]" type="number" step="0.01"></td>
      <td><input name="value[]" type="number" step="0.01"></td>
      <td><input name="origin[]"></td>
      <td><textarea name="owner[]"></textarea></td>
    </tr>`,
    conveyance:`<tr>
      <td><input name="kind[]"></td>
      <td><input name="plate[]"></td>
      <td><input name="engine[]"></td>
      <td><input name="vehicle_value[]" type="number" step="0.01"></td>
      <td><textarea name="driver[]"></textarea></td>
    </tr>`,
    equipment:`<tr>
      <td><input name="equipment[]"></td>
      <td><input name="equipment_features[]"></td>
      <td><input name="equipment_value[]" type="number" step="0.01"></td>
      <td><textarea name="equipment_owner[]"></textarea></td>
    </tr>`
  };
  document.getElementById(type+'Table').insertAdjacentHTML('beforeend', rows[type]);
}



// Cascading District → Municipality → Barangay
const districtSelect=document.getElementById("district");
const municipalitySelect=document.getElementById("municipality");
const barangaySelect=document.getElementById("barangay");

districtSelect.addEventListener("change",()=>{
  const districtId=districtSelect.value;
  municipalitySelect.innerHTML="<option value=''>-- Select Municipality --</option>";
  barangaySelect.innerHTML="<option value=''>-- Select Barangay --</option>";
  municipalitySelect.disabled=true;
  barangaySelect.disabled=true;

  if(districtId){
    fetch(`../ajax/get_municipalities.php?district_id=${districtId}`)
      .then(res=>res.json())
      .then(data=>{
        if(data.length>0){
          municipalitySelect.disabled=false;
          data.forEach(m=>{
            municipalitySelect.innerHTML+=`<option value="${m.id}">${m.name}</option>`;
          });
        }
      });
  }
});

municipalitySelect.addEventListener("change",()=>{
  const municipalityId=municipalitySelect.value;
  barangaySelect.innerHTML="<option value=''>-- Select Barangay --</option>";
  barangaySelect.disabled=true;

  if(municipalityId){
    fetch(`../ajax/get_barangays.php?municipality_id=${municipalityId}`)
      .then(res=>res.json())
      .then(data=>{
        if(data.length>0){
          barangaySelect.disabled=false;
          data.forEach(b=>{
            barangaySelect.innerHTML+=`<option value="${b.id}">${b.name}</option>`;
          });
        }
      });
  }
});

// Offense dropdown
const offenseData={
  1:["Sec. 77 – Illegal cutting","Sec. 78 – Unlawful occupation","Sec. 79 – Grazing without permit"],
  2:["Sec. 7(a) – Possession of chainsaw","Sec. 7(b) – Illegal importation"],
  3:["RA 9147 – Illegal wildlife collection"],
  4:["EO 23 – Logging moratorium violation"],
  5:["RA 8371 – IPRA violation"],
  6:["RA 9003 – Improper waste disposal in forest areas"]
};

// Elements
const offenseCategory = document.getElementById("offenseCategory");
const offenseDetail = document.getElementById("offenseDetail");
const offenseInput = document.getElementById("offenseInput");

// Load categories on modal open
function loadOffenseCategories() {
  fetch("../ajax/get_offense_categories.php")
    .then(res => res.json())
    .then(data => {
      offenseCategory.innerHTML = "<option value=''>-- Select Category --</option>";
      data.forEach(cat => {
        offenseCategory.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
      });
    });
}

// When category changes → load offenses
offenseCategory.addEventListener("change", () => {
  const catId = offenseCategory.value;
  offenseDetail.innerHTML = "<option value=''>-- Select Offense --</option>";
  offenseDetail.disabled = true;
  offenseInput.value = "";

  if (catId) {
   fetch(`../ajax/get_offense_types.php?category_id=${catId}`)
      .then(res => res.json())
      .then(data => {
        if (data.length > 0) {
          offenseDetail.disabled = false;
          data.forEach(off => {
            offenseDetail.innerHTML += `<option value="${off.id}">${off.name}</option>`;
          });
        }
      });
  }
});

// Auto-fill custom input with selected values
offenseDetail.addEventListener("change", () => {
  const categoryText = offenseCategory.options[offenseCategory.selectedIndex]?.text || "";
  const offenseText = offenseDetail.options[offenseDetail.selectedIndex]?.text || "";
  if (categoryText && offenseText) {
    offenseInput.value = `${categoryText}, ${offenseText}`;
  }
});

// Call this whenever modal is opened
function openAddModal() {
  loadOffenseCategories();
  document.getElementById('addLogModal').style.display = 'flex';
}


function toggleCustomForm(select){
  const input = select.parentElement.querySelector('.customForm');
  if(select.value === "Other"){
    input.style.display = "block";
  } else {
    input.style.display = "none";
    input.value = "";
  }
}

document.addEventListener("change", (e)=>{
  if(e.target.classList.contains("sizeSelect")){
    const input = e.target.parentElement.querySelector(".customSize");
    if(e.target.value === "Custom"){
      input.style.display = "block";
    } else {
      input.style.display = "none";
      input.value = "";
    }
  }
});

// Auto set report_month and report_year before submit + Confirmation
document.getElementById("rmcForm").addEventListener("submit", function(e) {
  const monthInput = document.getElementById("reportMonth").value; // format: 2025-09
  if (monthInput) {
    let parts = monthInput.split("-");
    document.getElementById("reportYearField").value = parts[0];
    document.getElementById("reportMonthField").value = parts[1];
  }

  // ✅ Add confirmation before final submit
  const confirmSubmit = confirm("Are you sure you want to submit this RMC Monthly Report?");
  if (!confirmSubmit) {
    e.preventDefault(); // stop submission
  }
});

</script>

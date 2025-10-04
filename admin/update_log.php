<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../debug.log');
require_once('../db_connect.php');
error_log("Incoming POST to update_log.php: " . print_r($_POST, true));

if (!isset($_SESSION['login_id'])) { http_response_code(403); exit; }

$id              = intval($_POST['id']);
$date_time       = $_POST['date_time'];
$district_id     = $_POST['district_id'] ?? null;
$municipality_id = $_POST['municipality_id'] ?? null;
$barangay_id     = $_POST['barangay_id'] ?? null;
$offense_category_id = $_POST['offense_category_id'] ?? null;
$offense_type_id = $_POST['offense_type_id'] ?? null;
$offense_custom  = $_POST['offense_custom'] ?? null;
$remarks         = $_POST['remarks'];
$status          = $_POST['status'] === 'Closed' ? 'Closed' : 'Active';
$officer         = $_POST['officer'];
$witness         = $_POST['witness'] ?? null;
$issue_date      = $_POST['issue_date'];
$conform         = $_POST['conform'] ?? null;

$conn->begin_transaction();
try {
  // 1. Update main log info
  $stmt = $conn->prepare("UPDATE apprehended_logs
    SET date_time=?, district_id=?, municipality_id=?, barangay_id=?, 
        offense_category_id=?, offense_type_id=?, offense_custom=?, 
        remarks=?, officer_name=?, witness_name=?, issue_date=?, conform_by=?, status=?
    WHERE id=?");

  $stmt->bind_param(
    'siiiiisssssssi',
    $date_time,
    $district_id,
    $municipality_id,
    $barangay_id,
    $offense_category_id,
    $offense_type_id,
    $offense_custom,
    $remarks,
    $officer,
    $witness,
    $issue_date,
    $conform,
    $status,
    $id
  );

  if (!$stmt->execute()) {
      throw new Exception("Main update error: " . $stmt->error);
  }

  // 2. Delete old child data
  $conn->query("DELETE FROM log_forest_products WHERE log_id = $id");
  $conn->query("DELETE FROM log_conveyance WHERE log_id = $id");
  $conn->query("DELETE FROM log_equipment WHERE log_id = $id");

  // 3. Insert updated Forest Products
  if (!empty($_POST['species_form'])) {
    foreach ($_POST['species_form'] as $i => $val) {
      if (trim($val) === '' && empty($_POST['species_custom'][$i])) continue;

      $species_form   = $_POST['species_form'][$i];
      $species_custom = $_POST['species_custom'][$i] ?? null;
      $form           = $_POST['form'][$i] ?? null;
      $form_custom    = $_POST['form_custom'][$i] ?? null;
      $size           = $_POST['size'][$i] ?? null;
      $size_custom    = $_POST['size_custom'][$i] ?? null;
      $pieces         = (int)($_POST['pieces'][$i] ?? 0);
      $volume         = (float)($_POST['volume'][$i] ?? 0);
      $value          = (float)($_POST['value'][$i] ?? 0);
      $origin         = $_POST['origin'][$i] ?? '';
      $owner          = $_POST['owner'][$i] ?? '';

      $stmt = $conn->prepare("INSERT INTO log_forest_products
        (log_id, species_form, species_custom, form, form_custom, size, size_custom, 
         no_of_pieces, volume, estimated_value, origin, owner_info)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      $stmt->bind_param(
        "issssssiidss",
        $id,
        $species_form,
        $species_custom,
        $form,
        $form_custom,
        $size,
        $size_custom,
        $pieces,
        $volume,
        $value,
        $origin,
        $owner
      );
      $stmt->execute();
    }
  }

  // 4. Insert updated Conveyance
  if (!empty($_POST['kind'])) {
    foreach ($_POST['kind'] as $i => $val) {
      if (trim($val) === '') continue;

      $kind    = $_POST['kind'][$i];
      $plate   = $_POST['plate'][$i] ?? '';
      $engine  = $_POST['engine'][$i] ?? '';
      $v_value = (float)($_POST['vehicle_value'][$i] ?? 0);
      $driver  = $_POST['driver'][$i] ?? '';

      $stmt = $conn->prepare("INSERT INTO log_conveyance
        (log_id, kind, plate_no, engine_chassis_no, estimated_value, driver_owner_info)
        VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param(
        "isssds",
        $id,
        $kind,
        $plate,
        $engine,
        $v_value,
        $driver
      );
      $stmt->execute();
    }
  }

  // 5. Insert updated Equipment
  if (!empty($_POST['equipment'])) {
    foreach ($_POST['equipment'] as $i => $val) {
      if (trim($val) === '') continue;

      $equipment  = $_POST['equipment'][$i];
      $features   = $_POST['equipment_features'][$i] ?? '';
      $e_value    = (float)($_POST['equipment_value'][$i] ?? 0);
      $e_owner    = $_POST['equipment_owner'][$i] ?? '';

      $stmt = $conn->prepare("INSERT INTO log_equipment
        (log_id, equipment_details, features, estimated_value,  owner_address)
        VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param(
        "issds",
        $id,
        $equipment,
        $features,
        $e_value,
        $e_owner
      );
      $stmt->execute();
    }
  }

  $conn->commit();
  echo 'OK';

} catch (Exception $e) {
  $conn->rollback();
  $msg = 'Update error: ' . $e->getMessage();
  error_log($msg);
  echo 'ERR: ' . $msg;
}
?>

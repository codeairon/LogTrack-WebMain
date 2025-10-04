/* ========================== handle_add_log.php ========================== */
<?php
require_once('../db_connect.php');
require_once __DIR__ . '/../inc/qr_helper.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ✅ Validate required fields
    if (
        empty($_POST['date_time']) || 
        empty($_POST['district_id']) || 
        empty($_POST['municipality_id']) || 
        empty($_POST['barangay_id']) || 
        (empty($_POST['offense_type_id']) && empty($_POST['offense_custom'])) || 
        empty($_POST['officer']) || 
        empty($_POST['issue_date'])
    ) {
        exit("⚠️ Missing required fields.");
    }

    /* ================= Apprehended Log ================= */
    $date_time          = $_POST['date_time'];
    $district_id        = $_POST['district_id'] ?? null;
    $municipality_id    = $_POST['municipality_id'] ?? null;
    $barangay_id        = $_POST['barangay_id'] ?? null;
    $offense_category_id= $_POST['offense_category_id'] ?? null;
    $offense_type_id    = $_POST['offense_type_id'] ?? null;
    $offense_custom     = $_POST['offense_custom'] ?? null;
    $remarks            = $_POST['remarks'] ?? null;
    $officer            = $_POST['officer'];
    $witness            = $_POST['witness'] ?? null;
    $issue_date         = $_POST['issue_date'];
    $conform            = $_POST['conform'] ?? null;

$offense_category_id = !empty($_POST['offense_category_id']) ? intval($_POST['offense_category_id']) : null;
$offense_type_id     = !empty($_POST['offense_type_id']) ? intval($_POST['offense_type_id']) : null;
$offense_custom      = !empty($_POST['offense_custom']) ? trim($_POST['offense_custom']) : null;

$stmt = $conn->prepare("INSERT INTO apprehended_logs 
    (date_time, district_id, municipality_id, barangay_id, 
     offense_category_id, offense_type_id, offense_custom, 
     remarks, officer_name, witness_name, issue_date, conform_by) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "siiiisssssss",
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
    $conform
);
    $stmt->execute();
    $log_id = $conn->insert_id;
    $stmt->close();

  /* ================= Forest Products ================= */
if (!empty($_POST['species_form'])) {
    foreach ($_POST['species_form'] as $i => $species_val) {
        if (trim($species_val) === '' && empty($_POST['species_custom'][$i])) continue;

        $species_form     = $_POST['species_form'][$i] ?? null; // dropdown species
        $species_custom   = $_POST['species_custom'][$i] ?? null;
        $form_val         = $_POST['form'][$i] ?? null;
        $form_custom      = $_POST['form_custom'][$i] ?? null;
        $size_val         = $_POST['size'][$i] ?? null;
        $size_custom      = $_POST['size_custom'][$i] ?? null;
        $pieces           = $_POST['pieces'][$i] ?? 0;
        $volume           = $_POST['volume'][$i] ?? 0;
        $value            = $_POST['value'][$i] ?? 0;
        $origin           = $_POST['origin'][$i] ?? '';
        $owner            = $_POST['owner'][$i] ?? '';

        $stmt = $conn->prepare("INSERT INTO log_forest_products 
            (log_id, species_form, species_custom, form, form_custom, size, size_custom, 
             no_of_pieces, volume, estimated_value, origin, owner_info) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "issssssiidss",
            $log_id,
            $species_form,
            $species_custom,
            $form_val,
            $form_custom,
            $size_val,
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

    /* ================= Conveyance ================= */
    if (!empty($_POST['kind'])) {
        foreach ($_POST['kind'] as $i => $val) {
            if (trim($val) === '') continue;

            $kind           = $val;
            $plate          = $_POST['plate'][$i] ?? '';
            $engine         = $_POST['engine'][$i] ?? '';
            $vehicle_value  = $_POST['vehicle_value'][$i] ?? 0;
            $driver         = $_POST['driver'][$i] ?? '';

            $stmt = $conn->prepare("INSERT INTO log_conveyance 
                (log_id, kind, plate_no, engine_chassis_no, estimated_value, driver_owner_info) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "isssds",
                $log_id,
                $kind,
                $plate,
                $engine,
                $vehicle_value,
                $driver
            );
            $stmt->execute();
        }
    }

    /* ================= Equipment ================= */
    if (!empty($_POST['equipment'])) {
        foreach ($_POST['equipment'] as $i => $val) {
            if (trim($val) === '') continue;

            $equipment       = $val;
            $features        = $_POST['equipment_features'][$i] ?? '';
            $equipment_value = $_POST['equipment_value'][$i] ?? 0;
            $equipment_owner = $_POST['equipment_owner'][$i] ?? '';

            $stmt = $conn->prepare("INSERT INTO log_equipment 
                (log_id, equipment_details, features, estimated_value, owner_address) 
                VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "issds",
                $log_id,
                $equipment,
                $features,
                $equipment_value,
                $equipment_owner
            );
            $stmt->execute();
        }
    }

    /* ================= QR Code ================= */
    $qr_filename = makeLogQr($conn, $log_id);
    $conn->query("UPDATE apprehended_logs SET qr_filename = '$qr_filename' WHERE id = $log_id");

    /* ================= Redirect ================= */
    echo "<script>
        document.body.innerHTML = '<div style=\"display:flex;align-items:center;justify-content:center;height:100vh;font:600 20px arial;color:#2e7d32\">✅ Log added successfully!</div>';
        setTimeout(() => location.href = \"log_details.php\", 2000);
    </script>";
    exit;
}
?>

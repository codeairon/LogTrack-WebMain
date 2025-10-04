<?php
session_start();
require_once('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Invalid request method']);
    exit;
}

$id = intval($_POST['id']);
$conn->begin_transaction();

try {
    // Fetch original log
    $log = $conn->query("SELECT * FROM apprehended_logs WHERE id = $id")->fetch_assoc();
    if (!$log) throw new Exception('Log not found.');

    // Insert into disposed_logs (updated columns to match schema)
    $cols = "`original_log_id`, `date_time`, `district_id`, `municipality_id`, `barangay_id`,
             `offense_category_id`, `offense_type_id`, `offense_custom`,
             `remarks`, `officer_name`, `witness_name`, `issue_date`, `conform_by`, `disposed_by`, `disposed_at`";

    $stmt = $conn->prepare("
        INSERT INTO disposed_logs ($cols)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        "isiiiisssssssi",
        $log['id'],
        $log['date_time'],
        $log['district_id'],
        $log['municipality_id'],
        $log['barangay_id'],
        $log['offense_category_id'],
        $log['offense_type_id'],
        $log['offense_custom'],
        $log['remarks'],
        $log['officer_name'],
        $log['witness_name'],
        $log['issue_date'],
        $log['conform_by'],
        $_SESSION['login_id']
    );
    $stmt->execute();
    $newId = $conn->insert_id;

    // ✅ Helper to move child rows
    function moveChild($table, $dst, $idcol, $logId, $conn, $newId) {
        $rows = $conn->query("SELECT * FROM $table WHERE log_id = $logId");
        while ($row = $rows->fetch_assoc()) {
            unset($row[$idcol]);       // remove primary key
            $row['log_id'] = $newId;   // assign new foreign key

            $keys = implode('`,`', array_keys($row));
            $placeholders = rtrim(str_repeat('?,', count($row)), ',');

            $types = '';
            foreach ($row as $val) {
                if (is_int($val)) $types .= 'i';
                elseif (is_float($val)) $types .= 'd';
                else $types .= 's';
            }

            $stmt = $conn->prepare("INSERT INTO $dst (`$keys`) VALUES ($placeholders)");
            $stmt->bind_param($types, ...array_values($row));
            $stmt->execute();
        }
    }

    // Move all related entries
    moveChild('log_forest_products', 'disposed_forest_products', 'id', $id, $conn, $newId);
    moveChild('log_conveyance', 'disposed_conveyance', 'id', $id, $conn, $newId);
    moveChild('log_equipment', 'disposed_equipment', 'id', $id, $conn, $newId);

    // Remove from live tables
    $conn->query("DELETE FROM log_equipment        WHERE log_id = $id");
    $conn->query("DELETE FROM log_conveyance       WHERE log_id = $id");
    $conn->query("DELETE FROM log_forest_products  WHERE log_id = $id");
    $conn->query("DELETE FROM apprehended_logs     WHERE id = $id");

    $conn->commit();
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    $conn->rollback();
    file_put_contents(__DIR__ . '/../debug.log', "Dispose error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
}

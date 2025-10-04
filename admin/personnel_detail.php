<?php
// admin/personnel_detail.php
include '../db_connect.php';

$staff_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$staff_id) {
    echo "<p style='color:red;'>⚠️ Invalid staff ID.</p>";
    exit;
}

// Fetch contributions for this staff
$sql = $conn->query("
    SELECT species, quantity, total, status, report_date
    FROM staff_contributions
    WHERE staff_id = $staff_id
    ORDER BY report_date DESC
");

if ($sql->num_rows == 0) {
    echo "<p>No contributions found for this staff.</p>";
    exit;
}

echo "<h5>Contributions of Staff {$staff_id}</h5>";
echo "<table class='table table-striped table-sm'>
        <thead>
          <tr>
            <th>Report Date</th>
            <th>Species</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>";

while ($row = $sql->fetch_assoc()) {
    echo "<tr>
            <td>{$row['report_date']}</td>
            <td>{$row['species']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['total']}</td>
            <td>{$row['status']}</td>
          </tr>";
}

echo "</tbody></table>";

// Verify button
echo "<div class='mt-3'>
        <button type='button' class='btn btn-primary btn-sm' 
                onclick='verifyContribution({$staff_id})'>
          Verify Contribution
        </button>
      </div>";

?>

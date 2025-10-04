<?php
// admin/fetch_personnel.php
include '../db_connect.php';

$year = isset($_GET['year']) ? intval($_GET['year']) : 0;
$month = isset($_GET['month']) ? intval($_GET['month']) : 0;

if (!$year || !$month) {
    echo "<p style='color:red;'>⚠️ Invalid reporting period.</p>";
    exit;
}

// Fetch staff contributions for this period
$sql = $conn->query("
    SELECT sc.staff_id, 
           SUM(sc.quantity) as total_contribution
    FROM staff_contributions sc
    WHERE YEAR(sc.report_date) = $year
      AND MONTH(sc.report_date) = $month
    GROUP BY sc.staff_id
    ORDER BY sc.staff_id ASC
");

if ($sql->num_rows == 0) {
    echo "<p>No staff contributions found for this period.</p>";
    exit;
}

echo "<table class='table table-bordered table-sm'>";
echo "<thead>
        <tr>
          <th>Staff ID</th>
          <th>Total Contribution</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>";

while ($row = $sql->fetch_assoc()) {
    echo "<tr>
            <td>Staff {$row['staff_id']}</td>
            <td>{$row['total_contribution']}</td>
            <td>
              <button class='btn btn-success btn-sm' onclick='showPersonnelDetail({$row['staff_id']})'>
                View
              </button>
            </td>
          </tr>";
}

echo "</tbody></table>";
?>

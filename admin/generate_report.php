<?php
session_start();
if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php'; // Dompdf
require_once '../db_connect.php';

use Dompdf\Dompdf;

$type = $_GET['type'] ?? 'logcase'; // default report
$html = '';

if ($type === 'logcase') {
    // ----------------------------
    // LOG CASE REPORT
    // ----------------------------
    $sql = "
        SELECT 
            al.id,
            al.date_time,
            al.status,
            al.officer_name,
            al.witness_name,
            al.issue_date,
            al.conform_by,
            al.offense_custom,
            d.name AS district_name,
            m.name AS municipality_name,
            b.name AS barangay_name
        FROM apprehended_logs al
        LEFT JOIN districts d ON al.district_id = d.id
        LEFT JOIN municipalities m ON al.municipality_id = m.id
        LEFT JOIN barangays b ON al.barangay_id = b.id
        ORDER BY al.date_time DESC
    ";
    $result = $conn->query($sql);

    $html .= '<h2 style="text-align:center;">Log Case Report</h2>
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr style="background-color:#f2f2f2; text-align:center;">
                <th>ID</th>
                <th>Date/Time</th>
                <th>Location</th>
                <th>Offense</th>
                <th>Officer</th>
                <th>Witness</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $location = $row['barangay_name'] . ', ' . $row['municipality_name'] . ', ' . $row['district_name'];
            $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['date_time'] . '</td>
                <td>' . htmlspecialchars($location) . '</td>
                <td>' . htmlspecialchars($row['offense_custom']) . '</td>
                <td>' . htmlspecialchars($row['officer_name']) . '</td>
                <td>' . htmlspecialchars($row['witness_name']) . '</td>
                <td>' . $row['status'] . '</td>
            </tr>';
        }
    } else {
        $html .= '<tr><td colspan="7" style="text-align:center;">No records found</td></tr>';
    }

    $html .= '</tbody></table>';

} elseif ($type === 'seedling') {
    // ----------------------------
    // SEEDLING REPORT (DENR-style Table)
    // ----------------------------
    $sql = "
        SELECT si.*, ps.regular_personnel, ps.contractual_personnel, ps.remarks AS personnel_remarks
        FROM seedling_inventory si
        LEFT JOIN personnel_summary ps ON si.report_date = ps.report_date
        ORDER BY si.report_date ASC, si.category ASC, si.species ASC
    ";
    $result = $conn->query($sql);

    $html .= '<h2 style="text-align:center;">Seedling Inventory Report</h2>';

    if ($result->num_rows > 0) {
        // Group by report_date
        $grouped = [];
        while ($row = $result->fetch_assoc()) {
            $grouped[$row['report_date']]['rows'][] = $row;
            $grouped[$row['report_date']]['personnel'] = [
                'regular' => $row['regular_personnel'],
                'contractual' => $row['contractual_personnel'],
                'remarks' => $row['personnel_remarks'] ?? ''
            ];
        }

        $html .= '
        <style>
            table { border-collapse: collapse; font-size: 9px; }
            th, td { border: 1px solid black; padding: 3px; text-align: center; }
            th { background-color: #f2f2f2; }
        </style>
        <table width="100%">
           <thead>
            <tr>
                <th colspan="3">Personnel</th>
                <th colspan="7">RMC-2014-01</th>
                <th colspan="6">TCP Replacement</th>
                <th colspan="7">Nursery Maintenance</th>
                <th rowspan="2">Remarks</th>
            </tr>
            <tr>
                <th>Regular</th>
                <th>Contractual</th>
                <th>Total</th>

                <th>Target</th>
                <th>Species</th>
                <th>Previous Stock</th>
                <th>Produced</th>
                <th>Disposed</th>
                <th>Mortality</th>
                <th>Stock to Date</th>

                <th>Species</th>
                <th>Previous Stock</th>
                <th>Replacement</th>
                <th>Disposed</th>
                <th>Mortality</th>
                <th>Stock to Date</th>

                <th>Target</th>
                <th>Species</th>
                <th>Previous Stock</th>
                <th>Produced</th>
                <th>Disposed</th>
                <th>Mortality</th>
                <th>Stock to Date</th>
            </tr>
           </thead>
           <tbody>';

        foreach ($grouped as $date => $data) {
            $regular = intval($data['personnel']['regular']);
            $contractual = intval($data['personnel']['contractual']);
            $total = $regular + $contractual;
            $remarks = $data['personnel']['remarks'];

            // ----------------------------
            // Aggregate rows by category + species
            // ----------------------------
            $agg = [
                'RMC-2014-01' => [],
                'TCP Replacement' => [],
                'Nursery Maintenance' => []
            ];

            foreach ($data['rows'] as $row) {
                $cat = $row['category'];
                $sp = strtolower(trim($row['species']));
                if (!isset($agg[$cat][$sp])) {
                    $agg[$cat][$sp] = [
                        'species' => $row['species'],
                        'target' => $row['target'] ?? 0,
                        'prev' => 0,
                        'prod' => 0,
                        'disp' => 0,
                        'mort' => 0,
                        'stock' => 0
                    ];
                }
                $agg[$cat][$sp]['prev']  += intval($row['previous_stock']);
                $agg[$cat][$sp]['prod']  += intval($row['produced_this_month']);
                $agg[$cat][$sp]['disp']  += intval($row['disposed_this_month']);
                $agg[$cat][$sp]['mort']  += intval($row['mortality_this_month']);
                $agg[$cat][$sp]['stock'] += intval($row['stock_to_date']);
                $agg[$cat][$sp]['target'] = $row['target'] ?? $agg[$cat][$sp]['target'];
            }

            $rmc = array_values($agg['RMC-2014-01']);
            $tcp = array_values($agg['TCP Replacement']);
            $nursery = array_values($agg['Nursery Maintenance']);
            $maxRows = max(count($rmc), count($tcp), count($nursery));
            if ($maxRows == 0) $maxRows = 1;

            // Period label
            $periodLabel = "Reporting Period: " . date("F Y", strtotime($date));
            $html .= '<tr><td colspan="24" style="text-align:left; font-weight:bold; background-color:#d9ead3;">'.$periodLabel.'</td></tr>';

            // Table rows
            for ($i = 0; $i < $maxRows; $i++) {
                $html .= '<tr>';
                if ($i == 0) {
                    $html .= '<td rowspan="'.$maxRows.'">'.$regular.'</td>';
                    $html .= '<td rowspan="'.$maxRows.'">'.$contractual.'</td>';
                    $html .= '<td rowspan="'.$maxRows.'">'.$total.'</td>';
                    $html .= '<td rowspan="'.$maxRows.'">'.($rmc[0]['target'] ?? '').'</td>';
                }

                // RMC
                if (isset($rmc[$i])) {
                    $html .= '<td>'.htmlspecialchars($rmc[$i]['species']).'</td>';
                    $html .= '<td>'.$rmc[$i]['prev'].'</td>';
                    $html .= '<td>'.$rmc[$i]['prod'].'</td>';
                    $html .= '<td>'.$rmc[$i]['disp'].'</td>';
                    $html .= '<td>'.$rmc[$i]['mort'].'</td>';
                    $html .= '<td>'.$rmc[$i]['stock'].'</td>';
                } else {
                    $html .= str_repeat('<td></td>', 6);
                }

                // TCP
                if (isset($tcp[$i])) {
                    $html .= '<td>'.htmlspecialchars($tcp[$i]['species']).'</td>';
                    $html .= '<td>'.$tcp[$i]['prev'].'</td>';
                    $html .= '<td>'.$tcp[$i]['prod'].'</td>';
                    $html .= '<td>'.$tcp[$i]['disp'].'</td>';
                    $html .= '<td>'.$tcp[$i]['mort'].'</td>';
                    $html .= '<td>'.$tcp[$i]['stock'].'</td>';
                } else {
                    $html .= str_repeat('<td></td>', 6);
                }

                // Nursery
               // Nursery
if ($i == 0) {
    $html .= '<td rowspan="'.$maxRows.'">'.($nursery[0]['target'] ?? '').'</td>';
}
if (isset($nursery[$i])) {
    $html .= '<td>'.htmlspecialchars($nursery[$i]['species']).'</td>';
    $html .= '<td>'.$nursery[$i]['prev'].'</td>';
    $html .= '<td>'.$nursery[$i]['prod'].'</td>';
    $html .= '<td>'.$nursery[$i]['disp'].'</td>';
    $html .= '<td>'.$nursery[$i]['mort'].'</td>';
    $html .= '<td>'.$nursery[$i]['stock'].'</td>';
} else {
    $html .= str_repeat('<td></td>', 6);
}

                if ($i == 0) {
    $defaultRemarks = "Regular personnel required 300 seedlings and Contractual is 150 seedlings annually";
    $html .= '<td rowspan="'.$maxRows.'">'.$defaultRemarks.'</td>';
}

                $html .= '</tr>';
            }

            // ----------------------------
            // Grand Total row (monthly subtotal)
            // ----------------------------
            $gt = [
                'rmc' => ['prev'=>0,'prod'=>0,'disp'=>0,'mort'=>0,'stock'=>0],
                'tcp' => ['prev'=>0,'prod'=>0,'disp'=>0,'mort'=>0,'stock'=>0],
                'nur' => ['prev'=>0,'prod'=>0,'disp'=>0,'mort'=>0,'stock'=>0]
            ];
            foreach ($rmc as $r) {
                $gt['rmc']['prev'] += $r['prev'];
                $gt['rmc']['prod'] += $r['prod'];
                $gt['rmc']['disp'] += $r['disp'];
                $gt['rmc']['mort'] += $r['mort'];
                $gt['rmc']['stock'] += $r['stock'];
            }
            foreach ($tcp as $r) {
                $gt['tcp']['prev'] += $r['prev'];
                $gt['tcp']['prod'] += $r['prod'];
                $gt['tcp']['disp'] += $r['disp'];
                $gt['tcp']['mort'] += $r['mort'];
                $gt['tcp']['stock'] += $r['stock'];
            }
            foreach ($nursery as $r) {
                $gt['nur']['prev'] += $r['prev'];
                $gt['nur']['prod'] += $r['prod'];
                $gt['nur']['disp'] += $r['disp'];
                $gt['nur']['mort'] += $r['mort'];
                $gt['nur']['stock'] += $r['stock'];
            }

            $html .= '<tr style="font-weight:bold; background-color:#f9cb9c;">
                <td colspan="4">Grand Total</td>
                <td></td>
                <td>'.$gt['rmc']['prev'].'</td>
                <td>'.$gt['rmc']['prod'].'</td>
                <td>'.$gt['rmc']['disp'].'</td>
                <td>'.$gt['rmc']['mort'].'</td>
                <td>'.$gt['rmc']['stock'].'</td>

                <td></td>
                <td>'.$gt['tcp']['prev'].'</td>
                <td>'.$gt['tcp']['prod'].'</td>
                <td>'.$gt['tcp']['disp'].'</td>
                <td>'.$gt['tcp']['mort'].'</td>
                <td>'.$gt['tcp']['stock'].'</td>

                <td></td>
                <td></td>
                <td>'.$gt['nur']['prev'].'</td>
                <td>'.$gt['nur']['prod'].'</td>
                <td>'.$gt['nur']['disp'].'</td>
                <td>'.$gt['nur']['mort'].'</td>
                <td>'.$gt['nur']['stock'].'</td>

                <td></td>
            </tr>';
        }

        $html .= '</tbody></table>';
    } else {
        $html .= '<p style="text-align:center;">No seedling data found</p>';
    }
}

// ----------------------------
// Generate PDF
// ----------------------------
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$filename = ($type === 'seedling') ? "seedling_report.pdf" : "log_report.pdf";
$dompdf->stream($filename, ["Attachment" => false]);
exit;

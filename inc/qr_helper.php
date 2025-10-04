<?php
require_once __DIR__.'/../vendor/autoload.php';
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

function makeLogQr(mysqli $conn, int $log_id): string {
    $url = "http://localhost/LogTrackmain/view_log.php?id=$log_id";  // ← adjust if needed
    $filename = "$log_id.png";
    $filePath = __DIR__ . "/../assets/qrcodes/$filename";

    // Ensure directory exists
    if (!is_dir(dirname($filePath))) {
        mkdir(dirname($filePath), 0777, true);
    }

    // Generate QR code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($url)
        ->size(300)
        ->margin(10)
        ->build();

    // Save to file
    $result->saveToFile($filePath);

    // Optional debug
    file_put_contents(__DIR__ . '/../debug.log', "✅ QR Generated: $filePath\n", FILE_APPEND);

    return $filename;
}

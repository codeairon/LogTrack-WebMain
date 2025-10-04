<?php
// Load Semaphore API key securely
$config = require __DIR__ . '/../config/semaphore.php';
$apikey = $config['API_KEY'];

// Send SMS function
function sendSMS($number, $message) {
    global $apikey; // Access global API key

    $sendername = 'LogTrack'; // Optional, must be registered in Semaphore

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'apikey'     => $apikey,
        'number'     => $number,
        'message'    => $message,
        'sendername' => $sendername
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check response for success
    if ($http_status === 200 && str_contains($response, 'message_id')) {
        return true;
    } else {
        error_log("Semaphore SMS failed: HTTP $http_status | Response: $response");
        return false;
    }
}

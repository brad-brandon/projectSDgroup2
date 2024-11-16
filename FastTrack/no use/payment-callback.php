<?php
// Read incoming callback data
$data = file_get_contents("php://input");
$decodedData = json_decode($data, true);

if (isset($decodedData['billcode']) && isset($decodedData['status_id'])) {
    $billCode = $decodedData['billcode'];
    $statusId = $decodedData['status_id'];

    if ($statusId == 1) {
        // Mark as successful in your database
        echo 'Payment successful for bill ' . $billCode;
    } else {
        // Mark as failed in your database
        echo 'Payment failed for bill ' . $billCode;
    }
} else {
    echo 'Invalid callback data received.';
}
?>

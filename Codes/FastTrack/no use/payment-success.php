<?php
if (isset($_GET['status_id'])) {
    $statusId = $_GET['status_id'];
    if ($statusId == 1) {
        echo 'Payment was successful!';
        // Update your database to mark the transaction as successful
    } else {
        echo 'Payment was not successful!';
        // Handle failed payment here
    }
} else {
    echo 'Invalid response from payment gateway.';
}
?>

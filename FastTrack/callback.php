<?php
// Toyyibpay will send data to this URL after payment is completed
// Get the response from Toyyibpay

$billCode = $_POST['billCode']; // Bill code from Toyyibpay
$paymentStatus = $_POST['status']; // Payment status (1: successful, 0: failed)

// Database connection settings
$servername = "localhost";
$username = "Webs392024";
$password = "Webs392024";
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update payment status in the database (example query)
if ($paymentStatus == 1) {
    // Payment successful, update the user's membership status
    $sql = "UPDATE payments SET status='paid' WHERE bill_code=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $billCode);
    $stmt->execute();
    $stmt->close();
}

// Close the connection
$conn->close();
?>
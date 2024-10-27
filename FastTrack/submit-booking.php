<?php
session_start();

var_dump($_POST); // Check what is being sent in the POST request
// Check if id is set and valid
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid class selection. Posted data: " . print_r($_POST, true));
}

if (!$id) {
    // Store error message in session
    $_SESSION['error'] = "Invalid class selection. Please try again.";
    // Redirect back to class selection page
    header("Location: bookTrainingClass.php");
    exit();
}

// Store id in session
$_SESSION['id'] = $id;

// Redirect to booking page
header("Location: booking.php");
exit();
?>

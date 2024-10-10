<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

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

// Get the user's ID and form data
$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate that new password and confirm password match
if ($new_password !== $confirm_password) {
    header("Location: ../verify_result.php?message=" . urlencode("New password and confirm password do not match."));
    exit();
}

// Fetch the current password hash from the database
$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

// Verify the current password
if (!password_verify($current_password, $hashed_password)) {
    header("Location: ../verify_result.php?message=" . urlencode("Current password is incorrect."));
    exit();
}

// Hash the new password
$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

// Update the password in the database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $new_password_hashed, $user_id);

if ($stmt->execute()) {
    header("Location: ../verify_result.php?message=" . urlencode("Password changed successfully."));
} else {
    header("Location: ../verify_result.php?message=" . urlencode("Failed to change password."));
}

$stmt->close();
$conn->close();
?>

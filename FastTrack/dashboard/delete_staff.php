<?php
// delete_staff.php
include 'db_connect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Delete query
$sql = "DELETE FROM users WHERE id = $id AND user_type = 'staff'";

if ($conn->query($sql) === TRUE) {
    echo "Staff deleted successfully!";
    header("Location: staff_info.php"); // Redirect back to staff info page
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>

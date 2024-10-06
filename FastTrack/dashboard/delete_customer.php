<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "fasttrack_gym";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Customer deleted successfully!";
        header("Location: customer.php");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

// Close connection
$conn->close();
?>

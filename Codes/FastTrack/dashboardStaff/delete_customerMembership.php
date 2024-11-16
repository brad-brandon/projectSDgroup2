<?php
// Database connection
include 'db_connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update query to set membership_type and Status to null
    $sql_update = "UPDATE users SET membership_type = NULL, Status = NULL WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Customer data updated successfully!";
        header("Location: form.php");
        exit();
    } else {
        echo "Error updating customer data: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

// Close connection
$conn->close();
?>

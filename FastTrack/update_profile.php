<?php
// Start the session
session_start();

// Include database connection
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $membership_type = $_POST['membership_type'];
    $status = $_POST['status'];

    // Assuming you store the user ID in session
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to update the user profile
    $sql = "UPDATE users SET name = ?, email = ?, phone = ?, membership_type = ?, status = ? WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssssi", $name, $email, $phone, $membership_type, $status, $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Success message
            echo "Profile updated successfully.";
        } else {
            // Error message
            echo "Error updating profile: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
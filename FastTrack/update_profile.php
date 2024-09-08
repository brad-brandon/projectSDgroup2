<?php
// Start the session
session_start();

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the form data
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phoneNo = $conn->real_escape_string(trim($_POST['phoneNo']));
    $membershipType = $conn->real_escape_string(trim($_POST['membershipType']));
    $status = $conn->real_escape_string(trim($_POST['status']));

    // Assuming you store the user ID in session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Query the database to get user details
        $sql = "SELECT full_name, email, phoneNo, membershipType, status FROM users WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($full_name, $email, $phoneNo, $membershipType, $status);
            $stmt->fetch();
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        // Prepare the SQL statement to update the user profile
        $updateSql = "UPDATE users SET full_name = ?, email = ?, phoneNo = ?, membershipType = ?, status = ? WHERE id = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            // Bind the parameters
            $updateStmt->bind_param("sssssi", $full_name, $email, $phoneNo, $membershipType, $status, $user_id);

            // Execute the statement
            if ($updateStmt->execute()) {
                echo "Profile updated successfully.";
            } else {
                echo "Error updating profile: " . $updateStmt->error;
            }

            // Close the statement
            $updateStmt->close();
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }

    } else {
        echo "User ID is not set in session.";
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

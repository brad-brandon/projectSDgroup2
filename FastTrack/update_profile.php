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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Get the user's ID from the session
    $user_id = $_SESSION['user_id'];

    // Get and sanitize the form data
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phoneNo = $conn->real_escape_string(trim($_POST['phoneNo']));

    // Prepare the SQL statement to update the user profile
    $updateSql = "UPDATE users SET full_name = ?, email = ?, phoneNo = ? WHERE id = ?";
    
    if ($updateStmt = $conn->prepare($updateSql)) {
        // Bind the parameters
        $updateStmt->bind_param("sssi", $full_name, $email, $phoneNo, $user_id);

        // Execute the statement
        if ($updateStmt->execute()) {
			header("Location: viewprofile.php");
    exit();
           
        } else {
            echo "Error updating profile: " . $updateStmt->error;
			echo '<a href="viewprofile.php" class="or-login">OK</a>';
        }

        // Close the statement
        $updateStmt->close();
    } else {
        echo "Error preparing update statement: " . $conn->error;
    }

} else {
    echo "Invalid request or session not set.";
}

// Close the connection
$conn->close();
?>

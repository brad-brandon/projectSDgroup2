<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";  
$password = "root";
$dbname = "fasttrack_gym";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in first! User ID is not set.");
}

// Check if class_id is set in the session
if (!isset($_SESSION['id'])) {
    die("Error: Please select a class first. Class ID is not set.");
}

// Get user_id and class_id from session
$user_id = $_SESSION['user_id'];
$class_id = $_SESSION['id'];

// Check for existing booking with the same user_id and class_id
$checkSql = "SELECT * FROM bookings_table WHERE user_id = ? AND id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $user_id, $class_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Duplicate booking found
    echo "<h2>Booking Failed: Duplicate Entry</h2>";
    echo "<p>You have already booked this class. Please check your booking history.</p>";
    echo "<p><a href='view-booking-history.php'>View Your Booking History</a></p>";
} else {
    // Proceed with booking insertion
    $sql = "INSERT INTO bookings_table (user_id, id, status) VALUES (?, ?, 'confirmed')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters (user_id and class_id)
        $stmt->bind_param("ii", $user_id, $class_id);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            // Booking successful
            echo "<h2>Class successfully booked!</h2>";
            echo "<p>Your booking has been confirmed.</p>";
            echo "<p><a href='customer.php'>Go back to main page</a></p>";

            // Update class capacity and current bookings in class_schedule
            $updateSql = "
                UPDATE class_schedule 
                SET current_bookings = current_bookings + 1, 
                    capacity = capacity - 1 
                WHERE id = ? AND capacity > 0";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $class_id);
            $updateStmt->execute();

            // Check if the update was successful
            if ($updateStmt->affected_rows > 0) {
                echo "<p>Class capacity and current bookings updated successfully.</p>";
            } else {
                echo "<p>Error: Could not update class capacity. The class may be full.</p>";
            }

            // Close update statement
            $updateStmt->close();
        } else {
            echo "<h2>Error: Booking failed.</h2>";
            echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

// Close the statements and connection only if they were initialized
if (isset($checkStmt)) {
    $checkStmt->close();
}
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>

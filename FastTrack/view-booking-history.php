<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
</head>
<body>

<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
require 'config.php';

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in first!");
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Prepare the SQL statement to fetch booking history
$sql = "SELECT b.booking_id, b.created_at, c.class_name, b.status 
        FROM bookings_table b 
        JOIN class_schedule c ON b.id = c.id 
        WHERE b.user_id = ? 
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);

// Check for SQL preparation errors
if (!$stmt) {
    die("SQL prepare failed: " . htmlspecialchars($conn->error));
}

// Bind the user_id parameter
$stmt->bind_param("i", $user_id);

// Execute the statement
if (!$stmt->execute()) {
    die("SQL execute failed: " . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();

// Check if the user has any bookings
if ($result->num_rows > 0) {
    echo "<h2>Your Booking History</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Booking ID</th>
            <th>Class Name</th>
            <th>Booking Date</th>
            <th>Status</th>
          </tr>";
    
    // Fetch and display each booking
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<h2>No bookings found.</h2>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<!-- Back button -->
<button onclick="window.location.href='customer.php'">Back</button>
</body>
</html>

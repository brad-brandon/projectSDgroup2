<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";  // Adjust your database credentials
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

// Debugging: Print user ID and class ID
echo "User ID: " . $user_id . "<br>";
echo "Class ID: " . $class_id . "<br>";

// Prepare the SQL statement to insert a new booking
$sql = "INSERT INTO bookings_table (user_id, id, status) VALUES (?, ?, 'confirmed')";
$stmt = $conn->prepare($sql);

// Check if statement preparation was successful
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters (user_id and class_id)
$stmt->bind_param("ii", $user_id, $class_id);

// Execute the statement and check for success
try {
    if ($stmt->execute()) {
        // Booking successful, display confirmation
        echo "<h2>Class successfully booked!</h2>";
        echo "<p>Your booking has been confirmed.</p>";
        echo "<p><a href='customer.php'>Go back to class selection</a></p>";
    }
} catch (mysqli_sql_exception $e) {
    // Handle duplicate entry error
    if ($e->getCode() == 1062) { // 1062 is the SQL error code for duplicate entries
        echo "<h2>Booking Failed: Duplicate Entry</h2>";
        echo "<p>You have already booked this class. Please check your booking history.</p>";
        echo "<p><a href='view-booking-history.php'>View Your Booking History</a></p>";
    } else {
        // Handle other SQL errors
        echo "<h2>Error: Booking failed.</h2>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
}


// Close the statement and connection
$stmt->close();
$conn->close();
?>

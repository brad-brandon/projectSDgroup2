<?php
session_start();

// Enable error reporting
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #ff5f6d, #ffc371);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Header Section */
        .header-section {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            text-align: center;
            z-index: 10; /* Ensures the header is above other content */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .header-section .logo img {
            max-width: 150px;
            height: auto;
        }

        /* Container Styling */
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px 30px;
            border-radius: 10px;
            max-width: 700px;
            width: 90%;
            margin-top: 100px; /* Offset to make space for the fixed header */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* Table and Button Styling */
        h2 {
            color: #ffc371;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }
        th {
            background-color: rgba(255, 95, 109, 0.8);
        }
        td {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .no-bookings {
            font-size: 18px;
            color: #ffc371;
        }
        .back-button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #ff5f6d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #ffc371;
        }
    </style>
        <header class="header-section">
        <div class="logo">
            <a href ="./customer.html">
                <img src="img/logo3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
</head>
<body>
<div class="container">

<?php
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
            echo "<a href='customer.php' class='button'>Go back to main page</a>";

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

</div>
</body>
</html>
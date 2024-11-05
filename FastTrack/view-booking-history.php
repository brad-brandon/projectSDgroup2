<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
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
            <a href ="./customer.php">
                <img src="img/logo3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
</head>
<body>

<div class="container">
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
$sql = "SELECT b.booking_id, b.created_at, c.class_name, b.status, c.start_time,c.end_time, c.day_of_week
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
    echo "<table>";
    echo "<tr>
            <th>Booking ID</th>
            <th>Class Name</th>
            <th>Booking Date</th>
            <th>Status</th>
			<th>start time</th>
            <th>end time</th>
			<th>Day of week</th>
          </tr>";
    
    // Fetch and display each booking
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
		echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
        echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
		echo "<td>" . htmlspecialchars($row['day_of_week']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<h2 class='no-bookings'>No bookings found.</h2>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
    <!-- Back button -->
    <button class="back-button" onclick="window.location.href='customer.php'">Back</button>
</div>

</body>
</html>
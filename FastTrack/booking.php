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

// Function to get user's subscription type
function getUserSubscriptionType($conn, $user_id) {
    $subscriptionQuery = "SELECT membership_type FROM users WHERE id = ?";
    $subscriptionStmt = $conn->prepare($subscriptionQuery);
    $subscriptionStmt->bind_param("i", $user_id);
    $subscriptionStmt->execute();
    $subscriptionResult = $subscriptionStmt->get_result();

    $subscription = $subscriptionResult->num_rows > 0 ? $subscriptionResult->fetch_assoc()['membership_type'] : null;
    $subscriptionStmt->close();
    return $subscription;
}

// Function to get user's current bookings count
function getUserBookingsCount($conn, $user_id) {
    $bookingCountQuery = "SELECT bookings_count FROM users WHERE id = ?";
    $bookingCountStmt = $conn->prepare($bookingCountQuery);
    
    if ($bookingCountStmt) {
        $bookingCountStmt->bind_param("i", $user_id);
        $bookingCountStmt->execute();
        $bookingCountResult = $bookingCountStmt->get_result();
        $row = $bookingCountResult->fetch_assoc();
        $bookingCountStmt->close();
        
        return $row['bookings_count'];
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

// Function to check if user has reached their booking limit
function hasReachedBookingLimit($subscription, $bookings_count) {
    switch ($subscription) {
        case 'student':
            $bookingLimit = 3;
            break;
        case 'normal':
            $bookingLimit = 5;
            break;
        case 'advanced':
            return false; // Unlimited bookings
        default:
            return true; // Unknown subscription type, deny booking
    }

    return $bookings_count >= $bookingLimit;
}

// Check subscription and booking limit
$subscription = getUserSubscriptionType($conn, $user_id);
$currentBookingsCount = getUserBookingsCount($conn, $user_id);

if (hasReachedBookingLimit($subscription, $currentBookingsCount)) {
    echo "<h2>Booking Failed: Limit Reached</h2>";
    echo "<p>You have reached the booking limit for your subscription plan. Please check your booking history or upgrade your plan.</p>";
    echo "<p><a href='view-booking-history.php'>View Your Booking History</a></p>";
    exit;
}

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
    exit;
}

// Check class capacity before inserting booking
$capacityCheckSql = "SELECT capacity FROM class_schedule WHERE id = ? AND capacity > 0";
$capacityCheckStmt = $conn->prepare($capacityCheckSql);
$capacityCheckStmt->bind_param("i", $class_id);
$capacityCheckStmt->execute();
$capacityCheckResult = $capacityCheckStmt->get_result();

if ($capacityCheckResult->num_rows > 0) {
    // Proceed with booking insertion
    $sql = "INSERT INTO bookings_table (user_id, id, status) VALUES (?, ?, 'confirmed')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $class_id);

        if ($stmt->execute()) {
            // Booking successful
            echo "<h2>Class successfully booked!</h2>";
            echo "<p>Your booking has been confirmed.</p>";
            echo "<a href='customer.php' class='button'>Go back to main page</a>";

            // Increment user's bookings_count in users table
            $updateUserBookingCountSql = "UPDATE users SET bookings_count = bookings_count + 1 WHERE id = ?";
            $updateUserBookingCountStmt = $conn->prepare($updateUserBookingCountSql);
            $updateUserBookingCountStmt->bind_param("i", $user_id);
            $updateUserBookingCountStmt->execute();
            $updateUserBookingCountStmt->close();

            // Update class capacity and current bookings in class_schedule
            $updateSql = "
                UPDATE class_schedule 
                SET current_bookings = current_bookings + 1, 
                    capacity = capacity - 1 
                WHERE id = ? AND capacity > 0";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $class_id);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                echo "<p>Class capacity and current bookings updated successfully.</p>";
            } else {
                echo "<p>Error: Could not update class capacity. The class may be full.</p>";
            }

            $updateStmt->close();
        } else {
            echo "<h2>Error: Booking failed.</h2>";
            echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    echo "<h2>Booking Failed: Class Full</h2>";
    echo "<p>This class is already fully booked. Please select another class.</p>";
}

$capacityCheckStmt->close();
$conn->close();
?>

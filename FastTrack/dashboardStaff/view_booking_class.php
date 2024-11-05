<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch bookings with class names
$sql = "SELECT b.booking_id, b.user_id, b.created_at, b.status, cs.class_name 
        FROM bookings_table b
        JOIN class_schedule cs ON b.id = cs.id";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastTrack - View Bookings</title>
    <link rel="stylesheet" href="css/view_booking_class.css">
</head>
<body>

<h1> View Bookings</h1>

<a href="staff_dashboard.php" class="back-button">Back to Dashboard</a>

<?php if ($result->num_rows > 0): ?>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Booking Date</th>
            <th>Class Name</th> <!-- Show class_name from class_schedule -->
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['class_name']; ?></td> <!-- Display class_name -->
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No bookings found.</p>
<?php endif; ?>

<?php
$conn->close();
?>

</body>
</html>

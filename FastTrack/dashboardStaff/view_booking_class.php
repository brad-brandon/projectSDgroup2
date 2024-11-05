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

// Query to fetch bookings with class names, user full_name, and email
$sql = "SELECT b.booking_id, b.user_id, b.created_at, b.status, cs.class_name, u.full_name, u.email, cs.start_time,cs.end_time, cs.day_of_week
        FROM bookings_table b
        JOIN class_schedule cs ON b.id = cs.id
        JOIN users u ON b.user_id = u.id";
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
            <th>Full Name</th>
            <th>Email</th>
            <th>Booking Date</th>
            <th>Class Name</th>
            <th>Status</th>
			<th>start time</th>
            <th>end time</th>
			<th>Day of week</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['full_name']; ?></td> <!-- Display full_name -->
                <td><?php echo $row['email']; ?></td> <!-- Display email -->
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
				<td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['end_time']; ?></td>
                <td><?php echo $row['day_of_week']; ?></td>
			
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

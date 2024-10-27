<!DOCTYPE html>
<html lang="en">
<?php 
session_start(); 
$servername = "localhost";
$username = "root";  // adjust your database credentials
$password = "root";
$dbname = "fasttrack_gym";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// Fetch class schedule from database
$sql = "SELECT id, class_name, day_of_week, time_slot FROM class_schedule";
$result = $conn->query($sql);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Class Booking</title>
    <link rel="stylesheet" href="css/bookTrainingClass.css" type="text/css">
</head>
<body>

    <!-- Class Time Section Begin -->
    <section class="classtime-section class-time-table spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Classtime Table</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="timetable-controls">
                        <ul>
                            <li class="active" data-tsfilter="all">All Classes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="classtime-table">
                <table>
                    <thead>
                        <tr>
							<th>Class Name</th>
							<th>Day</th>
							<th>Time</th>
							<th>Select</th>
						</tr>
                    </thead>
                    <tbody>
                        <?php 
						
						if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                <td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
                <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                <td>
                    <form action="submit-booking.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Select</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No classes available</td>
        </tr>
    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Booking Form -->
   <!--<section class="booking-form-section">
        <div class="container">
            <div class="booking-form">
                <h3>Book Your Class</h3>
                <form action="submit-booking.php" method="post">
                    <label for="class-type">Choose a Class:</label>
                    <select name="class-type" id="class-type" required>
                        <option value="hypertrophy">Hypertrophy</option>
                        <option value="hiit">HIIT</option>
                        <option value="powerlifting">Powerlifting</option>
                        <option value="zumba">ZUMBA</option>
                    </select>

                    <label for="date">Choose a Date:</label>
                    <input type="date" name="date" id="date" required>

                    <label for="time">Choose a Time:</label>
                    <select name="time" id="time" required>
                        <option value="10.00">10.00</option>
                        <option value="14.00">14.00</option>
                        <option value="16.00">16.00</option>
                        <option value="18.00">18.00</option>
                        <option value="20.00">20.00</option>
                    </select>

                    <button type="submit" class="primary-btn">Book Now</button>
                </form>
            </div>
        </div>
    </section>-->

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/bookTrainingClass.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Class Booking</title>
	<style>
	.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    padding: 10px 15px;
    margin: 0 5px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.pagination a.active {
    background: #0056b3;
}

.pagination a:hover {
    background: #0056b3;
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

<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Pagination Variables
$classes_per_page = 10; // Number of classes to display per page
$total_classes_query = "SELECT COUNT(*) AS total FROM class_schedule";
$total_classes_result = $conn->query($total_classes_query);
$total_classes_row = $total_classes_result->fetch_assoc();
$total_classes = $total_classes_row['total'];

$total_pages = ceil($total_classes / $classes_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($total_pages, $current_page)); // Ensure the current page is within the range

$offset = ($current_page - 1) * $classes_per_page;

// Fetch classes with capacity and availability status
$sql = "
    SELECT cs.id, cs.class_name, cs.day_of_week, cs.time_slot, cs.capacity, 
           COUNT(b.booking_id) AS current_bookings
    FROM class_schedule cs
    LEFT JOIN bookings_table b ON cs.id = b.id AND b.status = 'confirmed'
    GROUP BY cs.id, cs.class_name, cs.day_of_week, cs.time_slot, cs.capacity
    LIMIT $offset, $classes_per_page
";
$result = $conn->query($sql);

if (!$result) {
    die("SQL query failed: " . $conn->error);
}
?>
<!-- Class Schedule Section -->
<section class="classtime-section class-time-table spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Class Schedule and Availability</h2>
                </div>
            </div>
        </div>

        <!-- Class Schedule Table -->
        <div class="classtime-table">
            <table class="myTable">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Capacity</th>
                        <th>Current Bookings</th>
                        <th>Status</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <?php 
                                $status = ($row['current_bookings'] < $row['capacity']) ? "Available" : "Full";
                                $isAvailable = ($status == "Available");
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['class_name']); ?></td>
                                <td><?= htmlspecialchars($row['day_of_week']); ?></td>
                                <td><?= htmlspecialchars($row['time_slot']); ?></td>
                                <td><?= htmlspecialchars($row['capacity']); ?></td>
                                <td><?= htmlspecialchars($row['current_bookings']); ?></td>
                                <td><?= $status; ?></td>
                                <td>
                                    <?php if ($isAvailable): ?>
                                        <form action="submit-booking.php" method="post">
                                            <input type="hidden" name="class_id" value="<?= $row['id']; ?>">
                                            <button type="submit">Select</button>
                                        </form>
                                    <?php else: ?>
                                        <button disabled>Full</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No classes available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br>
            <button onclick="window.location.href='customer.php'">Back</button> <!-- Back button for navigation -->
        </div>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i; ?>" class="<?= ($i === $current_page) ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</section>

</body>
</html>
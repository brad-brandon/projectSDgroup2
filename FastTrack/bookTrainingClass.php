<?php
session_start(); 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in first!");
}

$user_id = $_SESSION['user_id'];

// Function to get user's subscription type and status
function getUserSubscriptionTypeAndStatus($conn, $user_id) {
    $query = "SELECT membership_type, status, bookings_count FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fetch user's subscription type, status, and current booking count
$userInfo = getUserSubscriptionTypeAndStatus($conn, $user_id);
if (!$userInfo) {
    die("Error: Unable to retrieve user information.");
}

$subscription = $userInfo['membership_type'];
$status = $userInfo['status']; // Get user's status
$currentBookingsCount = $userInfo['bookings_count'];

// Check user's status before proceeding
if ($status !== 'active') {
    echo "<h2>Booking Failed: Subscription Required</h2>";
    echo "<p>Your account is currently inactive. To enjoy our classes, we invite you to subscribe to one of our plans.</p>";
    echo "<p><a href='membership.html'>Subscribe Now</a></p> <a href='customer.php' class='button'>Go back to main page</a>"; // Link to subscription page
    exit;
}

// Set booking limits based on subscription type
switch ($subscription) {
    case 'student':
        $bookingLimit = 3;
        break;
    case 'normal':
        $bookingLimit = 5;
        break;
    case 'advanced':
        $bookingLimit = PHP_INT_MAX; // Unlimited
        break;
    default:
        $bookingLimit = 0; // No limit defined
}

// Calculate remaining classes user can book
$remainingClasses = max(0, $bookingLimit - $currentBookingsCount);

// Pagination Variables
$classesPerPage = 10; // Number of classes to display per page
$totalClassesQuery = "SELECT COUNT(*) AS total FROM class_schedule";
$totalClassesResult = $conn->query($totalClassesQuery);
$totalClassesRow = $totalClassesResult->fetch_assoc();
$totalClasses = $totalClassesRow['total'];

$totalPages = ceil($totalClasses / $classesPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($totalPages, $currentPage)); // Ensure the current page is within the range

$offset = ($currentPage - 1) * $classesPerPage;

// Fetch classes with capacity and availability status
$sql = "
    SELECT cs.id, cs.class_name, cs.day_of_week, cs.time_slot, cs.capacity, 
           COUNT(b.booking_id) AS current_bookings
    FROM class_schedule cs
    LEFT JOIN bookings_table b ON cs.id = b.id AND b.status = 'confirmed'
    GROUP BY cs.id, cs.class_name, cs.day_of_week, cs.time_slot, cs.capacity
    LIMIT $offset, $classesPerPage
";
$result = $conn->query($sql);

if (!$result) {
    die("SQL query failed: " . $conn->error);
}
?>

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
            <a href ="./customer.php">
                <img src="img/logo3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
</head>
<body>

<!-- Class Schedule Section -->
<section class="classtime-section class-time-table spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Class Schedule and Availability</h2>
                </div>
                <p>You can still book <?= $remainingClasses; ?> class<?= $remainingClasses !== 1 ? 'es' : ''; ?> based on your subscription.</p>
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
                                    <?php if ($isAvailable && $remainingClasses > 0): ?>
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
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>" class="<?= ($i === $currentPage) ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</section>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
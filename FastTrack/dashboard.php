<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "Webs392024";
$password = "Webs392024";
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Query the database to get user details
$sql = "SELECT full_name, email, user_type FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $user_type);
$stmt->fetch();
$stmt->close();

// Query the database to get customer subscriptions (example data)
$subscriptions = [
    ['name' => 'Member 1', 'status' => 'Active'],
    ['name' => 'Member 2', 'status' => 'Inactive'],
    ['name' => 'Member 3', 'status' => 'Active']
];

// Query the database to get admin and staff details (example data)
$admins_and_staff = [
    ['name' => 'Wong', 'age' => 21],
    ['name' => 'Edmund', 'age' => 21],
    ['name' => 'Bradley', 'age' => 20],
    ['name' => 'Ash', 'age' => 20],
    ['name' => 'Airil', 'age' => 20],
    ['name' => 'Syafiq', 'age' => 22]
];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="header-section">
        <div class="logo">
            <a href="./staff.html">
                <img src="img/logo3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
        <h1>Staff Dashboard</h1>				
		<div class="switch-login">
            <a href="staff.html" class="or-login">Back to Homepage</a>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-wrap">
            <div class="dashboard-sections">
                <!-- Customer Subscriptions Section -->
                <div class="section subscription-status">
                    <h3>Customer Subscriptions</h3>
                    <ul>
                        <?php foreach ($subscriptions as $subscription): ?>
                            <li><?php echo htmlspecialchars($subscription['name']) . ": " . htmlspecialchars($subscription['status']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Admin and Staff Section -->
                <div class="section class-schedule">
                    <h3>Admin and Staff</h3>
                    <ul>
                        <?php foreach ($admins_and_staff as $staff): ?>
                            <li><?php echo htmlspecialchars($staff['name']) . ($staff['age'] ? ", " . htmlspecialchars($staff['age']) : ""); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Log Out Button -->
            <div class="logout-section">
                <a href="logout.php" class="site-btn">Log Out</a>
            </div>

        </div>
    </div>

    <div class="footer-section">
        <p>&copy; 2024 Gym. All rights reserved.</p>
    </div>
</body>
</html>


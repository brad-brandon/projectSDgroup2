<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection settings
include 'db_connect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Query the database to get user details
$sql = "SELECT full_name, email, user_type, phoneNo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $user_type, $phoneNo);
$stmt->fetch();
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/viewprofile.css" type="text/css">

</head>
<body>

<header class="header-section">
    <div class="logo">
        <a href="./index.html">
            <img src="img/logo3.png" alt="FastTrack Gym Logo">
        </a>
    </div>
</header>

<div class="profile-container">
    <div class="profile-wrap">
        <h1 class="profile-name">Name : <?php echo htmlspecialchars($full_name); ?> </h1>

        <div class="profile-info">
            <h3>Contact Information</h3>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Phone: <?php echo htmlspecialchars($phoneNo); ?></p>
        </div>

        <!-- Edit Profile Button -->
        <button class="edit-profile-btn" onclick="toggleEditForm()">Edit Profile</button>
		

        <!-- Edit Profile Form -->
        <div id="edit-profile-form" style="display: none;">
            <form action="update_profileAdmin.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="full_name" name="full_name" required value="<?php echo htmlspecialchars($full_name); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"  required value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phoneNo" name="phoneNo"  required value="<?php echo htmlspecialchars($phoneNo); ?>">
                </div>
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
		
		<br></br>

        <!-- Change Password Button -->
        <button class="change-password-btn" onclick="togglePasswordForm()">Change Password</button>

        <!-- Change Password Form -->
        <div id="change-password-form" style="display: none;">
            <form action="change_password.php" method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="save-btn">Change Password</button>
            </form>
        </div>
    </div>
</div>

<div class="footer-section">
    <p>&copy; 2024 FastTrack Gym. All rights reserved.</p>
</div>

<script>
    function toggleEditForm() {
        var form = document.getElementById('edit-profile-form');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

    function togglePasswordForm() {
        var form = document.getElementById('change-password-form');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>

</body>
</html>
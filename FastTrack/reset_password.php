<?php
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if token exists in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Token is valid, allow the user to reset their password
        $stmt->bind_result($user_id);
        $stmt->fetch();
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="FastTrack Gym Sign Up">
    <meta name="keywords" content="Gym, Fitness, Sign Up">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FastTrack Gym | Reset Password</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/login.css" type="text/css">
    <link rel="stylesheet" href="css/signup.css" type="text/css">

</head>

<body>

    <!-- Header Section Begin -->
        <div class="logo">
            <a href="./index.html">
                <img src="img/logo3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
    <!-- Header End -->

    <!-- Sign Up Section Begin -->
<section class="login-section">
        <div class="login-form-wrap">
            <h3>Reset Password</h3>

			<form action="update_password.php" method="POST" class="login-form">

                <div class="group-input">
				<input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" minlength="8" required>
                </div>
				<div class="group-input">
				<input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="site-btn">Reset Password</button>
            </form>

            <!-- Add the links here -->
            <div class="switch-signup">
                <span>Already have an account?</span> 
                <a href="./login.html" class="or-login">Login</a>
            </div>

            <div class="switch-login">
                <a href="./index.html" class="or-home">Back to Homepage</a>
            </div>
            <!-- End of added links -->

        </div>
   </section>
    <!-- Sign Up Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <p>&copy; 2024 FastTrack Gym. All rights reserved.</p>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>

        <?php
    } else {
        echo "Invalid or expired reset token.";
    }
    $stmt->close();
} else {
    echo "No reset token provided.";
}

$conn->close();
?>

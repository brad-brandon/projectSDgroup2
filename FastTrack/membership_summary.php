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
$sql = "SELECT full_name, email, phoneNo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phoneNo);
$stmt->fetch();
$stmt->close();

// Get the selected membership type from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membership = $_POST['membership'];
    $price = 0;

    switch ($membership) {
        case 'student':
            $price = 80;
            break;
        case 'normal':
            $price = 120;
            break;
        case 'advanced':
            $price = 280;
            break;
        default:
            echo "Invalid membership selected.";
            exit;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Summary</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/summary.css">
</head>

<body>

<header class="header-section">
    <div class="logo">
        <a href="./customer.html">
            <img src="img/logo3.png" alt="FastTrack Gym Logo">
        </a>
    </div>
</header>

<div class="profile-container">
    <div class="profile-wrap">
        <h1 class="profile-name">Full Name :<?php echo htmlspecialchars($full_name); ?> </h1>

        <div class="profile-info">
            <h3>Your Full Information</h3>
        </div>

        <div class ="full-info">
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Phone: <?php echo htmlspecialchars($phoneNo); ?></p>
            <p><strong>Membership Type:</strong> <?php echo ucfirst($membership); ?> Membership</p>
            <p><strong>Total Price:</strong> RM <?php echo $price; ?> / Monthly</p>
        </div>

    <!-- Payment button that redirects to Toyyibpay -->
    <form action="toyyibpay_payment.php" method="POST">
        <input type="hidden" name="membership" value="<?php echo $membership; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">
        <button type="submit" class="pay-btn">Proceed to Payment</button>
    </form>
</div>
</body>
</html>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection settings
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name, email, phoneNo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phoneNo);
$stmt->fetch();
$stmt->close();

// Membership selection and price
$membership = '';
$price = 0;
$categoryPlan='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membership = $_POST['membership'];

    switch ($membership) {
        case 'student':
            $price = 80;
			$categoryPlan='qioxmes8';
            break;
        case 'normal':
            $price = 120;
			$categoryPlan='6f01fm90';
            break;
        case 'advanced':
            $price = 280;
			$categoryPlan='fbk4j9qu';
            break;
        case 'test':
            $price = 1;
			$categoryPlan='6gt1y6y6';
            break;
        default:
            echo "Invalid membership selected.";
            exit;
    }
}

// Close the database connection
$conn->close();

// Proceed to payment and create a bill with ToyyibPay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $billData = [
        'userSecretKey' => 'bxvrdepp-k077-t27p-qt5o-kohis82ooitl',
        'categoryCode' => $categoryPlan,
        'billName' => ucfirst($membership) . " Membership",
        'billDescription' => ucfirst($membership) . " Membership Payment",
        'billPriceSetting' => 1,
		'billPayorInfo' => 1,
        'billAmount' => $price * 100, // Convert to cents
        'billReturnUrl' => 'http://fasttrackgym.shop/FastTrack/payment_return.php',
        'billCallbackUrl' => '',
        'billExternalReferenceNo' => 'AFR341DFI',
        'billTo' => $full_name,
        'billEmail' => $email,
        'billPhone' => $phoneNo,
        'billSplitPayment' => 0,
        'billSplitPaymentArgs' => '',
        'billPaymentChannel' => '0',
        'billContentEmail' => 'Thank you for purchasing our product!',
        'billChargeToCustomer' => 1
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $billData);

    $response = curl_exec($curl);
    curl_close($curl);

    // Decode and display the response for debugging
    $bill = json_decode($response, true);

    // Check if response contains BillCode, else show the error response
    if (isset($bill[0]['BillCode'])) {
        // Redirect to the payment link
        header('Location: https://dev.toyyibpay.com/' . $bill[0]['BillCode']);
        exit;
    } else {
        // Show the full response for debugging
        echo 'Error creating payment bill. Full response: ' . htmlspecialchars($response);
    }
}
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
        <a href="./customer.php">
            <img src="img/LOGO3.png" alt="FastTrack Gym Logo">
        </a>
    </div>
</header>

<div class="profile-container">
    <div class="profile-wrap">
        <h1 class="profile-name">Full Name: <?php echo htmlspecialchars($full_name); ?></h1>

        <div class="profile-info">
            <h3>Your Full Information</h3>
        </div>

        <div class="full-info">
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Phone: <?php echo htmlspecialchars($phoneNo); ?></p>
            <p><strong>Membership Type:</strong> <?php echo ucfirst($membership); ?> Membership</p>
            <p><strong>Total Price:</strong> RM <?php echo $price; ?> / Monthly</p>
        </div>

        <!-- Button to proceed to payment -->
        <form method="post" action="">
            <input type="hidden" name="membership" value="<?php echo $membership; ?>">
            <button type="submit" class="pay-btn">Proceed to Payment</button>
        </form>
    </div>
</div>
</body>
</html>

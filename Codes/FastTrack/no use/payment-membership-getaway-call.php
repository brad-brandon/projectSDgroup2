<?php
// Database connection settings
require 'config.php';

// Start session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's ID from the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];

// Query the database to get user details
$sql = "SELECT full_name, email, phoneNo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phoneNo);
$stmt->fetch();
$stmt->close();

// Check if membership type and price are passed through POST
if (!isset($_POST['membership']) || !isset($_POST['price'])) {
    die("Membership type or total price not provided.");
}

// Assuming membership type and price are passed through POST
$membership_type = $_POST['membership'];
$price = $_POST['price'];

// Determine the ToyyibPay category code and bill name based on the membership type
switch ($membership_type) {
    case 'student':
        $categoryCode = 'wmblp2jj';
        $billName = 'Payment for Student Membership';
        break;
    case 'normal':
        $categoryCode = '6ka3gs1v';
        $billName = 'Payment for Normal Membership';
        break;
    case 'advanced':
        $categoryCode = 'rn8qqrxy';
        $billName = 'Payment for Advanced Membership';
        break;
    default:
        die("Invalid membership type selected.");
}

// Convert RM to cents (RM1 = 100 cents)
$rmx100 = $price * 100;

$some_data = array(
    'userSecretKey'=> 'g2l4vqtn-1h7u-hpss-rsj5-r7xwckpz9bqs',
    'categoryCode'=> $categoryCode,  // Use the dynamic category code
    'billName'=> $billName,          // Use the dynamic bill name
    'billDescription'=> 'Subscription for membership: RM'.$price,
    'billPriceSetting'=> 1,
    'billPayorInfo'=> 1,
    'billAmount'=> $rmx100,
    'billReturnUrl' => 'https://fasttrackgym.online/payment-success.php',
    'billCallbackUrl'=> '',  // Optional callback URL
    'billExternalReferenceNo'=> '',  // Optional external reference
    'billTo'=> $full_name,           // Using the full name from the database
    'billEmail'=> $email,            // Using the email from the database
    'billPhone'=> $phoneNo,          // Using the phone number from the database
    'billSplitPayment'=> 0,
    'billSplitPaymentArgs'=> '',
    'billPaymentChannel'=> 0,
);

// Initialize cURL session
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
$result = curl_exec($curl);

// Handle cURL errors
if ($result === false) {
    die('cURL error: ' . curl_error($curl));
}

$info = curl_getinfo($curl);
curl_close($curl);

// Decode the JSON response
$obj = json_decode($result, true);

// Handle case when no BillCode is returned
if (!isset($obj[0]['BillCode'])) {
    die("Failed to generate payment bill: " . (isset($obj['message']) ? $obj['message'] : 'Unknown error.'));
}

// Get the BillCode
$billcode = $obj[0]['BillCode'];

// Redirect to ToyyibPay payment page
header("Location: https://toyyibpay.com/$billcode");
exit();
?>
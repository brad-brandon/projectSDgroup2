<?php
// Database connection settings
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['confirm-pass'];

    if ($password !== $confirm_password) {
        header("Location: verify_result.php?message=" . urlencode("Your password does not match, please try again."));
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification token
    $verification_token = bin2hex(random_bytes(16));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phoneNo, verification_token) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $phoneNo, $verification_token);

    try {
        if ($stmt->execute()) {
            // Send verification email
            $verification_link = "https://fasttrackgym.shop/FastTrack/verify.php?token=" . $verification_token;
            $subject = "Verify Your Email Address";
            $message = "Hello $full_name,\n\nPlease click the link below to verify your email address:\n$verification_link\n\nThank you!";
            $headers = "From: no-reply@fasttrackgym.shop";

            if (mail($email, $subject, $message, $headers)) {
                header("Location: verify_result.php?message=" . urlencode("A verification email has been sent to your email address."));
                exit();
            } else {
                header("Location: verify_result.php?message=" . urlencode("Failed to send verification email."));
                exit();
            }
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            // Duplicate entry error
            header("Location: verify_result.php?message=" . urlencode("This email address is already registered. Please use a different email."));
            exit();
        } else {
            echo "Error: " . $e->getMessage();
        }
    }

    $stmt->close();
}

$conn->close();
?>

<?php
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    if (!empty($token)) {
        // Prepare and execute
        $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND verified = 0");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Token is valid, verify the user
            $stmt->bind_result($user_id);
            $stmt->fetch();

            $stmt->close();

            $stmt = $conn->prepare("UPDATE users SET verified = 1, verification_token = NULL WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                // Redirect to success page
                header("Location: verify_result.php?message=" . urlencode("Your email has been verified! You can now log in."));
                exit();
            } else {
                // Redirect to error page
                header("Location: verify_result.php?message=" . urlencode("Failed to verify email. Please try again."));
                exit();
            }
        } else {
            // Invalid or expired token
            header("Location: verify_result.php?message=" . urlencode("Invalid or expired verification link."));
            exit();
        }
    } else {
        // Invalid token
        header("Location: verify_result.php?message=" . urlencode("Invalid verification token."));
        exit();
    }
} else {
    // No token provided
    header("Location: verify_result.php?message=" . urlencode("No verification token provided."));
    exit();
}

$conn->close();
?>

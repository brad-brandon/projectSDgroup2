<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
		header("Location: verify_result.php?message=" . urlencode("Passwords do not match."));
                exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password for the user with the reset token
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $hashed_password, $token);

    if ($stmt->execute() && $stmt->affected_rows > 0) {

        // echo "Password reset successful! You can now <a href='login.html'>log in</a>."
				header("Location: login.html");
    } else {
		header("Location: verify_result.php?message=" . urlencode("Invalid or expired reset token."));
                exit();

    }

    $stmt->close();
}

$conn->close();
?>

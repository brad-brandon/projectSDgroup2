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
    $email = $_POST['email'];

    // Generate reset token
    $reset_token = bin2hex(random_bytes(16));

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the reset token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->bind_param("ss", $reset_token, $email);
        $stmt->execute();

        // Prepare reset link
        $reset_link = "http://localhost/projectSDgroup2/FastTrack/reset_password.php?token=" . $reset_token;

        // Send reset email
        $subject = "Password Reset Request";
        $message = "Hello,\n\nPlease click the link below to reset your password:\n$reset_link\n\nThe link will expire in 1 hour.";
        $headers = "From: no-reply@fasttrackgym.com";

        if (mail($email, $subject, $message, $headers)) {
			header("Location: verify_result.php?message=" . urlencode("A password reset link has been sent to your email address, please check your email."));
                exit();

        } else {
			header("Location: verify_result.php?message=" . urlencode("Failed to send reset email."));
                exit();
        }
    } else {
		header("Location: verify_result.php?message=" . urlencode("No account found with that email."));
                exit();
        //echo "No account found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>

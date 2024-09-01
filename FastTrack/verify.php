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
                echo "Your email has been verified! You can now log in.";
            } else {
                echo "Failed to verify email.";
            }
        } else {
            echo "Invalid or expired verification link.";
        }
    } else {
        echo "Invalid verification token.";
    }
} else {
    echo "No verification token provided.";
}

$conn->close();
?>

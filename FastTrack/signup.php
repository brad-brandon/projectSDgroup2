
<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['confirm-pass'];

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification token
    $verification_token = bin2hex(random_bytes(16));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, verification_token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $verification_token);

    if ($stmt->execute()) {
        // Send verification email
        //$verification_link = "http://yourdomain.com/verify.php?token=" . $verification_token;
$verification_link = "http://localhost/projectSDgroup2/FastTrack/verify.php?token=" . $verification_token;

// or if using an IP address
// $verification_link = "http://127.0.0.1/projectSDgroup2/FastTrack/verify.php?token=" . $verification_token;

        $subject = "Verify Your Email Address";
        $message = "Hello $full_name,\n\nPlease click the link below to verify your email address:\n$verification_link\n\nThank you!";
        $headers = "From: no-reply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A verification email has been sent to your email address.";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

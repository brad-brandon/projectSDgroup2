<?php
// Database connection settings
$servername = "localhost"; // or your server name
$username = "Webs392024"; // your database username
$password = "Webs392024"; // your database password
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
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

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Sign-up successful!";
        header("Location: login.html"); // Redirect to login page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

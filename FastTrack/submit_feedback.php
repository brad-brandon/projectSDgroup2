<?php
$servername = "localhost"; 
$username = "Webs392024"; 
$password = "Webs392024"; 
$dbname = "fasttrack_gym";
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate form data
    if (!empty($name) && !empty($email) && !empty($message)) {
        // You can send this data to a database, email, or log it

        // Example: Sending feedback to an email address
        $to = $email;  // customer email
        $subject = "Feedback from " . $name;
        $headers = "From: wongtienfung@gmail.com\r\n";
        $body = "Thank you for your feedback!\nYou have write a feedback to us:\n\nName: $name\nEmail: $email\nMessage:\n$message";

        mail($to, $subject, $body, $headers);

    }
	// Database connection
$conn = new mysqli("$servername", "$username", "$password", "$dbname");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert feedback into database
$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    header("Location: verify_result.php?message=" . urlencode("Thank you for your feedback!"));
                exit();
}

$stmt->close();
$conn->close();

}
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $classType = htmlspecialchars(trim($_POST['class_type']));
    $classDate = htmlspecialchars(trim($_POST['class_date']));
    $classTime = htmlspecialchars(trim($_POST['time']));

    // Validate input
    if (empty($classType) || empty($classDate) || empty($classTime)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Format the email content
    $to = "your_email@example.com"; // Change to your email address
    $subject = "New Class Booking";
    $message = "You have a new class booking.\n\n" .
               "Class Type: $classType\n" .
               "Class Date: $classDate\n" .
               "Class Time: $classTime\n";

    $headers = "From: no-reply@example.com"; // Change to your desired sender email

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Booking confirmed! A confirmation email has been sent.";
    } else {
        echo "There was an error sending the confirmation email.";
    }

    // Optional: Here you could also save the booking to a database
    // Example: saveToDatabase($classType, $classDate, $classTime);

} else {
    // Redirect to the booking page if the script is accessed directly
    header("Location: index.html"); // Change to your booking page
    exit;
}
?>
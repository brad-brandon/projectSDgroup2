<?php
// add_staff.php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Insert query with user_type explicitly set to 'staff'
    $sql = "INSERT INTO users (full_name, email, phoneNo, password, user_type) 
            VALUES ('$full_name', '$email', '$phoneNo', '$password', 'staff')";

    if ($conn->query($sql) === TRUE) {
        echo "New staff added successfully!";
        header("Location: staff_info.php"); // Redirect back to the staff info page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
</head>
<body>
    <h2>Add New Staff</h2>
    <form method="POST" action="add_staff.php">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phoneNo">Phone No:</label><br>
        <input type="text" id="phoneNo" name="phoneNo" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Add Staff">
    </form>
</body>
</html>

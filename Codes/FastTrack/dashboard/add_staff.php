<?php
// add_staff.php
include 'db_connect.php';

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

    // Insert query with user_type set to 'staff' and verified set to 1 (default)
    $sql = "INSERT INTO users (full_name, email, phoneNo, password, user_type, verified) 
            VALUES ('$full_name', '$email', '$phoneNo', '$password', 'staff', 1)";

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
    
    <link rel="stylesheet" href="css/add_staff.css">
</head>
<body>

    <div class="header-section">
        <h2>Add New Staff</h2>
    </div>

    <div class="form-section">
        <div class="form-wrap">
            <h3>New Staff Registration Form</h3>
            <form method="POST" action="add_staff.php">
                <div class="group-input">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter full name" required>
                </div>
                <div class="group-input">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="group-input">
                    <label for="phoneNo">Phone No:</label>
                    <input type="text" id="phoneNo" name="phoneNo" placeholder="Enter phone number" required>
                </div>
                <div class="group-input">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <input type="submit" class="site-btn" value="Add Staff">

                <div class="">
                    <a href="./index.html" class="btn btn-primary">Back to Dashboard</a>
                </div>

            </form>
        </div>
    </div>

    <div class="footer-section">
        <p>&copy; 2024 FastTrack Gym. All rights reserved.</p>
    </div>

</body>
</html>

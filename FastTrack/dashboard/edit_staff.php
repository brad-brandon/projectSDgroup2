<?php
// edit_staff.php
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

$id = $_GET['id'];

// Fetch current staff data
$sql = "SELECT * FROM users WHERE id = $id AND user_type = 'staff'";
$result = $conn->query($sql);
$staff = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];

    // Update query
    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phoneNo = '$phoneNo' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Staff updated successfully!";
        header("Location: staff_info.php"); // Redirect back to staff info page
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
    <title>Edit Staff</title>
</head>
<body>
    <h2>Edit Staff</h2>
    <form method="POST" action="edit_staff.php?id=<?php echo $id; ?>">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" value="<?php echo $staff['full_name']; ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $staff['email']; ?>" required><br><br>

        <label for="phoneNo">Phone No:</label><br>
        <input type="text" id="phoneNo" name="phoneNo" value="<?php echo $staff['phoneNo']; ?>" required><br><br>

        <input type="submit" value="Update Staff">
    </form>
</body>
</html>

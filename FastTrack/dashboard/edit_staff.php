<?php
// edit_staff.php
include 'db_connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="css/edit_staff.css">
</head>
<body>
    <div class="form-section">
        <div class="form-wrap">
            <h3>Edit Staff</h3>
            <form method="POST" action="edit_staff.php?id=<?php echo $id; ?>">
                <div class="group-input">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo $staff['full_name']; ?>" required>
                </div>

                <div class="group-input">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $staff['email']; ?>" required>
                </div>

                <div class="group-input">
                    <label for="phoneNo">Phone No:</label>
                    <input type="text" id="phoneNo" name="phoneNo" value="<?php echo $staff['phoneNo']; ?>" required>
                </div>

                <input type="submit" value="Update Staff" class="site-btn">
                
                <div class="">
                    <a href="./index.html" class="btn btn-primary">Back to Dashboard</a>
                    <style>
                        body{
                            background-color: #413838;
                        }
                    </style>
                </div>

            </form>
        </div>
    </div>
</body>
</html>


<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "fasttrack_gym";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch customer data based on ID
    $sql = "SELECT full_name, email, phoneNo FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If customer is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
        $email = $row['email'];
        $phoneNo = $row['phoneNo'];
    } else {
        echo "Customer not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

// Update customer details
if (isset($_POST['update'])) {
    $new_full_name = $_POST['full_name'];
    $new_email = $_POST['email'];
    $new_phoneNo = $_POST['phoneNo'];

    // Update query
    $sql_update = "UPDATE users SET full_name = ?, email = ?, phoneNo = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $new_full_name, $new_email, $new_phoneNo, $id);

    if ($stmt_update->execute()) {
        echo "Customer updated successfully!";
        header("Location: customer.php");
        exit();
    } else {
        echo "Error updating customer: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
</head>
<body>
    <h2>Edit Customer</h2>
    <form method="post" action="">
        <label for="full_name">Name:</label>
        <input type="text" name="full_name" value="<?php echo $full_name; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br>
        <label for="phoneNo">Phone No:</label>
        <input type="text" name="phoneNo" value="<?php echo $phoneNo; ?>" required><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

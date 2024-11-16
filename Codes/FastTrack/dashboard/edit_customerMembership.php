<?php
// Database connection
include 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch customer data based on ID
    $sql = "SELECT full_name, email, phoneNo, membership_type, Status FROM users WHERE id = ?";
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
		$membership_type = $row['membership_type'];
        $Status = $row['Status'];
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
	$new_membership_type = $_POST['membership_type'];
    $new_Status = $_POST['Status'];
    // Update query
    $sql_update = "UPDATE users SET membership_type = ?, Status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $new_membership_type, $new_Status, $id);

    if ($stmt_update->execute()) {
        echo "Customer updated successfully!";
        header("Location: form.php");
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
    <title>Edit Customer Membership</title>
    <link rel = "stylesheet" href = "css/edit_customer.css">
</head>
<body>
    <div class = "header-section">
        <h2>Edit Customer Membership</h2>
    </div>

    <div class = "form-section">
    <div class="form-wrap">
    <h3>Edit Customer Membership</h3>

   
   
        <form id="classFormFields" method="POST" action="">
        
        <div class = "group-input">
        <label for="full_name">Name: <?php echo $full_name; ?></label>
  
        </div>

        <div class = "group-input">
        <label for="email">Email: <?php echo $email; ?></label>
  
        </div>

        <div class = "group-input">
        <label for="phoneNo">Phone No: <?php echo $phoneNo; ?></label>
 
        </div>
		<br>
<div class="group-input">
    <label for="membership_type">Current Membership type: <?php echo $membership_type; ?></label>
    <br><p>Change membership to: <p/><select id="membership_type" name="membership_type">
        <option value="student">student</option>
        <option value="normal">normal</option>
        <option value="advanced">advanced</option>
    </select>

</div>

		<div class = "group-input">
        <label for="Status">Subscription status: <?php echo $Status; ?></label>
		    <br><p>Change Subscription status to: <p/><select id="Status" name="Status">
        <option value="inactive">inactive</option>
        <option value="active">active</option>

    </select>
       
        </div>

        <input type="submit" class="site-btn" name="update" value="Update">

        <div class="mb-3">
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
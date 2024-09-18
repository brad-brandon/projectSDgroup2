<?php
session_start();
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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, full_name, password, verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $full_name, $hashed_password, $verified);
        $stmt->fetch();

        if ($verified == 0) {
			header("Location: verify_result.php?message=" . urlencode("Please verify your email before logging in."));
                exit();

        }

        if (password_verify($password, $hashed_password)) {
            // Successful login, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['full_name'] = $full_name;

            // Determine user type and redirect accordingly
            $user_type = getUserType($conn, $id);
            if ($user_type == 'user') {
                header("Location: customer.html");
            } else if ($user_type == 'staff'){
                header("Location: dashboard/index.html");
            }else if ($user_type == 'admin'){
                header("Location: dashboard/index.html");
            }
            exit();
        } else {
			header("Location: verify_result.php?message=" . urlencode("Invalid password."));
                exit();
            //echo "Invalid password.";
        }
    } else {
		header("Location: verify_result.php?message=" . urlencode("No account found with that email."));
                exit();
        //echo "No account found with that email.";
    }

    $stmt->close();
}

$conn->close();

function getUserType($conn, $id) {
    $stmt = $conn->prepare("SELECT user_type FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($user_type);
    $stmt->fetch();
    $stmt->close();
    return $user_type;
}
?>

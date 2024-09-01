<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Welcome message
echo "Welcome, " . $_SESSION['full_name'] . "!";
?>

<a href="logout.php">Log Out</a>

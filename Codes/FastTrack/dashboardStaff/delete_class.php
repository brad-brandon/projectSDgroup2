<?php
include 'db_connect.php'; // Database connection file

$id = $_GET['id'];
$query = "DELETE FROM class_schedule WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header('Location: staff_dashboard.php'); // Redirect to dashboard after deletion
}
?>

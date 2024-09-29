<?php
include 'db_connect.php'; // Database connection file

$id = $_GET['id'];
$query = "SELECT * FROM class_schedule WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['success' => false]);
}
?>

<?php
include 'db_connect.php'; // Database connection file

// Handle Add/Edit Class
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['class_id'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $class_name = $_POST['class_name'];

    if ($id) {
        // Update existing class
        $query = "UPDATE class_schedule SET day_of_week = '$day', time_slot = '$time', start_time = '$start_time', end_time = '$end_time', class_name = '$class_name' WHERE id = $id";
    } else {
        // Insert new class
        $query = "INSERT INTO class_schedule (day_of_week, time_slot, start_time, end_time, class_name,capacity) VALUES ('$day', '$time', '$start_time', '$end_time', '$class_name','5')";
    }

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}
?>

<?php
include 'db_connect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add') {
    // Add new class
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $class_name = $_POST['class_name'];

    $sql = "INSERT INTO class_schedule (day, time_start, time_end, class_name) 
            VALUES ('$day', '$start_time', '$end_time', '$class_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Class added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($action == 'edit') {
    // Edit existing class
    $id = $_POST['id'];
    $class_name = $_POST['class_name'];
    $class_time = $_POST['class_time'];

    $sql = "UPDATE class_schedule SET class_name='$class_name', class_time='$class_time' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Class updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($action == 'delete') {
    // Delete class
    $id = $_POST['id'];
    $sql = "DELETE FROM class_schedule WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Class deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Fetch all classes
    $role = isset($_GET['role']) ? $_GET['role'] : 'admin';  // Default to admin if role is not specified

    $sql = "SELECT * FROM class_schedule";
    $result = $conn->query($sql);
    $output = '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($role == 'admin') {
                // For admin/staff, include Edit | Delete buttons
                $output .= "
                    <tr data-id='{$row['id']}'>
                        <td>{$row['time_start']} - {$row['time_end']}</td>
                        <td class='class-name'>{$row['class_name']}</td>
                        <td class='class-time'>{$row['time_start']} - {$row['time_end']}</td>
                        <td>
                            <button class='edit-btn btn btn-warning'>Edit</button>
                            <button class='delete-btn btn btn-danger'>Delete</button>
                        </td>
                    </tr>
                ";
            } else {
                // For customer, exclude Edit | Delete buttons
                $output .= "
                    <tr>
                        <td>{$row['time_start']} - {$row['time_end']}</td>
                        <td>{$row['class_name']}</td>
                    </tr>
                ";
            }
        }
    } else {
        $output .= "<tr><td colspan='4'>No schedule found</td></tr>";
    }

    echo $output;
}

$conn->close();
?>

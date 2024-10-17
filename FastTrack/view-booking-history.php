<?php
// Database connection
$servername = "localhost"; 
$username = "Webs392024"; 
$password = "Webs392024"; 
$dbname = "fasttrack_gym";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Replace this with the logged-in user's email
$userEmail = "user_email@example.com"; // You need to replace this with the actual user's email

// Retrieve user's booking history
$sql = "SELECT * FROM bookings WHERE user_email = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS here -->
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #e50914;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .primary-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #e50914;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Booking History</h2>
        <table>
            <thead>
                <tr>
                    <th>Class Type</th>
                    <th>Class Date</th>
                    <th>Class Time</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['class_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['class_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['class_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="index.html" class="primary-btn">Back to Booking</a>
    </div>
</body>
</html>

<?php
// Close the connection
$stmt->close();
$conn->close();
?>
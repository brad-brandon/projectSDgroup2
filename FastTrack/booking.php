<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Futuristic Fiery CSS */
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #ff5f6d, #ffc371);
            color: #ffffff;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* Header Section */
        .header-section {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            text-align: center;
            z-index: 10; /* Ensures the header is above other content */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .header-section .logo img {
            max-width: 150px;
            height: auto;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .message-box {
            background: rgba(30, 30, 30, 0.8);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 2px solid #ff5f6d;
            color: #ffffff;
            animation: fadeIn 1s ease;
        }

        .message-box h2 {
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 95, 109, 0.8);
            margin-bottom: 20px;
        }

        .message-box p {
            font-size: 16px;
            color: #ffc371;
            margin-bottom: 20px;
        }

        .message-box a {
            color: #ffc371;
            text-decoration: none;
            font-weight: 600;
        }

        .message-box a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            background: linear-gradient(90deg, #ff5f6d, #ffc371);
            color: #ffffff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background: linear-gradient(90deg, #ffc371, #ff5f6d);
            transform: scale(1.05);
        }
    
        .back-button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #ff5f6d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #ffc371;
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    <header class="header-section">
        <div class="logo">
            <a href ="./customer.php">
                <img src="img/LOGO3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
</head>
<body>
    <div class="container">
        <div class="message-box">
            <?php
            session_start();

            // Enable error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Database connection parameters
            require 'config.php';

            // Create a new mysqli connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the database connection
            if ($conn->connect_error) {
                die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
            }

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                die("<h2>Access Denied</h2><p>Please log in first!</p>");
            }

            // Check if class_id is set in the session
            if (!isset($_SESSION['id'])) {
                die("<h2>Error</h2><p>Please select a class first.</p>");
            }

            // Get user_id and class_id from session
            $user_id = $_SESSION['user_id'];
            $class_id = $_SESSION['id'];

            // Function to get user's subscription type
            function getUserSubscriptionType($conn, $user_id) {
                $subscriptionQuery = "SELECT membership_type FROM users WHERE id = ?";
                $subscriptionStmt = $conn->prepare($subscriptionQuery);
                $subscriptionStmt->bind_param("i", $user_id);
                $subscriptionStmt->execute();
                $subscriptionResult = $subscriptionStmt->get_result();

                $subscription = $subscriptionResult->num_rows > 0 ? $subscriptionResult->fetch_assoc()['membership_type'] : null;
                $subscriptionStmt->close();
                return $subscription;
            }

            // Function to get user's current bookings count
            function getUserBookingsCount($conn, $user_id) {
                $bookingCountQuery = "SELECT bookings_count FROM users WHERE id = ?";
                $bookingCountStmt = $conn->prepare($bookingCountQuery);

                if ($bookingCountStmt) {
                    $bookingCountStmt->bind_param("i", $user_id);
                    $bookingCountStmt->execute();
                    $bookingCountResult = $bookingCountStmt->get_result();
                    $row = $bookingCountResult->fetch_assoc();
                    $bookingCountStmt->close();
                    
                    return $row['bookings_count'];
                } else {
                    die("<p>Error preparing statement: " . $conn->error . "</p>");
                }
            }

            // Function to check if user has reached their booking limit
            function hasReachedBookingLimit($subscription, $bookings_count) {
                switch ($subscription) {
                    case 'student':
                        $bookingLimit = 3;
                        break;
                    case 'normal':
                        $bookingLimit = 5;
                        break;
                    case 'advanced':
                        return false; // Unlimited bookings
                    default:
                        return true; // Unknown subscription type, deny booking
                }

                return $bookings_count >= $bookingLimit;
            }

            // Check subscription and booking limit
            $subscription = getUserSubscriptionType($conn, $user_id);
            $currentBookingsCount = getUserBookingsCount($conn, $user_id);

            if (hasReachedBookingLimit($subscription, $currentBookingsCount)) {
                //echo "<h2>Booking Failed: Limit Reached</h2>
                //      <p>You have reached the booking limit for your subscription plan.</p>
                //      <p><a href='view-booking-history.php'>View Your Booking History</a></p>";
                //exit;
				header("Location: verify_result.php?message=" . urlencode("Booking Failed: Limit Reached.You have reached the booking limit for your subscription plan."));
                exit();
            }

            // Check for existing booking with the same user_id and class_id
            $checkSql = "SELECT * FROM bookings_table WHERE user_id = ? AND id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ii", $user_id, $class_id);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                //echo "<h2>Booking Failed: Duplicate Entry</h2>
                //      <p>You have already booked this class.</p>
                 //     <p><a href='view-booking-history.php'>View Your Booking History</a></p>
                 //     <a href='customer.php' class='button'>Go back to main page</a>";
                //exit;
				header("Location: verify_result.php?message=" . urlencode("Booking Failed: Duplicate Entry,You have already booked this class."));
                exit();
            }

            // Check class capacity before inserting booking
            $capacityCheckSql = "SELECT capacity FROM class_schedule WHERE id = ? AND capacity > 0";
            $capacityCheckStmt = $conn->prepare($capacityCheckSql);
            $capacityCheckStmt->bind_param("i", $class_id);
            $capacityCheckStmt->execute();
            $capacityCheckResult = $capacityCheckStmt->get_result();

            if ($capacityCheckResult->num_rows > 0) {
                $sql = "INSERT INTO bookings_table (user_id, id, status) VALUES (?, ?, 'confirmed')";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ii", $user_id, $class_id);

                    if ($stmt->execute()) {
                       // echo "<h2>Class successfully booked!</h2>
                        //      <p>Your booking has been confirmed.</p>
                        //      <a href='customer.php' class='button'>Go back to main page</a>";
						header("Location: verify_result.php?message=" . urlencode("Class successfully booked! Your booking has been confirmed."));
                exit();
                    } else {
                        header("Location: verify_result.php?message=" . urlencode("Error: Booking failed."));
                exit();
						//echo "<h2>Error: Booking failed.</h2><p>" . htmlspecialchars($stmt->error) . "</p>";
                    }

                    $stmt->close();
                } else {
                    die("<p>Error preparing statement: " . $conn->error . "</p>");
                }
            } else {
                //echo "<h2>Booking Failed: Class Full</h2>
                      //<p>This class is already fully booked. Please select another class.</p>
                      //<a href='customer.php' class='button'>Go back to main page</a>";
					  header("Location: verify_result.php?message=" . urlencode("Booking Failed: Class Full.This class is already fully booked. Please select another class."));
                exit();
            }

            $capacityCheckStmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>

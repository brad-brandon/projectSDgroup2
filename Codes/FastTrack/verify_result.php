<?php
// Get the result message from the URL query parameters
$message = isset($_GET['message']) ? $_GET['message'] : 'Unknown error occurred.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Result</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/signup.css" type="text/css">

    <style>


        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF0000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #FF0000;
        }
    </style>
</head>

<body>
<header>
    <!-- Header Section Begin -->
        <div class="logo">
            <a href="./index.html">
                <img src="img/LOGO3.png" alt="FastTrack Gym Logo">
            </a>
        </div>
    </header>
	<section class="login-section">
        <div class="login-form-wrap">
            <h3><p><?php echo htmlspecialchars($message); ?></p></h3>


        <a href="javascript:history.back()" class="site-btn">Go to Previous Page</a>


            <div class="switch-login">
                <a href="./index.html" class="or-home">Back to Homepage</a>
            </div>
            <!-- End of added links -->

        </div>
    </section>
    <div class="message-box">
        
        
    </div>
	    <footer class="footer-section">
        <p>&copy; 2024 FastTrack Gym. All rights reserved.</p>
    </footer>
</body>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</html>

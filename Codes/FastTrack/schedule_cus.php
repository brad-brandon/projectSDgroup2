<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Activitar Template">
    <meta name="keywords" content="Activitar, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FastTrack Gym | Schedule</title>

    <link href="img/logo2.png" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section header-normal">
        <div class="container-fluid">
            <div class="logo">
                <a href="./customer.php">
                    <img src="img/LOGO3.png" alt="FastTrack Gym Logo">
                </a>
            </div>
            <div class="container">
                <div class="nav-menu">
                    <nav class="mainmenu mobile-menu">
                        <ul>
                            <li><a href="./customer.php">Home</a></li>
                            <li class="active"><a href="./schedule_cus.html">Schedule</a></li>
                            <li><a href="./gallery_cus.html">Gallery</a></li>
                            <li><a href="./blog_cus.html">Blog</a>
                                <ul class="dropdown">
                                    <li><a href="./blog-single.html">Blog Details</a></li>
                                </ul>
                            </li>
							<li><a href="./about-us_cus.html">About Us</a></li>
                            <li><a href="./contact_cus.html">Contacts</a></li>
							<li><a href="./viewprofile.php">Profile</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg spad" data-setbg="img/about-bread.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>SCHEDULE & CLASSES</h2>
                        <div class="breadcrumb-controls">
                            <a href="customer.php"><i class="fa fa-home"></i> Home</a>
                            <span>Schedule</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

<!-- Class Time Section Begin -->
<section class="classtime-section class-time-table spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Classtime Table</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="timetable-controls">
                    <ul>
                        <li class="active" data-tsfilter="all">all class</li>
                    </ul>
                </div>
            </div>
        </div>
<div class="classtime-table">
<table class= "myTable">
<thead>
    <tr>
        <th>Time</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
    </tr>
</thead>
<tbody>
    <!-- PHP Loop to fetch schedule from the database -->
    <?php
require 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
    $time_slots = ['10:00:00', '14:00:00', '16:00:00', '18:00:00', '20:00:00'];
    $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    foreach ($time_slots as $time) {
        echo "<tr>";
        echo "<td class='workout-time'>" . date('H:i', strtotime($time)) . "</td>";
        foreach ($days_of_week as $day) {
            echo "<td class='hover-bg ts-item' data-tsmeta='crossfit' id='cell_{$day}_{$time}'>";
            // Fetch the class for that day and time slot
            $query = "SELECT * FROM class_schedule WHERE day_of_week = '$day' AND time_slot = '$time'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<span>{$row['start_time']} - {$row['end_time']}</span><h6>{$row['class_name']}</h6>";
                
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</tbody>

</table>
</div >
        <div class="classtime-table">
            <!--<table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="workout-time">10.00</td>
                        <td class="hover-bg ts-item" data-tsmeta="crossfit">
                            <span>10.00 - 14.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="crossfit">
                            <span>10.00 - 15.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="lunge">
                            <span>10.00 - 13.00</span>
                            <h6>HIIT</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="lunge">
                            <span>10.00 - 13.30</span>
                            <h6>HIIT</h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="workout-time">14.00</td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="lunge">
                            <span>14.00 - 17.00</span>
                            <h6>Powerlifting</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="crossfit">
                            <span>14.00 - 17.00</span>
                            <h6>Powerlifting</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="walls">
                            <span>14.00 - 15.30</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="workout-time">16.00</td>
                        <td class="hover-bg ts-item" data-tsmeta="lunge">
                            <span>16.00 - 18.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="candy">
                            <span>16.00 - 19.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="candy">
                            <span>16.00 - 19.00</span>
                            <h6>HIIT</h6>
                        </td>
                        <td class="hover-bg ts-item" data-tsmeta="ppsr">
                            <span>16.00 - 17.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                        <td class="hover-bg ts-item" data-tsmeta="murph">
                            <span>16.00 - 20.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="workout-time">18.00</td>
                        <td class="hover-bg ts-item" data-tsmeta="walls">
                            <span>18.00 - 20.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                        <td class="hover-bg ts-item" data-tsmeta="ppsr">
                            <span>18.00 - 20.00</span>
                            <h6>Powerlifting</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="chelsea">
                            <span>18.00 - 22.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="annie">
                            <span>18.00 - 22.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="workout-time">20.00</td>
                        <td class="hover-bg ts-item" data-tsmeta="lunge">
                            <span>21.00 - 23.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td class="hover-bg ts-item" data-tsmeta="walls">
                            <span>20.00 - 22.00</span>
                            <h6>HIIT</h6>
                        </td>
                        <td class="hover-bg ts-item" data-tsmeta="walls">
                            <span>20.30 - 23.00</span>
                            <h6>Powerlifting</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="crossfit">
                            <span>22.00 - 23.00</span>
                            <h6>Hypertrophy</h6>
                        </td>
                        <td></td>
                        <td class="hover-bg ts-item" data-tsmeta="crossfit">
                            <span>21.00 - 23.00</span>
                            <h6>ZUMBA</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            -->
        </div>
        <a href="bookTrainingClass.php" class="primary-btn price-btn">Book Class</a>
        <a href="view-booking-history.php" class="primary-btn price-btn">Book History</a>
    </div>
    
</section>
<!-- Class Time Section End -->

   <!-- Classes Section Begin -->
   <section class="classes-section">
    <div class="class-title set-bg" data-setbg="img/classes-title-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 m-auto text-center">
                    <div class="section-title pl-lg-4 pr-lg-4 pl-0 pr-0">
                        <h2>Choose Your Program</h2>
                        <p>Our experts can help you discover new training techniques and exercises that offer a dynamic and efficient full-body workout.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="classes-item set-bg" data-setbg="img/classes/class-1.jpg"> <!-- edit the image -->
                    <h4>Hypertrophy Training</h4>
                    <p>Focus on muscle growth with targeted exercises designed to maximize muscle size and definition.
                    Ideal for building strength and sculpting your physique.</p>
                    <a href="blog.html" class="primary-btn class-btn">Read More</a> <!-- need to edit this read more -->
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="classes-item set-bg" data-setbg="img/classes/class-2.jpg"> <!-- edit the image -->
                    <h4>HIIT (High-Intensity Interval Training)</h4>
                    <p>Kickstart your fitness journey with short, effective workouts that combine quick exercises and rest to burn fat and boost energy.
                    </p>
                    <a href="blog.html" class="primary-btn class-btn">Read More</a> <!-- need to edit this read more -->
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="classes-item set-bg" data-setbg="img/classes/class-3.jpg"> <!-- edit the image -->
                    <h4>zumba</h4>
                    <p>Get energized with fun, dance-based workouts set to lively music. 
                    Enjoy a full-body workout that improves cardiovascular health and coordination while having a blast. </p>
                    <a href="blog.html" class="primary-btn class-btn">Read More</a> <!-- need to edit this read more -->
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="classes-item set-bg" data-setbg="img/classes/class-4.jpg"> <!-- edit the image -->
                    <h4>Powerlifting</h4>
                    <p>Focus on the core squat, bench press, and deadlift to build maximum strength and power. 
                    Learn proper technique and training strategies for effective and safe lifting.</p>
                    <a href="blog.html" class="primary-btn class-btn">Read More</a> <!-- need to edit this read more -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Classes Section End -->

     <!-- Choseus Section Begin -->
    <section class="chooseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Why People Choose Us</h2>
                        <p>We’re a top choice for fitness because we provide a welcoming environment, 
						skilled trainers, and diverse programs tailored to all fitness levels.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-1.png" alt="">
                        <h5>Support 24/24</h5>
                        <p>Benefit from round-the-clock support to help you with any fitness 
						questions or concerns, ensuring you have the assistance you need whenever you need it.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-2.png" alt="">
                        <h5>Our trainer</h5>
                        <p>Our trainers are experienced and dedicated, offering expert guidance and
						motivation to help you achieve your fitness goals effectively.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-3.png" alt="">
                        <h5>Personalized sessions</h5>
                        <p>Get workouts designed just for you. Our trainers create personalized plans 
						to match your specific fitness goals and needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-4.png" alt="">
                        <h5>Our equipment</h5>
                        <p>Enjoy access to top-quality machines and weights for a complete workout 
						experience. We have everything you need to reach your fitness goals.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-5.png" alt="">
                        <h5>Classes daily</h5>
                        <p>Join our daily classes ranging. 
						We offer a variety of options to keep your workouts fresh and exciting.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="choose-item">
                        <img src="img/icons/chose-icon-6.png" alt="">
                        <h5>Focus on your health</h5>
                        <p>We emphasize overall wellness, providing programs that support a 
						balanced lifestyle and improve your overall well-being.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Choseus Section End -->

 <!-- Cta Section Begin -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-text">
                        <h3>Get Started Today</h3>
                        <p>New member special! 10% discount for first registration!</p>
                    </div>
                    <a href="membership.html" class="primary-btn cta-btn">book now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Cta Section End -->

 <!-- Footer Section Begin -->
 <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-logo-item">
                        <div class="f-logo">
                            <a href="#"><img src="img/LOGO3.png" alt=""></a>
                        </div>
                        <p>Experience top-notch fitness with us: expert trainers, personalized sessions, state-of-the-art equipment, daily classes, 
						and 24/7 support, all in a welcoming environment dedicated to your health and well-being.</p>
                        <div class="social-links">
                            <h6>Follow us</h6>
                            <a href="https://www.facebook.com/FastrackGym/"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.google.com/maps/place/FastTrack+Gym+%26+Fitness+Centre/@3.1949376,101.7244576,17z/data=!3m1!4b1!4m6!3m5!1s0x31cc37f5bdfa35a5:0xa1e339c137810a59!8m2!3d3.1949376!4d101.7270325!16s%2Fg%2F11f0kw1mxs?entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"><i class="fa fa-google-plus"></i></a>
                            <a href="https://www.instagram.com/fastrackgym/"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Our Blog</h5>
                        <div class="footer-blog">
                            <a href="blog.html" class="fb-item">
                                <h6>HIIT BENEFITS</h6>
                                <span class="blog-time"><i class="fa fa-clock-o"></i> Jan 02, 2022</span>
                            </a>
                            <a href="blog.html" class="fb-item">
                                <h6>DON'T STRESS ABOUT YOUR DIET</h6>
                                <span class="blog-time"><i class="fa fa-clock-o"></i> July 2023</span>
                            </a>
                            <a href="blog.html" class="fb-item">
                                <h6>DON'T BE A AFRAID TO GO GYM</h6>
                                <span class="blog-time"><i class="fa fa-clock-o"></i> Aug 08, 2024</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>Program</h5>
                        <ul class="workout-program">
                            <li><a href="blog.html">Hypertrophy</a></li>
                            <li><a href="blog.html">HIIT</a></li>
                            <li><a href="blog.html">Zumba</a></li>
                            <li><a href="blog.html">Powerlifting</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-widget">
                        <h5>Get Info</h5>
                        <ul class="footer-info">
                            <li>
                                <i class="fa fa-phone"></i>
                                <span>Phone:</span>
                                (+62) 013 - 567 4456
                            </li>
                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <span>Email:</span>
                                fasttrackgym777@gmail.com
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <span>Address</span>
                                1, Jln Seri Rejang 4, Setapak Jaya, 53300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-text">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="ct-inside"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            FastTrack Gym &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved <a href="index.html" target="_blank">FastTrack</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --> </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
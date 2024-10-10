<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gym Class Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
	<link href="css/classtable.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>FastTrack</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/WONG.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Wong</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.html" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                       
                    </div>
                    <a href="customer.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Customer Info</a>
					<a href="staff_info.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Staff Info</a>
                    <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Membership</a>
                    <a href="table.html" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Class</a>
                    <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Personal Training</a>
                    
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


         <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
						
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">View Profile</span>
						
						</a>
						
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/WONG.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">Wong</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <li><a href="./viewprofileAdmin.php">View profile</a></li>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Table Start -->
			<div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Classes Table</h6>
                        <a href="">Show All</a>
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
$servername = "localhost";
$username = "Webs392024";
$password = "Webs392024";
$dbname = "fasttrack_gym";

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

                   <!-- <img src="img/classtimetable.png" alt="Class Time" width="1000" height="auto">-->
                </div>
            </div>
			
			<div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Edit Table</h6>
                        <a href="">Show All</a>
                    </div>
					
<div class="classtime-table">
			<!--i edit here-->


<!-- The Schedule Table -->
<!-- Start Styles. Move the 'style' tags and everything between them to between the 'head' tags -->
<style type="text/css">


.myTable td, .myTable th { border:1px solid #000; }
</style>
<!-- End Styles -->
<table class="myTable">
    <thead>
        <tr >
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
		$servername = "localhost";
$username = "Webs392024";  // adjust your database credentials
$password = "Webs392024";
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
        $time_slots = ['10:00:00', '14:00:00', '16:00:00', '18:00:00', '20:00:00'];
        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($time_slots as $time) {
            echo "<tr >";
            echo "<td class='workout-time'>" . date('H:i', strtotime($time)) . "</td>";
            foreach ($days_of_week as $day) {
                echo "<td class='hover-bg ts-item' data-tsmeta='crossfit' id='cell_{$day}_{$time}'>";
                // Fetch the class for that day and time slot
                $query = "SELECT * FROM class_schedule WHERE day_of_week = '$day' AND time_slot = '$time'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<span>{$row['start_time']} - {$row['end_time']}</span><h6>{$row['class_name']}</h6>";
					echo "<div class='action-buttons'>";
                    echo "<button class='btn btn-sm btn-warning' onclick='editClass({$row['id']})'>Edit</button>";
                    echo "<button class='btn btn-sm btn-danger' onclick='deleteClass({$row['id']})'>Delete</button>";
					echo "</div>";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- Add/Edit Class Form (hidden by default) -->
<div id="classForm" style="display:none;">
    <h6 class="mb-0" id="formTitle" style="background-color:#060614">Add Class</h6>
	
    <form id="classFormFields" style="background-color:#060614" onsubmit="return saveClass()">
        <label for="day">Day:</label>
        <select id="day" name="day">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
        </select><br><br>
        
        <label for="time">Time Slot:</label>
        <select id="time" name="time">
            <option value="10:00:00">10:00</option>
            <option value="14:00:00">14:00</option>
            <option value="16:00:00">16:00</option>
            <option value="18:00:00">18:00</option>
            <option value="20:00:00">20:00</option>
        </select><br><br>
        
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required><br><br>

        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required><br><br>
        
        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" required><br><br>
        
        <input type="hidden" id="class_id" name="class_id">
		       
        <button class="btn btn-sm btn-warning" type="submit">Save</button>
        <button class="btn btn-sm btn-danger" type="button" onclick="hideClassForm()">Cancel</button>
    </form>

</div>

</div>
		</div>

	
<div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            <button class="btn btn-success add-class-btn" onclick="showAddClassForm()">Add Class</button>
							
                        </div>
                        
                    </div>
                </div>
            </div>
<script>
    function showAddClassForm() {
        document.getElementById('classForm').style.display = 'block';
        document.getElementById('formTitle').innerText = 'Add Class';
        document.getElementById('classFormFields').reset();
    }

    function hideClassForm() {
        document.getElementById('classForm').style.display = 'none';
    }

    function editClass(id) {
        // Fetch the class details using AJAX and populate the form fields
        document.getElementById('classForm').style.display = 'block';
        document.getElementById('formTitle').innerText = 'Edit Class';
        
        // Make an AJAX call to fetch the details for the class
        fetch(fetch_class.php?id=${id})
        .then(response => response.json())
        .then(data => {
            document.getElementById('day').value = data.day_of_week;
            document.getElementById('time').value = data.time_slot;
            document.getElementById('start_time').value = data.start_time;
            document.getElementById('end_time').value = data.end_time;
            document.getElementById('class_name').value = data.class_name;
            document.getElementById('class_id').value = data.id;
        });
    }

    function deleteClass(id) {
        if (confirm('Are you sure you want to delete this class?')) {
            window.location.href = delete_class.php?id=${id};
        }
    }

    function saveClass() {
        const form = document.getElementById('classFormFields');
        const formData = new FormData(form);
        fetch('save_class.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error saving class');
            }
        });
        return false; // Prevent default form submission
    }
</script>


            <!-- Table End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">FastTrack Gym</a>, All Right Reserved. 
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
 
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
	
</body>

</html>
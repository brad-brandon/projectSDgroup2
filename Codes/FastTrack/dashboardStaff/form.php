<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FastTrack - Membership</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/logo2.png" rel="icon">

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
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>FastTrack</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/logo2.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Staff</h6>
                        <span>Dashboard</span>
                    </div>
                </div>
                
                <div class="navbar-nav w-100">
                    <a href="index.html" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                       
                    </div>
                    <a href="customer.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Customer Info</a>
                    <a href="form.php" class="nav-item nav-link active"><i class="fa fa-keyboard me-2"></i>Membership</a>
					<a href="staff_dashboard.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Class</a>
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
                <div class="navbar-nav align-items-center ms-auto">
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="img/LOGO4.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">Profile</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="./viewprofileStaff.php" class="dropdown-item">View Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Widget Start -->
           <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4 text-white">Membership Details</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No</th>
									<th scope="col">Membership type</th>
                                    <th scope="col">Subscription status</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Database connection
                               include 'db_connect.php';

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Query to fetch customer details where user_type is 'user'
                                $sql = "SELECT id, full_name, email, phoneNo, membership_type, Status FROM users WHERE user_type = 'user'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['full_name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phoneNo'] . "</td>";
										echo "<td>" . $row['membership_type'] . "</td>";
                                        echo "<td>" . $row['Status'] . "</td>";
                                        echo "<td><a href='edit_customerMembership.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a></td>";
                                        echo "<td><a href='delete_customerMembership.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this customer membership?\")'>Delete</a></td>";
										
                                        echo "</tr>";
                                    }
                                } else {
								echo "<tr><td colspan='5'>No customer data found</td></tr>";
								}
		
							// Close connection
							$conn->close();
							?>
						</tbody>
					</table>
                    </div>
                </div>
            </div>
			<div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4 text-white">Payment Details</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
					<?php
// Database connection settings
include 'db_connect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get all transactions
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);
?>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bill Name</th>
                <th>Description</th>
                <th>Bill To</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Payment Channel</th>
                <th>Payment Amount</th>
                <th>Invoice No</th>
                <th>Payment Date</th>
                <th>Transaction Charge</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Fetch each row and display it in the table
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_to"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_phone"]) . "</td>";
                    echo "<td>" . ($row["bill_status"] == 1 ? "Active" : "Inactive") . "</td>";
                    echo "<td>" . ($row["bill_payment_status"] == 1 ? "Paid" : "Unpaid") . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_payment_channel"]) . "</td>";
                    echo "<td>" . number_format($row["bill_payment_amount"], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_payment_invoice_no"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bill_payment_date"]) . "</td>";
                    echo "<td>" . number_format($row["transaction_charge"], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</tbody>
<!-- Footer Start -->
<div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="index.html">FastTrack Gym</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->

<?php
// Close the connection
$conn->close();
?>

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Feedback Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "css/staff_feddback.css">
</head>
<body>

<div class="container">
    <h2>Customer Feedback</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Feedback</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="feedback-list">
            <!-- Feedback entries will be populated here -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        loadFeedback();

        function loadFeedback() {
            $.ajax({
                url: 'get_feedback.php',
                type: 'GET',
                success: function (data) {
                    $('#feedback-list').html(data);  // Populate feedback list
                },
                error: function () {
                    alert("Failed to load feedback");
                }
            });
        }
    });
</script>

</body>
</html>

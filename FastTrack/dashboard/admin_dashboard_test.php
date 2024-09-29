<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gym Class Schedule</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        button {
            margin: 5px;
        }
    </style>
</head>
<body>

<h2>Gym Class Schedule</h2>
<!-- The Add Class Button -->
<button onclick="showAddClassForm()">Add Class</button>

<!-- The Schedule Table -->
<table>
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
$username = "root";  // adjust your database credentials
$password = "root";
$dbname = "fasttrack_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
        $time_slots = ['10:00:00', '14:00:00', '16:00:00', '18:00:00', '20:00:00'];
        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($time_slots as $time) {
            echo "<tr>";
            echo "<td>" . date('H:i', strtotime($time)) . "</td>";
            foreach ($days_of_week as $day) {
                echo "<td id='cell_{$day}_{$time}'>";
                // Fetch the class for that day and time slot
                $query = "SELECT * FROM class_schedule WHERE day_of_week = '$day' AND time_slot = '$time'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "{$row['start_time']} - {$row['end_time']}<br>{$row['class_name']}";
                    echo "<br><button onclick='editClass({$row['id']})'>Edit</button>";
                    echo "<button onclick='deleteClass({$row['id']})'>Delete</button>";
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
    <h3 id="formTitle">Add Class</h3>
    <form id="classFormFields" onsubmit="return saveClass()">
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
        <button type="submit">Save</button>
        <button type="button" onclick="hideClassForm()">Cancel</button>
    </form>
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
        fetch(`fetch_class.php?id=${id}`)
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
            window.location.href = `delete_class.php?id=${id}`;
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

</body>
</html>

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<?php
// editResv.php

$host = "localhost";
$username = "root";
$password = "";
$database = "onlinebooking";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $resevID = $_GET['id'];

    // Retrieve reservation details from the database based on the ID
    $sql = "SELECT reservation.*, venue.VenueName 
        FROM reservation 
        LEFT JOIN venue ON reservation.VenueId = venue.VenueId 
        WHERE reservation.resevID = $resevID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Retrieve all venues from the database
        $venue_sql = "SELECT VenueId, VenueName FROM venue";
        $venue_result = $conn->query($venue_sql);

        include 'head.php'; 

        echo '<body>
            <div class="container-scroller">
                <!-- partial:partials/_navbar.html -->';
        echo '<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">';
        
        include 'navBarAfter.php';
        
        $currentDept = $row["DeptName"];

        echo '</nav>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="alert alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Reminder!</strong> Please fill in a date and time that have not been reserved yet to avoid a failed reservation. 
                </div>
                <div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-center mt-4">Edit Reservation</h2>
                                    <form action="updateResv.php" method="POST" autocomplete="off">
                                        <input type="hidden" name="resevID" value="' . htmlspecialchars($resevID) . '">
                                        <div class="mb-3">
                                            <label for="DeptName">Department Name:</label>
                                            <div style="margin-top: 10px;"></div>
                                            <select name="DeptName" id="DeptName">
                                                <option value="">--- Choose a department ---</option>';

        // Use a PHP loop to generate the options
        $departments = [
            "Human Resource(HR)",
            "Production",
            "Engineering",
            "Finance",
            "Logistic",
            "Health, Safety and Environment(HSE)",
            "Quality Assurance(QA)",
            "Procurement",
            "Technical Services"
        ];

        foreach ($departments as $dept) {
            $selected = ($currentDept == $dept) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($dept) . '" ' . $selected . '>' . htmlspecialchars($dept) . '</option>';
        }

        echo '              </select>
                        </div>';					

								include 'javaScript.php';

                               echo '         
    <div class="mb-3">
        <label for="VenueName" class="form-label">Venue Name</label>
        <select name="VenueName" class="form-control" id="VenueName" required>';
        
        // Loop through all venues and create options for the select element
        if ($venue_result->num_rows > 0) {
            while ($venue_row = $venue_result->fetch_assoc()) {
                $selected = ($venue_row['VenueName'] == $row['VenueName']) ? 'selected' : '';
                echo '<option value="' . $venue_row['VenueId'] . '" ' . $selected . '>' . $venue_row['VenueName'] . '</option>';
            }
        }
        
        echo '</select>
    </div>
    
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input name="date" type="date" class="form-control" id="date" value="' . $row["date"] . '">
    </div>

    <div class="mb-3">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="time" class="form-control" name="start_time" id="start_time" value="' . $row["start_time"] . '" required>
    </div>
    
    <div class="mb-3">
        <label for="end_time" class="form-label">End Time</label>
        <input type="time" class="form-control" name="end_time" id="end_time" value="' . $row["end_time"] . '" required>
    </div>
	
	<div class="mb-3">
        <label for="reserved_by" class="form-label">Reserved By</label>
        <input type="text" class="form-control" name="reserved_by" id="reserved_by" value="' . $row["reserved_by"] . '" required>
    </div>

    <div class="mb-3">
        <label for="activity" class="form-label">Notes</label>
        <textarea name="activity" class="form-control" placeholder="Activity" id="activity">' . $row["activity"] . '</textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update Reservation" />
    </div>

			</form>
                                </div>
                            </div>
                                    <!-- content-wrapper ends -->
                                    <!-- partial:partials/_footer.html -->
                                    <footer class="footer">
                                        <div class="container-fluid d-flex justify-content-between">
                                            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © GreenTech.com 2021</span>
                                        </div>
                                    </footer>
                                    <!-- partial -->
                                </div>
                                <!-- main-panel ends -->
                            </div>
                            <!-- page-body-wrapper ends -->
                        </div>
                    </div>
                </div>
            </body>';

        include 'javaScript.php'; // Include your JavaScript.php content
    } else {
        echo "Reservation not found";
    }
}
?>
<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>



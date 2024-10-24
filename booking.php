<?php
session_start();
include 'db_conn.php'; 

// Get the date if available
$date = isset($_GET['date']) ? $_GET['date'] : null;
echo 'Date: ' . $date;
?>
<?php
session_start();
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  include 'head.php';
  ?>
</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <?php
      include 'navBarAfter.php';
      ?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
	<!-- Contact form -->
	<section class="contact-form">
				<div class="alert alert-danger">
					<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
					<strong>Reminder!</strong> Please fill in a time that have not been reserved yet to avoid a failed reservation. 
				</div>
		<div class="form-container">
			<h2><?php
					// Fetch the VenueName based on the VenueId
					if(isset($_GET['VenueId'])) {
						$venueId = $_GET['VenueId'];
						$query = "SELECT VenueName FROM venue WHERE VenueId = $venueId";
						$result = mysqli_query($conn, $query);
						if(mysqli_num_rows($result) > 0) {
							$row = mysqli_fetch_assoc($result);
							$venueName = $row['VenueName'];
							echo "<h2>Meeting Room Reservation (Book for date: " . (isset($date) ? date('d F Y', strtotime($date)) : '') . " at $venueName)</h2>";
						} else {
							echo "<h2>Meeting Room Reservation (Book for date: " . (isset($date) ? date('d F Y', strtotime($date)) : '') . ")</h2>";
						}
					} else {
						echo "<h2>Meeting Room for venue: Reservation (Book for date: " . (isset($date) ? date('d F Y', strtotime($date)) : '') . ")</h2>";
					}
					?></h2>
					<div>
						<a href="resvCalendar.php" style="margin-left: 1200px;" class="btn btn-primary shadow p-3 bg-body-tertiary rounded">Back to Calendar</a>
					</div><br>
				<form action="newbooking.php" method="POST" enctype="multipart/form-data">
				 <form action="" method="POST">
				 
				<label for="DeptName">Department Name:</label><div style="margin-top: 10px;"></div>
				<select name="DeptName" id="DeptName">
					<option value="">--- Choose a department ---</option>
					<option value="Human Resource(HR)">Human Resource(HR)</option>
					<option value="Production">Production</option>
					<option value="Engineering">Engineering</option>
					<option value="Finance">Finance</option>
					<option value="Logistic">Logistic</option>
					<option value="Health, Safety and Environment(HSE)">Health, Safety and Environment(HSE)</option>
					<option value="Quality Assurance(QA)">Quality Assurance(QA)</option>
					<option value="Procurement">Procurement</option>
					<option value="Technical Services">Technical Services</option>
				</select>
				
				<div style="margin-top: 20px;"></div>

                <label for="VenueName" class="form-label">Room Chosen</label>
                <input type="text" name="VenueName" class="form-control" id="VenueName" value="<?php echo $venueName; ?>" readonly />

                <label for="date" class="form-label">Date</label>
                <input name="date" class="form-control" id="date" value="<?php echo $date; ?>" readonly>

                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" class="form-control" id="start_time" required>

                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" class="form-control" id="end_time" required>
				
				<label for="reserved_by" class="form-label">Reserved by (Name of the person)</label>
                <input type="text" name="reserved_by" class="form-control" id="reserved_by" required>

                <label for="activity" class="form-label">Notes</label>
                <textarea name="activity" class="form-control" placeholder="Activity" id="activity"></textarea>

                <input type="hidden" name="VenueID" value="<?php echo $venueId; ?>">

                <button type="submit" class="submit-button">Submit</button>
              </form>
		</div>
		</div>
		</div>
		</div>
		</div>
	</section>
</body>

</html>
<?php
// Clear the session data after displaying it
unset($_SESSION['form_data']);
?>
 <script>
        function previewImage(input) {
            var previewContainer = document.getElementById('imagePreview');
            var file = input.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Create an image element
                    var img = document.createElement('img');
                    img.src = e.target.result;

                    // Clear previous preview
                    previewContainer.innerHTML = '';

                    // Append the image to the preview container
                    previewContainer.appendChild(img);
                };

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            } else {
                // Clear the preview if no file is selected
                previewContainer.innerHTML = '';
            }
        }
    </script>
<style>

.banner {
	text-align: center;
	background-color: #ffffff;
	margin: 0 auto;
}

.banner img {
	max-width: 100%;
	height: auto;
	margin-top: -70px;
}
/* Contact form styles */
.contact-form {
	padding: 40px 0;
	margin: 0 10px;
	margin-top: -60px;
}

.form-container {
	max-width: 100%;
	margin: 0 auto;
	padding: 20px;
	background-color: #ffffff;
	border-radius: 10px;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.contact-form h2 {
	text-align: center;
	margin-bottom: 20px;
}

.form-group {
	margin-bottom: 20px;
}

.form-container label {
	display:block;
	font-weight: bold;
}
.form-container input, textarea{
	width: 100%;
	padding: 10px;
	border: 1px solid #ccc;
	border-radius: 4px;
	margin-bottom: 1rem;
	resize: vertical;
}
.submit-button {
	padding: 10px 20px;
	background-color: #A87CA0;
	border: none;
	color: white;
	border-radius: 4px;
	font-size: 1rem;
	cursor: pointer;
}

/* Media queries for responsiveness */
@media only screen and (max-width: 768px) {
	.logo {
		display: none;
	}

	.hamburger {
		display: flex;
	}

	#nav-menu {
		position: absolute;
		top: 4rem;
		left: 0;
		background-color: #333;
		width: 100%;
		display: none;
	}

	#nav-menu.active {
		display: block;
		flex-direction: row;
		padding: 1rem;
	}
}
</style>
<script>
// JavaScript function to toggle the navigation menu

function openNavbar() {
const navMenu = document.getElementById("nav-menu");
navMenu.classList.toggle("active");
}
</script>
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
<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_conn.php';

$resevID = "";
$DeptName = "";
$VenueName = "";
$activity = "";
$date = "";
$Times = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// GET method: Show the data of the reservation

	if (!isset($_GET["resevID"])) {
		header("location: index.php");
		exit;
	}

	$resevID = $_GET["resevID"];

	// Read the row of the selected reservation from the database table
	$sql = "SELECT * FROM reservation";

	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	if (!$row) {
		header("location: index.php");
		exit;
	}

	$venueID = $row['venueID'];

	// Retrieve the venueName based on the venueID
	$venueSql = "SELECT venueName FROM venue WHERE venueID = $venueID";
	$venueResult = $conn->query($venueSql);

	if (!$venueResult) {
		die("Invalid query: " . $conn->error);
	}

	if ($venueResult->num_rows > 0) {
		// Fetch the venueName from the result
		$venueRow = $venueResult->fetch_assoc();
		$venueName = $venueRow['venueName'];
	} else {
		// Handle the case when the venueID does not exist
		echo "Error: Venue ID does not exist.";
		// You may choose to exit the script or redirect the user to an error page
	}

	$resevID = $row['resevID'];
	$DeptName = $row['DeptName'];
	$venueName= $row['$venueName'];
	$activity = $row['activity'];
	$date = $row['date'];
	$Times = $row['Times'];

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// POST method: Update the data of the reservation
	$resevID = $_POST['resevID'];
	$DeptName = $_POST['DeptName'];
	$venueName= $_POST['$venueName'];
	$activity = $_POST['activity'];
	$date = $_POST['date'];
	$Times = $_POST['Times'];
	

	if (empty($resvID) || empty($DeptName) || empty($venueName) || empty($activity) || empty($Times) || empty($date)) {
		$errorMessage = "All fields are required";
	} else {
		// Update the reservation record in the database
		$sql = "UPDATE reservation SET resevID = '$resevID', DeptName = '$DeptName', venueName = '$venueName',activity = '$activity', Times = '$time', date = '$date' WHERE resevID = '$resevID'";

		if ($conn->query($sql) === TRUE) {
			// Successful update
			echo "Reservation updated successfully.";

			// Redirect back to resvPage.php
			header("Location: index.php");
			exit();
		} else {
			// Failed to update
			echo "Error updating reservation: " . $conn->error;
		}
	}
}

$conn->close();
?>

<!-- Rest of the HTML code -->


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta resvID="viewport" content="width=device-width, initial-scale=1">
	<title>EDIT Reservation</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<script> src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" > </script>

</head>

<body>
	<div class="container my-5">
		<h2>Edit Reservation</h2>

		<?php
		if (!empty($errorMessage)) {
			echo "
			<div class='alert alert-warning alert-dismissible fade show' role='alert'>
				<strong>$errorMessage</strong>
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div> 
			";
		}
		?>

		<form method="POST">

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Reservation ID</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="resevID" value="<?php echo $resevID ?>" readonly>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Department Name</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="DeptName" value="<?php echo $DeptName ?>" readonly>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Venue</label>
				<div class="col-sm-6">
				<input type="text" class="form-control" name="venueName" value="<?php echo $venueName ?>" readonly>
				</div>
			</div>

			

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Notes</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="activity" value="<?php echo $activity ?>" readonly>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Times</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="times" value="<?php echo $times ?>"
						pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" readonly>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Date</label>
				<div class="col-sm-6">
					<input type="date" class="form-control" name="date" value="<?php echo $date ?>">
				</div>
			</div>

			<?php
			if (!empty($successMessage)) {
				echo "
			<div class='alert alert-success alert-dismissible fade show' role='alert'>
				<strong>$successMessage</strong>
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div> 
			";
			}
			?>

			<div class="row mb-3">
				<div class="offset-sm-3 col-sm-3 d-grid">
					<button type="update" class="btn btn-primary">Update</button>
				</div>
				<div class="col-sm-3 d-grid">
					<a class="btn btn-outline-primary" href="booking.php"
						role="button">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</body>

</html>
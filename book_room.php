<?php
session_start();
include 'db_conn.php'; 

$query = "SELECT VenueName, image FROM venue";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    // Fetching the first row of the result set
    $row = mysqli_fetch_assoc($result);
    $venueName = $row['VenueName'];
} else {
    // If no venue is found, you can set a default name
    $venueName = "Unknown Venue";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'head.php'; ?>
  <style>
     .card {
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      width: 30%;
      float: left; 
      margin: 15px; 
	  height: 360px;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container {
      padding: 2px 16px;
    }

    .navbar {
      padding-top: 100px; /* Add padding to the top of the navbar */
    }
	
    /* Popup container styles */
    .popup {
      display: none; /* Hide the popup by default */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
      z-index: 9999; /* Ensure the popup appears above other content */
    }

    .popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
    }
	
	 .popup-content img {
      max-width: 70%; /* Limit the maximum width of the images to fit the container */
      max-height: 300px; /* Limit the maximum height of the images */
      margin: 10px auto; /* Center the images horizontally */
      display: block; /* Ensure each image is displayed as a block element */
    }
	
	 /* Close button style */
    .close-button {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: transparent;
      border: none;
      color: #333;
      font-size: 18px;
      cursor: pointer;
    }

    /* Close button hover effect */
    .close-button:hover {
      color: #000; /* Change text color on hover */
    }
	
  </style>
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <?php include 'navBarAfter.php'; ?>
    </nav>
	<!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <div class="card-container">
            <h2>&nbsp; Room Reservation</h2>
            <?php
            $bookQuery = "SELECT VenueId, VenueName, image, description, supp_image, supp_image2 FROM venue";
            $bookResult = $conn->query($bookQuery);

            while ($bookRow = $bookResult->fetch_assoc()) {
            ?>
            <div class="card">
              <div class="image-container">
                <img src="<?php echo $bookRow['image']; ?>" alt="Venue Image" style="width:100%; height: 250px; object-fit: cover;">
                <a href="#" class="buttonzzz view-details-btn" data-popup-id="popup-<?php echo $bookRow['VenueId']; ?>">View Details</a>
              </div>
              <div class="container"><br>
                <h4 style="font-size: 17px;"><b><?php echo $bookRow['VenueName']; ?></b></h4><br>
                <a href="resvCalendar.php?VenueId=<?php echo $bookRow['VenueId']; ?>" class="buttonresv">Reserve Now</a>
              </div>
              <div class="popup" id="popup-<?php echo $bookRow['VenueId']; ?>">
                <div class="popup-content">
                  <h2><?php echo $bookRow['VenueName']; ?></h2>
                  <p>Description: <?php echo $bookRow['description']; ?></p>
                  <?php if (!empty($bookRow['supp_image'])): ?>
                    <img src="<?php echo $bookRow['supp_image']; ?>" alt="Supplementary Image 1">
                  <?php endif; ?>
                  <?php if (!empty($bookRow['supp_image2'])): ?>
                    <img src="<?php echo $bookRow['supp_image2']; ?>" alt="Supplementary Image 2">
                  <?php endif; ?>
                  <button onclick="closePopup('popup-<?php echo $bookRow['VenueId']; ?>')">Close</button>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'javaScript.php'; ?>
  <script>
    function openPopup(popupId) {
      var popup = document.getElementById(popupId);
      if (popup) {
        popup.style.display = 'block';
      }
    }

    function closePopup(popupId) {
      var popup = document.getElementById(popupId);
      if (popup) {
        popup.style.display = 'none';
      }
    }

    var viewDetailsButtons = document.querySelectorAll('.view-details-btn');
    viewDetailsButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        var popupId = this.dataset.popupId;
        openPopup(popupId);
        event.preventDefault();
      });
    });
  </script>
</body>
</html>
<style>
.view-details-btn {
    display: none; /* Hide the button by default */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.5);
    color: #333;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
}

.card:hover .view-details-btn {
    display: block;
}

.image-container {
    position: relative;
}

 .popup {
      display: none; 
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
      z-index: 9999; /* Ensure the popup appears above other content */
    }

    .popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
    }
	
	.buttonresv {
            background-color:  white;
            color: black;
            border: 1px solid black;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
			margin-left: 140px;
        }

        .buttonresv:hover {
            background-color: #D2D2CF;
        }
		
		a:link,
a:visited,
a:hover,
a:active {
    text-decoration: none;
}

a:link,
a:visited,
a:hover,
a:active {
    text-decoration: none;
	color: black;
}

a {
    color: black;
    text-decoration: none;
}
</style>
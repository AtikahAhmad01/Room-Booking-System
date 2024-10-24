<?php
session_start();
?>

<?php
session_start();
include 'db_conn.php'; 

// Retrieve the venue ID from the URL
if(isset($_GET['VenueId'])) {
    $venueId = $_GET['VenueId'];

    // Query to fetch the venue name based on the venue ID
    $query = "SELECT VenueName FROM venue WHERE VenueId = $venueId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if the venue name exists
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $venueName = $row['VenueName'];
    } else {
        $venueName = "Unknown Venue";
    }
} else {
    // Redirect the user if the VenueId parameter is not provided
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'head.php'; ?>
</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <?php include 'navBarAfter.php'; ?>
    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-calendar-clock"></i>
            </span> Choose Date of Reservation for Venue: <?php echo $venueName; ?> <!-- Display the venue name here -->
          </h3>
        </div>
        <nav aria-label="breadcrumb">
          
        </nav>
        <div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script>
  $(document).ready(function() {
    // Fetch the venue ID from the URL
    const venueId = <?php echo $venueId; ?>;

    // AJAX request to fetch the calendar for the specified venue ID
    $.ajax({
      url: "calendar.php",
      type: "POST",
      data: { 'month': '<?php echo date('m');?>', 'year': '<?php echo date('Y');?>', 'VenueId': venueId },
      success: function(data) {
        $("#calendar").html(data);
      }
    });
  });

  $(document).on('click', '.changemonth', function() {
    // Fetch the venue ID from the URL
    const venueId = <?php echo $venueId; ?>;

    // AJAX request to fetch the calendar for the specified venue ID and selected month/year
    $.ajax({
      url: "calendar.php",
      type: "POST",
      data: { 'month': $(this).data('month'), 'year': $(this).data('year'), 'VenueId': venueId },
      success: function(data) {
        $("#calendar").html(data);
      }
    });
  });
</script>
<script>
  const form = document.querySelector('form');
  const reservationStatus = document.getElementById('reservationStatus');

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Simulate reservation processing (replace with actual logic)
    setTimeout(function() {
      reservationStatus.textContent = 'Reservation booked successfully!';
      reservationStatus.classList.add('alert-success');
      reservationStatus.style.display = 'block';
      form.reset();
    }, 2000);
  });
</script>


<?php
include 'javaScript.php';
?>

</html>

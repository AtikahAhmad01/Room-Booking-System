<?php
session_start();
include 'db_conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venueId = $_POST['VenueID'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $deptName = $_POST['DeptName'];
    $activity = $_POST['activity'];
    $reserved_by = $_POST['reserved_by'];  

    // Calculate the one-hour gap end time
    $end_time_obj = new DateTime($end_time);
    $one_hour_gap = clone $end_time_obj;
    $one_hour_gap->add(new DateInterval('PT1H')); 
    $one_hour_gap_time = $one_hour_gap->format('H:i:s'); 

    // Query to check if any booking conflicts exist for the same venue
    $query = "SELECT * FROM reservation WHERE VenueId = ? AND date = ? AND 
              ((start_time < ? AND end_time > ?) OR 
               (start_time < ? AND end_time > ?) OR 
               (? < start_time AND ? > end_time))";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssssss', $venueId, $date, $end_time, $start_time, $one_hour_gap_time, $start_time, $start_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['form_data'] = [
            'VenueID' => $venueId,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'DeptName' => $deptName,
            'activity' => $activity,
            'reserved_by' => $reserved_by
        ];
        echo "<script>
                alert('This time slot is unavailable at the selected venue. Please choose another time or venue.');
                window.history.back();
              </script>";
    } else {
        // Insert the new booking
        $insert_query = "INSERT INTO reservation (VenueId, date, start_time, end_time, DeptName, activity, reserved_by) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt->prepare($insert_query);
        $stmt->bind_param('issssss', $venueId, $date, $start_time, $end_time, $deptName, $activity, $reserved_by);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Booking successful!');
                    window.location.href = 'indexAfter.php'; // Redirect to your form page
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $stmt->error . "');
                    window.history.back(); 
                  </script>";
        }
    }
    $stmt->close();
}
?>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "onlinebooking";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resevID = $_POST['resevID'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $date = $_POST['date'];
    $DeptName = $_POST['DeptName'];
    $activity = $_POST['activity'];
    $VenueId = $_POST['VenueName'];
    $reserved_by = $_POST['reserved_by']; 

    // Convert time to HH:MM format
    $start_time = date("H:i", strtotime($start_time));
    $end_time = date("H:i", strtotime($end_time));

    // Validate the one-hour gap
    $sql_check = "SELECT start_time, end_time FROM reservation 
                  WHERE date = ? AND VenueId = ? AND resevID != ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("sii", $date, $VenueId, $resevID);
    $stmt->execute();
    $result = $stmt->get_result();

    $canBook = true;
    
    while ($row = $result->fetch_assoc()) {
        $existing_start_time = date("H:i", strtotime($row['start_time']));
        $existing_end_time = date("H:i", strtotime($row['end_time']));

        // Check if the new start or end time is within one hour of any existing booking
        if (($start_time >= $existing_start_time && $start_time < date("H:i", strtotime("+1 hour", strtotime($existing_end_time)))) ||
            ($end_time > $existing_start_time && $end_time <= date("H:i", strtotime("+1 hour", strtotime($existing_end_time)))) ||
            ($start_time <= $existing_start_time && $end_time >= $existing_end_time)) {
            $canBook = false;
            break;
        }
    }

    if ($canBook) {
        // Proceed with the update if the booking is valid
        $sql_update = "UPDATE reservation 
            SET DeptName = ?, activity = ?, start_time = ?, end_time = ?, date = ?, VenueId = ?, reserved_by = ? 
            WHERE resevID = ?";        
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssi", $DeptName, $activity, $start_time, $end_time, $date, $VenueId, $reserved_by, $resevID);
        if ($stmt_update->execute()) {
            echo "<script>
                    alert('Successfully edited the reservation!');
                    window.location.href = 'indexAfter.php'; 
                  </script>";
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
    } else {
        echo "<script>
                alert('This time slot is unavailable. Please choose another time.');
                window.history.back();
              </script>";      
    }
}

// Redirect to newEdit.php with the resevID parameter if there's no POST request
if (!isset($_POST['resevID'])) {
    if (isset($_GET['id'])) {
        $resevID = $_GET['id'];
        header("Location: newEdit.php?id=$resevID");
        exit();
    } else {
        // Handle the case where no ID is provided
        echo "No reservation ID provided.";
    }
}

$conn->close();
?>

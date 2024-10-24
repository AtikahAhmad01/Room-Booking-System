<?php
// delete_reservation.php

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

  $sql = "DELETE FROM reservation WHERE resevID = $resevID";

  if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); // Redirect to your dashboard after deletion
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}

$conn->close();
?>


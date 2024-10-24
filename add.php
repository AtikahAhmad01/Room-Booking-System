<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $VenueName = $_POST['venueName'];
    $Description = $_POST['description'];
    $Image = $_POST['image'];
    $SuppImage = $_POST['supp_image'];
    $SuppImage2 = $_POST['supp_image2'];

    $stmt = $conn->prepare("INSERT INTO venue (VenueName, description, image, supp_image, supp_image2) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $VenueName, $Description, $Image, $SuppImage, $SuppImage2);

    if ($stmt->execute()) {
        echo "<script>alert('New venue inserted successfully.'); window.location = 'index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

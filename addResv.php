<?php

include 'db_conn.php';

if (isset($_POST['create'])) {
    $resevID = $_POST['resevID'];
    $DeptName = $_POST['DeptName'];
    $VenueName = $_POST['VenueName'];
    $activity = $_POST['activity'];
    $Times = $_POST['Times'];

    $sql = "INSERT INTO `reservation` (resevID, DeptName, VenueName, Activity,Times)
    VALUES ('$resevID', '$DeptName', '$VenueName','$activity','$Times')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data inserted successfully";
    } else {
        die(mysqli_error($conn));
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Add New Reservation</title>
</head>
<body>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Add New Reservation</h1>
            <div>
                <a href="resvPage.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        
        <form method="post">
    <div class="form-elemnt my-4">
        <input type="hidden" name="resevID" value="<?php echo mt_rand(1000, 9999); ?>">
    </div>
    <div class="form-elemnt my-4">
        <input type="text" class="form-control" name="DeptName" placeholder="Department">
    </div>
    <div class="form-element my-4">
        <select class="form-control" name="VenueName">
            <option selected disabled>Select Venue</option>
            <?php
            // Connect to the database
            include 'db_conn.php';

            // Check if the connection was successful
            if ($conn) {
                // Fetch values from the database table
                $query = "SELECT venueName FROM venue";
                $result = mysqli_query($conn, $query);

                // Iterate through the results and create dropdown options
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value=>" . $row['venueName'] . "</option>";
                }

                // Close the database connection
                mysqli_close($conn);
            }
            ?>
        </select>
    </div>
    
                    <div class="mb-3">
                        <label for="Times" class="form-label">Times</label>
                        <textarea name="Times" class="form-control" placeholder="Times" id="Times"></textarea>
                      </div>

    <div class="form-element my-4">
        <textarea name="activity" class="form-control" placeholder="activity"></textarea>
    </div>
    <div class="form-element my-4">
       
            <?php
            // Connect to the database
            include 'db_conn.php';


            ?>
        </select>
    </div>
    
    <div class="form-element my-4">
        <input type="submit" name="create" value="Add Reservation" class="btn btn-primary">
    </div>
</form>


    </div>

</body>
</html>
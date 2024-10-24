<?php
session_start();
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
      <?php include 'navBar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-multiple"></i>
              </span> List Of Reservation List
            </h3>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <header class="d-flex justify-content-between my-4">
                      <h1>Admin Reservation List</h1>
                      <div>
                        <a href="addResv.php" class="btn btn-primary">Add Reservation</a>
                      </div>
                    </header>
                    <table class="table table-hover">
                      <thead>
                        <tr class='table-dark'>
                          <th>Venue</th>
                          <th>Department</th>
                          <th>Times</th>
                          <th>Date</th>
                          <th>Notes</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
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
    <?php include 'javaScript.php'; ?>
  </body>
</html>
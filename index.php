<!DOCTYPE html>
<html lang="en">

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "onlinebooking";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>

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
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
              </span> Dashboard
            </h3>
            <nav aria-label="breadcrumb">
            </nav>
          </div>

          <section class="bg-gradient-primary  text-white py-5 " style="background-color: #808080;">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                  <h2 class="display-4 mb-4 ">Welcome to MNFSB</h2>
				  <a href="#" id="addRoomLink" title="Add Room">
					<img src="assets/images/faces-clipart/add.png" style="width: 40px; margin-left: 750px; margin-top: -150px;" alt="profile">
				  </a>
                  <a href="book_room.php" class="btn btn-light btn-lg shadow bg-body-tertiary rounded">Book
                    Now</a>
                </div>
              </div>
            </div>
          </section>
		  <div id="addRoomPopup" class="popup-form" style="display: none;">
			<form action="add.php" method="post">
			<h1><strong>Add New Venue</h1></strong><br>
				<label for="venueName">Venue Name:</label>
				<input type="text" id="venueName" name="venueName">
				<label for="description">Description:</label>
				<input type="text" id="description" name="description">
				<label for="image">Image:</label>
				<input type="file" id="image" name="image" onchange="previewFile(this, 'imagePreview')">
				<img id="imagePreview">
				<label for="supp_image">Image 2:</label>
				<input type="file" id="supp_image" name="supp_image" onchange="previewFile(this, 'suppImagePreview')">
				<img id="suppImagePreview">
				<label for="supp_image2">Image 3:</label>
				<input type="file" id="supp_image2" name="supp_image2" onchange="previewFile(this, 'suppImage2Preview')">
				<img id="suppImage2Preview">
				<button type="submit" class="addbuttonz">Add Room</button>
			</form>
		</div>

          <div class="card">
    <div class="card-body">
        <h2 class="text-center mt-4">RECENT RESERVATIONS</h2><br>

		<div class="row mb-3">
            <div class="col-lg-6 offset-lg-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            </div>
        </div>
        <table class="table table-hover" id="reservationTable">
            <thead>
                <tr class='table-dark'>
                    <th style="width: 0.5%;">No</th>
                    <th class="sortable" data-column="times">Date<span class="sort-icon">&#9660;</span></th>
					<th class="sortable" data-column="times">Start Time<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="times">End Time<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="venue">Venue <span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="department">Department <span class="sort-icon">&#9660;</span></th>
					<th class="sortable" data-column="notes">Reserved By<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="notes">Notes <span class="sort-icon">&#9660;</span></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               <?php
					// Read all rows from the database table based on the client ID and search query
					$sql = "SELECT r.resevID, r.date, r.start_time, r.end_time, v.VenueName, r.DeptName, r.reserved_by, r.activity 
							FROM reservation r
							INNER JOIN venue v ON r.VenueId = v.VenueId";
					$result = $conn->query($sql);

					$rowNumber = 1;
					
					if ($result->num_rows > 0) {
						// Output data of each row
						while ($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>" . $rowNumber . "</td>";
							echo "<td>" . $row["date"] . "</td>";
							echo "<td>" . $row["start_time"] . "</td>";
							echo "<td>" . $row["end_time"] . "</td>";
							echo "<td>" . $row["VenueName"] . "</td>"; 
							echo "<td>" . $row["DeptName"] . "</td>";
							echo "<td>" . $row["reserved_by"] . "</td>";
							echo "<td>" . $row["activity"] . "</td>";  
                   echo '<td>
							<a style="position: relative; width: 40px; padding: 3px 5px; border-radius: 5px;" href="newEdit.php?id=' . $row["resevID"] . '" class="viewBtn">
								<button>Edit</button>
							</a>
							<button class="deleteBtn" onclick="confirmDelete(' . $row['resevID'] . ')">Delete</button>
					</td>';

                        echo "</tr>";$rowNumber++;
                  }  
                } else {
                  echo "<tr><td colspan='5'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function confirmDelete(resevID) {
    var confirmation = confirm("Are you sure you want to delete this record?");
    if (confirmation) {
        // If user confirms, redirect to delete script with the reservation ID
        window.location.href = 'delResv.php?id=' + resevID;
    } else {
        // If user cancels, do nothing
        return false;
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addRoomLink = document.getElementById('addRoomLink');
    const addRoomPopup = document.getElementById('addRoomPopup');

    addRoomLink.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior

        // Toggle the visibility of the popup form
        addRoomPopup.style.display = addRoomPopup.style.display === 'none' ? 'block' : 'none';
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('reservationTable');
        const headers = table.querySelectorAll('.sortable');

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-column');
                const sortOrder = header.classList.contains('asc') ? 'desc' : 'asc';

                // Remove sorting classes from all headers
                headers.forEach(header => {
                    header.classList.remove('asc', 'desc');
                    header.querySelector('.sort-icon').innerHTML = '&#9660;'; // Reset all arrow icons
                });

                // Set sorting class and arrow icon for the clicked header
                header.classList.add(sortOrder);
                header.querySelector('.sort-icon').innerHTML = sortOrder === 'asc' ? '&#9650;' : '&#9660;';

                // Perform sorting
                sortTable(table, column, sortOrder);
            });
        });

        function sortTable(table, column, sortOrder) {
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // Sort the rows based on the specified column and sortOrder
            rows.sort((rowA, rowB) => {
                const cellA = rowA.querySelector(`td:nth-child(${getHeaderIndex(column) + 1})`).textContent.trim();
                const cellB = rowB.querySelector(`td:nth-child(${getHeaderIndex(column) + 1})`).textContent.trim();

                if (sortOrder === 'asc') {
                    return cellA.localeCompare(cellB);
                } else {
                    return cellB.localeCompare(cellA);
                }
            });

            // Remove existing rows from the table
            tbody.innerHTML = '';

            // Append sorted rows to the table
            rows.forEach(row => {
                tbody.appendChild(row);
            });
        }

        function getHeaderIndex(column) {
            const headers = Array.from(table.querySelectorAll('th'));
            return headers.findIndex(header => header.getAttribute('data-column') === column);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#reservationTable tbody tr');

        searchInput.addEventListener('input', function () {
            const searchQuery = this.value.trim().toLowerCase();

            tableRows.forEach(row => {
                const cells = Array.from(row.querySelectorAll('td'));
                let found = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchQuery)) {
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
  <?php
  include 'javaScript.php';
  ?>
</body>
</html>
<style>
.viewBtn {
    text-decoration: none;
    display: inline-block;	
	width: 50px;
}

.viewBtn button {
    border: none;
    cursor: pointer;
    padding: 2px 3px;
    background-color: #4CAF50;
    color: white;
    transition: background-color 0.3s ease;
}

.viewBtn button i {
    font-size: 20px;
    margin-right: 5px;
}

.viewBtn button:hover {
    background-color: #45a049;
}

/* Additional styling for the link text */
.viewBtn .link-text {
    font-size: 16px;
    margin-left: 5px;
}


.deleteBtn {
    border: none;
    cursor: pointer;
    padding: 5px 10px;
    margin: 0 5px;
    border-radius: 5px; /* Optional: for rounded corners */
}

.deleteBtn i {
    font-size: 20px;
}

.deleteBtn {
    background-color: #f44336; /* Red */
    color: white;
}

.deleteBtn:hover {
    background-color: #da190b;
}

.viewBtn {
    background-color: #4CAF50; /* Green */
    color: white;
}

.viewBtn:hover {
    background-color: #45a049;
}

.add-btn {
    background-color: #808080;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    margin-left: 820px;
    transition: background-color 0.3s ease;
}

.add-btn i {
    margin-right: 5px; /* Adds some space between the plus icon and text */
}

.add-btn:hover {
    background-color: #8a8787; /* Darker blue color on hover */
}

.add-student-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.add-student-modal-content {
    background-color: #fefefe;
    margin: 1% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.popup-form {
        position: fixed;
        top: 47%;
        left: 60%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 9999;
		max-height: 80%; /* Set maximum height for the popup */
        overflow-y: auto; /* Enable vertical scrolling */
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

   .popup-form input[type="text"],
.popup-form input[type="file"],
.popup-form button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}
	
	.addbuttonz {
    background-color: #9a55ff;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    width: 100%;
}

.addbuttonz:hover {
    background-color: #da8cff;
}

h1{
	font-size: 23px;
}

   /* Image preview styles */
    .img-preview {
		max-width: 100px; 
		max-height: 100px;
    }
</style>
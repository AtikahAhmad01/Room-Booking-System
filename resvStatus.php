<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<?php
  include 'head.php';
  ?>
  <?php
  include 'db_conn.php';
  ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <?php include 'navBarAfter.php'; ?>
        </nav>
		     <div class="main-panel">
				<div class="content-wrapper">
        <div class="container"> 
            <h1>Reservations Confirmed</h1>
            <button id="printTableBtn" class="add-btn">
                <i class="fa fa-print"></i>
            </button>

            <div class="row mb-3">
                <div class="col-lg-6 offset-lg-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                </div>
            </div>

            <table class="table table-hover" id="reservationTable">
            <thead>
                <tr class='table-dark'>
                    <th style="width: 0.5%;">No</th>
                    <th class="sortable" data-column="date">Date <span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="times">Start Time<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="times">End Time<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="venue">Venue <span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="department">Department <span class="sort-icon">&#9660;</span></th>
					<th class="sortable" data-column="notes">Reserved By<span class="sort-icon">&#9660;</span></th>
                    <th class="sortable" data-column="notes">Notes <span class="sort-icon">&#9660;</span></th>
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
    </div>
</body>
</html>
<?php
include 'javaScript.php';
?>
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #reservationTable, #reservationTable * {
            visibility: visible;
        }
        #reservationTable {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
    <style>
        .container-scroller {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1100px;
            margin: 10px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
	<script>
document.addEventListener('DOMContentLoaded', function () {
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#reservationTable tbody tr');

        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            let found = false;

            columns.forEach(column => {
                if (column.textContent.toLowerCase().includes(searchValue)) {
                    found = true;
                }
            });

            row.style.display = found ? '' : 'none';
        });
    });

    // Sort functionality
    const tableHeaders = document.querySelectorAll('#reservationTable th.sortable');

    tableHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const column = this.dataset.column;
            const sortIcon = this.querySelector('.sort-icon');

            const direction = sortIcon.classList.contains('asc') ? 'desc' : 'asc';

            // Reset sort icons
            tableHeaders.forEach(header => {
                header.querySelector('.sort-icon').innerHTML = '&#9660;';
                header.querySelector('.sort-icon').classList.remove('asc', 'desc');
            });

            // Update sort icon for the clicked column
            sortIcon.innerHTML = direction === 'asc' ? '&#9650;' : '&#9660;';
            sortIcon.classList.add(direction);

            // Sort the table
            const index = Array.from(this.parentNode.children).indexOf(this);
            const rows = Array.from(document.querySelectorAll('#reservationTable tbody tr'));

            const sortedRows = rows.sort((a, b) => {
                const aValue = a.querySelectorAll('td')[index].textContent.trim();
                const bValue = b.querySelectorAll('td')[index].textContent.trim();

                return direction === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            });

            const tbody = document.querySelector('#reservationTable tbody');
            tbody.innerHTML = '';

            sortedRows.forEach(row => tbody.appendChild(row));
        });
    });
});
</script>
<script>
document.getElementById('printTableBtn').addEventListener('click', function () {
    var table = document.getElementById('reservationTable').cloneNode(true); // Clone the table
    var title = document.createElement('h1'); // Create a title element
    title.textContent = 'All Reservations'; // Set the title text
    var wrapper = document.createElement('div'); // Create a wrapper element
    wrapper.appendChild(title); // Append the title to the wrapper
    wrapper.appendChild(table); // Append the table to the wrapper
    document.body.innerHTML = ''; // Clear the body
    document.body.appendChild(wrapper); // Append the wrapper to the body
    window.print(); // Trigger the print action
    location.reload(); // Reload the page to restore original content
});
</script>
  <?php
  include 'javaScript.php';
  ?>
<style>
.add-btn {
    background-color: #808080;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    margin-left: 920px;
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
</style>
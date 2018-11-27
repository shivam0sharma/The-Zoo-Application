<?php
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    $staff = $_SESSION['email'];
    $query = "SELECT * FROM ShowTable WHERE (host like '%".$staff."%')";
    $result = mysqli_query($ntwk, $query);


?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>

body {
  background-color: rgb(230, 223, 207)
}

.center {
    margin: auto;
    width: 75%;
    border: 3px solid #73AD21;
    padding: 10px;
}

.btn {
  margin: auto;
  width: 8%;
  border: 2px solid black;
  border-radius: 5px;
  background-color: white;
  color: black;
  padding: 5px 15px;
  font-size: auto;
  cursor:pointer;
}

th:hover{
    cursor: pointer;
}

table, th, td {
    border: 1px solid black;
}

</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Staff - Show History</h1>

<div class="center">
    <div class="container">
        <a href="StaffHome.php"><button class="btn">Go Home</button></a>
    </div>
    <div class="container">
        
        <table class="table table-bordered" id="staffShow">
            <thead>
                <tr>
                    <th onclick="tablesort(0)">Name</th>
                    <th onclick="sortTable(1)">Time</th>
                    <th onclick="sortTable(2)">Exhibit</th>
                </tr>
            </thead>
            <?php while($row = mysqli_fetch_array($result)) {?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['showTime']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                </tr>
            <?php }?>
                    
        </table>
    </div>
</div>

</body>
</html>

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("staffShow");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
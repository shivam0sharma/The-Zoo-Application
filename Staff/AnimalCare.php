<?php
    session_start();
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    $query = "SELECT * FROM TreatmentNote";
    $result = mysqli_query($ntwk, $query);


}
?>
<!DOCTYPE html>
<html>
<head>
<title>Animal Detail</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

body {
  background-color: rgb(230, 223, 207)
}

.center {
    margin: auto;
    width: 50%;
    border: 3px solid #73AD21;
    padding: 10px;
}

.btn {
  margin: auto;
  width: 10%;
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

</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Animal Detail</h1>

<div class="center">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <h4 id="name"></h4>
            </div>
            <div class="col-sm-3">
                <h4 id="species"></h4>
            </div>
            <div class="col-sm-2">
                <h5>Age: </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <h5>Exhibit: </h5>
            </div>
            <div class="col-sm-2">
                <h5>Type: </h5>
            </div>
        </div>

        <div class="row">
            <div class="form-inline" method="post" action="AnimalCare.php">
                <textarea name="msg" rows="4" cols="50" maxlength="200"></textarea>
                <input class="btn" type="submit" name="search" value="Log Notes">
            </div>
        </div>
        
    </div>
    <div>
        <table class="table table-bordered" id="treatmentTable">
                <tr>
                    <th onclick="sortTable(0)">Staff Member</th>
                    <th onclick="sortTable(1)">Note</th>
                    <th onclick="sortTable(2)">Time</th>
                </tr>
                <?php while($row = mysqli_fetch_array($result)) {?>
                <tr>
                    <td><?php echo $row['staff']; ?></td>
                    <td><?php echo $row['msg']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                </tr>
            <?php }?>
        </table>
    </div>
</div>

</body>
</html>

<script>
var queryString = decodeURIComponent(window.location.search);
queryString = queryString.substring(1);

var queries = queryString.split("&");
var index = queries[0].indexOf("=");
var nameIn = queries[0].substring(index + 1);
nameIn = nameIn.replace(/_/g, " ");
index = queries[1].indexOf("=");
var speciesIn = queries[1].substring(index + 1);
speciesIn = speciesIn.replace(/_/g, " ");

$("#name").text("Name: " + nameIn);
$("#species").text("Species: " + speciesIn);

var type, age, exhibit;
var details;
$.ajax({
    type: "POST",
    url: "http://localhost/Staff/AnimalDetail.php",
    data: {name: nameIn, species: speciesIn},
    success: function(obj) {
        details = obj;
    }


});

console.log(details);




function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("treatmentTable");
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
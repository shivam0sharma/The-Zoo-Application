<?php
if(isset($_POST['search']))
{
    $animalToSearch = $_POST['name'];
    $speciesToSearch = $_POST['species'];
    $exhibitToSearch = $_POST['exhibit'];
    $ageMinToSearch = $_POST['ageMin'];
    $ageMaxToSearch = $_POST['ageMax'];
    if ($ageMaxToSearch < $ageMinToSearch) {
        $ageMinToSearch = 0;
        $ageMaxToSearch = 100;
    }
    $typeToSearch = $_POST['type'];
    $query = "SELECT * FROM `Animal` WHERE (name like '%".$animalToSearch."%' AND species LIKE '%".$speciesToSearch."%'
        AND exhibit LIKE '%".$exhibitToSearch."%' AND animalType LIKE '%".$typeToSearch."%'  
        AND age >= $ageMinToSearch AND age <= $ageMaxToSearch)";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `Animal`";
    $search_result = filterTable($query);
}
// function to connect and execute the query
function filterTable($query)
{
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    $filter_Result = mysqli_query($ntwk, $query);
    return $filter_Result;
}
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

.btn2 {
  margin: auto;
  width: 15%;
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

tr:hover {
    cursor: pointer;
}

table {
    border: 1px solid black;
}

</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Atlanta Zoo Animals</h1>

<div class="center">
    <div class="container">
        <a href="StaffHome.php"><button class="btn">Go Home</button></a>
    </div>
    <br>
    <div class="container">
            <form class="form-inline" method="post" action="StaffAnimal.php">
                    <div class="form-group row">
                        <label for="name">Name: </label>
                        <input type="text" class="form-control" name="name">
                        <label for="species">Species: </label>
                        <input type="text" class="form-control" name="species">
                        <label for="type">Type: </label>
                        <select class="form-control" name="type">
                            <option></option>
                            <option>Mammal</option>
                            <option>Bird</option>
                            <option>Amphibian</option>
                            <option>Reptile</option>
                            <option>Fish</option>
                            <option>invertebrate</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group row"  style="padding-top:10px">
                        <label for="exhibit" >Exhibit: </label>
                        <select class ="form-control" name="exhibit">
                            <option></option>
                            <option>Birds</option>
                            <option>Jungle</option>
                            <option>Mountainous</option>
                            <option>Pacific</option>
                            <option>Sahara</option>
                        </select>
                        <label for="age-min" >Min Age: </label>
                        <select class="form-control" name="ageMin" id="age-min"style="padding-left:5px">
                            <option selected="selected">1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                        </select>
                        <label for="age-max" >Max Age: </label>
                        <select class="form-control" name="ageMax" id="age-max">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option selected="selected">8</option>
                        </select>
                        <input class="btn2" type="submit" name="search" value="Search">
                    </div>
                    
                </form>
    </div>
    
    <div>
    <table class="table table-bordered" id="animalTable">
                <thead>
                    <th onclick="sortTable(0)">Name</th>
                    <th onclick="sortTable(1)">Species</th>
                    <th onclick="sortTable(2)">Exhibit</th>
                    <th onclick="sortTable(3)">Age</th>
                    <th onclick="sortTable(4)">Type</th>
                </thead>
            <?php while($row = mysqli_fetch_array($search_result)) {?>
                <tr class="data">
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['species']; ?></td>
                    <td><?php echo $row['exhibit']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['animalType']; ?></td>
                </tr>
            <?php }?>
                    
        </table>
    </div>
</div>
<script>
$("document").ready(function() {
    $("tr.data").click(function() {
        var tableData = $(this).children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(tableData);

        var location = "http://localhost/Staff/AnimalCare.php?";
        location = location + "name=" + tableData[0];
        location = location + "&species=" + tableData[1];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("animalTable");
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


</body>
</html>



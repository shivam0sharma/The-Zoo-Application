<?php
       session_start();
       $user = $_SESSION['username'];
       $query = "SELECT name,species FROM `Animal` WHERE exhibit='Pacific'";
       $search_result = filterTable($query);
       // function to connect and execute the query
       function filterTable($query) {
       $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
       $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
       $password ="Efhjn754"; /* the password for phpmyadmin */
       $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
       $ntwk = mysqli_connect($hostname, $username, $password, $database);
       $filter_Result = mysqli_query($ntwk, $query);
       return $filter_Result;
       mysqli_close($ntwk);
      }
?>
   <?php
      if(isset($_POST['submit'])) {
         date_default_timezone_set("America/New_York");
         $currentTime = date("Y-m-d H:i:s");
         $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
         $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
         $password ="Efhjn754"; /* the password for phpmyadmin */
         $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
         $ntwk = mysqli_connect($hostname, $username, $password, $database);
         $user = $_SESSION['username'];
         $query2 = "INSERT INTO ExhibitVisit (visitor,exhibit,visitTime) VALUES ('$user','Pacific','$currentTime')";
         $result = mysqli_query($ntwk,$query2);
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Visitor Exhibit Details for Pacific</title>
      <link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
      <style>
         body {
         background-color: rgb(246,242,241);
         }
         th:hover{
         cursor: pointer;
         }
         tr:hover {
         cursor: pointer;
         }  
         .container {
         margin: 0 auto;
         width: 45%;
         border: 3px solid #73AD21;
         padding: auto;
         margin-top: auto;
         }
         .container2 {
         position: static;
         margin: 0 auto;
         width: 45%;
         margin-bottom: 5%;
         margin-left: 5%
         }
         .headerTitle {
         margin-top: 2%;
         margin-left: 35%;
         margin-right: 30%;
         }
         .row2 {
         position: static;
         margin-top: -20%;
         margin-left: 130%;
         margin-right: 0%;
         }
      </style>
      <div align="center" class="container">
      <div align="center" class="headerTitle">
         <h4>
         Exhibit Details - Pacific
         <h4>
         <br>
      </div>        
      <div class="row">
            <div class="container2">
                <a href="VisitorFunctionality.php"> <button type="button"> Go Home! </button></a>
                <a href="ExhibitHistory.php"> <button type="button"> Exhibit History Page</button></a>
               <br>
               <br>
            <?php
            
            $query3 = "SELECT COUNT(name) AS Num_of_Animals FROM `Animal` WHERE exhibit='Pacific'";
            $query4 = "SELECT * FROM Exhibit WHERE name = 'Pacific'";
            $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
            $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
            $password ="Efhjn754"; /* the password for phpmyadmin */
            $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
            $ntwk = mysqli_connect($hostname, $username, $password, $database);
            $filterQuery3 = mysqli_query($ntwk, $query3);
            $filterQuery4 = mysqli_query($ntwk, $query4);?>

            <h4>Exhibit Name: Pacific <br><?php while($row = $filterQuery4-> fetch_assoc()) {
               echo "Size: ".$row["size"]." <br>";
               echo "Water Feature: ";
               if ($row["waterFeature"]) {
                  echo "Yes <br>";
               } else {
                  echo "No <br>";
               }
               }
            ?>
            <?php while($row = $filterQuery3-> fetch_assoc()) {
               echo "Number of Animals: ".$row["Num_of_Animals"]." <br>";
               }
            ?>
            </h4>
               
               <form method="post"><input type="submit" name="submit" value="Log Visit"/>
               <div class="col-sm-10 col-sm-offset-2">
                    <?php echo $insert_result; ?>
               </div>
   </form>
               <div class="row">
                  <table class="table table-striped" id="exhibitTable">
                     <thead>
                        <tr>
                           <th scope="col" onclick="sortTable(0)">Animal Name</th>
                           <th scope="col" onclick="sortTable(1)">Species</th>
                        </tr>
                     </thead>
                     <!-- populate table from mysql database -->
                     <?php while($row = mysqli_fetch_array($search_result)):?>
                     <tr class="data">
                        <td class="success"><?php echo $row['name'];?></a></td>
                        <td class="danger"><?php echo $row['species'];?></td>
                     </tr>
                     <?php endwhile;?>
                  </table>
               </div>
            </div>
      </div>

<script>
$("document").ready(function() {
    $("tr.data").click(function() {
        var tableData = $(this).children("td").map(function() {
            return $(this).text();
        }).get();

        var location = "./AnimalDetail.php?";
        location = location + "name=" + tableData[0];
        location = location + "&species=" + tableData[1];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
   });

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("exhibitTable");
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
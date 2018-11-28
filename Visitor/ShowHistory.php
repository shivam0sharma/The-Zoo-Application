<?php
   session_start();
   if(isset($_POST['search'])) {
       $nameToSearch = $_POST['showName'];
       $visitToSearch = $_POST['visitTime'];
       $timeToSearch = $_POST['time'];
       $exhibitToSearch = $_POST['exhibit'];
   
       $user = $_SESSION['username'];
       $query = "SELECT * FROM `ShowVisit` INNER JOIN `ShowTable` ON showName = name WHERE name LIKE '%".$nameToSearch."%'
           AND showTime LIKE '%".$visitToSearch."%' AND showTime LIKE '%".$timeToSearch."%' AND location LIKE '%".$exhibitToSearch."%'
           AND visitor = '$user'";
       $search_result = filterTable($query);
   }
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
       //session_destroy();
      }
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Visitor Show History</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
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
         Show History - Atlanta Zoo
         <h4>
         <br>
      </div>
      <div align="center">
         <img src="show.jpg" alt="Zoo" width="80%;"></p><br>
      </div>
      <div class="row">
         <form action="ShowHistory.php" method="post">
            <div class="container2">
               <strong>Show Name: &nbsp;</strong><input type="text" name="showName" placeholder="Name">
               <br>
               <br>
               <strong>Show Date: &nbsp;</strong><input type="date" name="visitTime">
               <br>
               <br>
               <strong>Show Time: &nbsp; </strong><input type="time" name="time">
               <br>
               <br>
               <strong>Exhibits: &nbsp; </strong><input list="Exhibits" name="exhibit" placeholder="Exhibits">
               <br>
               <br>
               <datalist id="Exhibits">
                  <option value="Birds">
                  <option value="Jungle">
                  <option value="Mountainous">
                  <option value="Pacific">
                  <option value="Sahara">
               </datalist>
               <div>
               <input type="submit" name="search" value="Search">
               <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
               </div>
               <br>
               <div class="row2">
               </div>
               <br>
               <br>
               <div class="row">
               <table class="table table-striped" id="showHistoryTable">
               <thead>
               <tr>
               <th scope="col" onclick="sortTable(0)">Show Name</th>
               <th scope="col" onclick="sortTable(1)">Date/Time</th>
               <th scope="col" onclick="sortTable(2)">Exhibit</th>  
               </tr>
               </thead>
               <!-- populate table from mysql database -->
               <?php while($row = mysqli_fetch_array($search_result)):?>
               <tr>
               <td class="success"><?php echo $row['showName'];?></td>
               <td class="danger"><?php echo $row['visitTime'];?></td>
               <td class="info"><?php echo $row['location'];?></td>
               </tr>
               <?php endwhile;?>
               </table>
               </div>
            </div>
         </form>
      </div>

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("showHistoryTable");
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
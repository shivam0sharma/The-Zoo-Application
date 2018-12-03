<?php
   session_start();
   $sort;
   if (isset($_GET['sort'])) {
      $sort = str_replace('_', " ", htmlspecialchars($_GET["sort"]));
   }


   if(isset($_POST['search'])) {
       $nameToSearch = $_POST['exhibitName'];
       $visitDateToSearch = $_POST['visitDate'];
       $minToSearch = $_POST['minNum'];
       if (empty($minToSearch)) {
         $minToSearch = 1;
      }
       $maxToSearch = $_POST['maxNum'];
       if (empty($maxToSearch)) {
         $maxToSearch = 1000;
      }

       $user = $_SESSION['username'];
       $query = "SELECT a.exhibit, a.visitTime, b.visits FROM ExhibitVisit a
       join (SELECT exhibit, COUNT(distinct visitTime) visits FROM ExhibitVisit where visitor = '$user' and exhibit like '%".$nameToSearch."%' and visitTime like '%".$visitDateToSearch."%' group by exhibit) b 
       on a.exhibit = b.exhibit where a.visitor = '$user' and a.exhibit like '%".$nameToSearch."%' and a.visitTime like '%".$visitDateToSearch."%'";
      
      if(!empty($sort)) {
         $query = $query . ' ORDER BY ExhibitVisit.' . $sort;
      }
      $search_result = filterTable($query);
   } else {
       
       $user = $_SESSION['username'];
       $query = "SELECT a.exhibit, a.visitTime, b.visits FROM ExhibitVisit a
       join (SELECT exhibit, COUNT(distinct visitTime) visits FROM ExhibitVisit where visitor = '$user' group by exhibit) b 
       on a.exhibit = b.exhibit where a.visitor = '$user'";

      if(!empty($sort)) {
         $query = $query . ' ORDER BY a.' . $sort;
      }
       
       if (empty($minToSearch)) {
         $minToSearch = 1;
       }
      if (empty($maxToSearch)) {
        $maxToSearch = 1000;
     }
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
      <title>Visitor Exhibit History</title>
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

         th.sortable:hover{
         cursor: pointer;
         }
         .container {
         margin: 0 auto;
         width: 50%;
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
         tr.data {
            cursor: pointer;
         }
      </style>
      <div align="center" class="container">
      <div align="center" class="headerTitle">
         <h4>
         Exhibit History - Atlanta Zoo
         <h4>
         <br>
      </div>
      <div align="center">
         <img src="exhibit.jpg" alt="Zoo" width="100%;"></p><br>
      </div>
      <div class="row">
         <form action="" method="post">
            
            <strong>Exhibits: &nbsp; </strong><input list="Exhibits" name="exhibitName" placeholder="Name" autocomplete="off" value="<?php echo isset($_POST['exhibitName']) ? $_POST['exhibitName'] : '';?>">
               <datalist id="Exhibits">
                  <option value="Birds">
                  <option value="Jungle">
                  <option value="Mountainous">
                  <option value="Pacific">
                  <option value="Sahara">
               </datalist>
               <strong>Visited Date: </strong><input type="date" name="visitDate" value="<?php echo isset($_POST['visitDate']) ? $_POST['visitDate'] : '';?>">
               <br>
               <br>
               <strong>Num of Visit - Min: &nbsp; </strong><input type="text" name="minNum" value="<?php echo isset($_POST['minNum']) ? $_POST['minNum'] : '';?>">
               <strong>Num of Visit - Max: &nbsp; </strong><input type="text" name="maxNum" value="<?php echo isset($_POST['maxNum']) ? $_POST['maxNum'] : '';?>">
               <br>
               <div>
               <br>
               <br>
               <input type="submit" name="search" value="Search">
               <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
               <br>
               <br>
               <br>
               </div>
               <br>
               <div class="row2">
               </div>
               <br>
               <br>
               
               <br>
               <br>
                  <table class="table table-striped" id="exhibitHistoryTable">
                     <thead>
                        <tr>
                           <th class="sortable" scope="col" onclick="sort('exhibit')">Exhibit Name</th>
                           <th class="sortable" scope="col" onclick="sort('visitTime')">Date/Time</th>
                           <th scope="col">Number of Visits</th>
                        </tr>
                     </thead>
                     <!-- populate table from mysql database -->
                     <?php while($row = mysqli_fetch_array($search_result)):
                     if ($row['visits'] >= $minToSearch && $row['visits'] <= $maxToSearch) {
                        echo '<tr class="data">';?>
                        <td class="success"><?php echo $row["exhibit"];?></td>
                        <td class="danger"><?php echo $row["visitTime"];?></td>
                        <td class="info"><?php echo $row["visits"];?></td>
                        </tr>
                     <?php } endwhile?>
                  </table>
               
         </form>
      </div>

<script>
$("document").ready(function() {
    $("tr.data").click(function() {
        var tableData = $(this).children("td").map(function() {
            return $(this).text();
        }).get();

        var location = "./ExhibitDetail.php?";
        location = location + "name=" + tableData[0];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});
function sort(type) {
   var queryString = decodeURIComponent(window.location.search);
    queryString = queryString.substring(1);
    var queries = queryString.split("&");
    var index = queries[0].indexOf("=");
    var sortIn = queries[0].substring(index + 1);
    if (sortIn == type) {
        type = type + "_DESC";
    }
    window.location = './ExhibitHistory.php?sort=' + type;
}
</script>
   </body>
</html>
<?php
   session_start();

   $sort;
   if (isset($_GET['sort'])) {
      $sort = $_GET['sort'];
   }
      $nameToSearch = $_POST['showName'];
      $visitToSearch = $_POST['visitTime'];
      $exhibitToSearch = $_POST['exhibit'];
   
      $user = $_SESSION['username'];
      $query = "SELECT * FROM `ShowVisit` INNER JOIN `ShowTable` ON showName = name WHERE name LIKE '%".$nameToSearch."%'
         AND showTime LIKE '%".$visitToSearch."%' AND location LIKE '%".$exhibitToSearch."%'
         AND visitor = '$user'";

      if(!empty($sort)) {
         $query = $query . ' ORDER BY ShowVisit.' . $sort;
      }
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

         th.sortable:hover{
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
         tr.data {
            cursor: pointer;
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
         <form action="" method="post">
            
               <strong>Show Name: &nbsp;</strong><input type="text" name="showName" placeholder="Name" value="<?php echo isset($_POST['showName']) ? $_POST['showName'] : '';?>">
               <br>
               <br>
               <strong>Show Date: &nbsp;</strong><input type="date" name="visitTime" value="<?php echo isset($_POST['visitTime']) ? $_POST['visitTime'] : '';?>">
               
               <strong>&nbsp;&nbsp;Exhibits: &nbsp; </strong><input list="Exhibits" name="exhibit" autocomplete="off" placeholder="Exhibits" value="<?php echo isset($_POST['exhibit']) ? $_POST['exhibit'] : '';?>">
               
               <datalist id="Exhibits">
                  <option value="Birds">
                  <option value="Jungle">
                  <option value="Mountainous">
                  <option value="Pacific">
                  <option value="Sahara">
               </datalist>
               <div>
               <br>
               <br>
               <input type="submit" name="search" value="Search">
               <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
               </div>
               <br>
               
               </div>
               
               
               <table class="table table-striped" id="showHistoryTable">
               <thead>
               <tr>
               <th class="sortable" scope="col" onclick="sort('showName')">Show Name</th>
               <th class="sortable" scope="col" onclick="sort('visitTime')">Date/Time</th>
               <th scope="col">Exhibit</th>  
               </tr>
               </thead>
               <!-- populate table from mysql database -->
               <?php while($row = mysqli_fetch_array($search_result)):?>
               <tr class="data">
               <td class="success"><?php echo $row['showName'];?></td>
               <td class="danger"><?php echo $row['visitTime'];?></td>
               <td class="info"><?php echo $row['location'];?></td>
               </tr>
               <?php endwhile;?>
               </table>
              
            
         </form>
     

<script>
$("document").ready(function() {
    $("tr.data").click(function() {
        var tableData = $(this).children("td").map(function() {
            return $(this).text();
        }).get();

        var location = "./ShowDetail.php?";
        location = location + "name=" + tableData[0];
        location = location + "&time=" + tableData[1];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});
function sort(type) {
   
    window.location = './ShowHistory.php?sort=' + type;
}
</script>
   </body>
</html>
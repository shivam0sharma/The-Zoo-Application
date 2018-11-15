<?php

if(isset($_POST['search']))
{
    $nameToSearch = $_POST['showName'];
    $visitToSearch = $_POST['visitTime'];
    $exhibitToSearch = $_POST['exhibit'];
<<<<<<< HEAD
    $timeToSearch = $_POST['time'];

    $query = "SELECT * FROM `ShowTable` WHERE (showTime LIKE '%".$visitToSearch."%' AND name LIKE '%".$nameToSearch."%'
        AND location LIKE '%".$exhibitToSearch."%' AND showTime LIKE '%".$timeToSearch."%')";
=======

    $query = "SELECT * FROM `ShowTable` WHERE showTime LIKE '%".$visitToSearch."%'";
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
    $search_result = filterTable($query);
    
}
 else {

   /* $query = "SELECT * FROM `Animal`";
    $search_result = filterTable($query);*/
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
<<<<<<< HEAD
    mysqli_close($ntwk);
=======
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
}

?>

<<<<<<< HEAD
=======

>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
<!DOCTYPE html>

<html>
<head>
<title>Visitor Show History</title>

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

    .container {
        position:static;
        margin: 0 auto;
        width: 45%;
        border: 3px solid #73AD21;
        padding: auto;
        margin-top: 10%;
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
        <h4>Show History - Atlanta Zoo<h4><br>
    </div>

<div align="center">
    <img src="show.jpg" alt="Zoo" width="80%;"></p>
    <br>
    
</div>

    <div class="row">
    <form action="ShowHistory.php" method="post">

<div class="container2">
        <strong>Show Name: &nbsp;</strong><input type="text" name="showName" placeholder="Name">
<<<<<<< HEAD
        <br>
        <br>
        <strong>Show Date: &nbsp;</strong><input type="date" name="visitTime">
        <br>
        <br>
        <strong>Show Time: &nbsp; </strong><input type="time" name="time">
=======
        <br><br>
        <strong>Time: &nbsp;</strong><input type="datetime-local" name="visitTime">
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
        <br>
        <br>
        <strong>Exhibits: &nbsp; </strong><input list="Exhibits" name="exhibit" placeholder="Exhibits">
        <br>
        <br>
<<<<<<< HEAD

=======
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
        <datalist id="Exhibits">
            <option value="Birds">
            <option value="Jungle">
            <option value="Mountainous">
            <option value="Pacific">
            <option value="Sahara">
        </datalist>
        <input type="submit" name="search" value="Search">
        <div class="row2">
        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
    </div>
        <br>
        <br>
           <div class="row">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Show Name</th>
<<<<<<< HEAD
                    <th scope="col">Date/Time</th>
=======
                    <th scope="col">Time</th>
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
                    <th scope="col">Exhibit</th>  
                </tr>
            </thead>

<<<<<<< HEAD
                <!-- populate table from mysql database -->
=======
            <!-- populate table from mysql database -->
>>>>>>> 058eaa51d0b7880f3c080820dd643ffb697fc98e
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td class="success"><?php echo $row['name'];?></td>
                    <td class="danger"><?php echo $row['showTime'];?></td>
                    <td class="info"><?php echo $row['location'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </div>
    </div>
    </form>
</div>
</body>
</html>
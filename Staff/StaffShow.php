<?php
    session_start();
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    $query = "SELECT * FROM ShowTable";
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
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Exhibit</th>
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


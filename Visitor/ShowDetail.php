<?php
    session_start();
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    
    $name = str_replace('_', " ", htmlspecialchars($_GET["name"]));
    $species = str_replace('_', " ", htmlspecialchars($_GET["location"]));
    $detailsQuery = "SELECT * FROM ShowTable WHERE (name like '%".$name."%' AND location LIKE '%".$location."%')";
    $details = mysqli_query($ntwk, $detailsQuery);
    $details = mysqli_fetch_array($details);
    
?>
<!DOCTYPE html>
<html>
<head>
<title>Show Detail</title>
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

.alert{
    width: 25%;
}
</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Animal Detail</h1>

<div class="center">
    <div class="container">
        <a href="VisitorFunctionality.php"><button class="btn">Go Home</button></a>
        <a href="StaffAnimal.php"><button class="btn">Go Back</button></a>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <h4 id="name"></h4>
            </div>
            <div class="col-sm-3">
                <h4 id="species"></h4>
            </div>
            <div class="col-sm-2">
                <?php 
                    echo '<h4>Age: ' . $details['age'] . ' months';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?php 
                    echo '<h4>Exhibit: ' . $details['exhibit'];
                ?>
            </div>
            <div class="col-sm-2">
                <?php 
                    echo '<h4>Type: ' . $details['animalType'];
                ?>
            </div>
        </div>

        <div class="row">
            <form id="logForm"method="post" action=>
                <textarea name="msg" rows="4" cols="50" maxlength="200"></textarea>
                <button class="btn" type="submit" name="log">Log Notes</button>
                <div class="col-sm-10 col-sm-offset-2">
                    <?php echo $insert_result; ?>    
                </div>
            </form>
        </div>
        
    </div>
    <div>
        <table class="table table-bordered" id="treatmentTable">
                <tr>
                    <th onclick="sort('staff')">Staff Member</th>
                    <th onclick="sort('message')">Note</th>
                    <th onclick="sort('noteTime')">Time</th>
                </tr>
                <?php while($row = mysqli_fetch_array($result)) {?>
                <tr>
                    <td><?php echo $row['staff']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['noteTime']; ?></td>
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

function sort(type) {
    var queryString = decodeURIComponent(window.location.search);
    queryString = queryString.substring(1);
    var queries = queryString.split("&");
    var index = queries[0].indexOf("=");
    var nameIn = queries[0].substring(index + 1);
    nameIn = nameIn.replace(/_/g, " ");
    index = queries[1].indexOf("=");
    var locationIn = queries[1].substring(index + 1);
    locationIn = locationIn.replace(/_/g, " ");

    window.location = "./AnimalCare.php?name=" + nameIn + "&location=" + locationIn + "&sort=" + type;
}
</script>
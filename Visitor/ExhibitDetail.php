<?php
    session_start();
    $sort;
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    
    $name = str_replace('_', " ", htmlspecialchars($_GET["name"]));
    $detailsQuery = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
    FROM Exhibit
    JOIN Animal
    ON Exhibit.name=Animal.exhibit
    WHERE Exhibit.name like '%" . $name . "%'";
    $details = mysqli_query($ntwk, $detailsQuery);
    $details = mysqli_fetch_array($details);
    $exhibit = $details['name'];

    $query = "SELECT * 
    FROM Animal
    WHERE exhibit like '%". $exhibit."%'";
    if(!empty($sort)) {
        $query = $query . ' ORDER BY Animal.' . $sort;
    }
    $search_result = mysqli_query($ntwk, $query);

    if(isset($_POST['log'])) {
        $user = $_SESSION['username'];
        $insert = "INSERT INTO ExhibitVisit (visitor, exhibit, visitTime)
        VALUES ('$user', '$exhibit', NOW())";
        echo $insert;

        $insertCmd = mysqli_query($ntwk, $insert);
        if ($insertCmd) {
            $insert_result = '<div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Log Recorded!</div>';
        } else {
            $insert_result = '<div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Log Not Recorded!</div>';
        }
        
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

tr.data {
    cursor: pointer;
}

.alert{
    width: 25%;
}
</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Exhibit Detail</h1>

<div class="center">
    <div class="container">
        <a href="./VisitorFunctionality.php"><button class="btn">Go Home</button></a>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <?php 
                    echo '<h4>Name: ' . $details['name'];
                ?>
            </div>
            <div class="col-sm-2">
                <?php 
                    echo '<h4>Size: ' . $details['size'];
                ?>
            </div>
            <div class="col-sm-2">
                <?php
                    if ($details['waterFeature']) {
                        echo '<h4>Water Feature: Yes';
                    } else {
                        echo '<h4>Water Feature: No';
                    }
                ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?php
                    echo '<h4>Number of Animals: ' . $details['animalCount'];
                ?>
            </div>
        </div>
        <form id="logForm"method="post" action=>
            <button class="btn" type="submit" name="log">Log Visit</button>
            <div class="col-sm-10 col-sm-offset-2">
                <?php echo $insert_result; ?>    
            </div>
        </form>

        
        
    </div>

    <table class="table table-bordered" id="animalTable">
                <thead>
                    <th onclick="sort('name')">Name</th>
                    <th onclick="sort('species')">Species</th>
                </thead>
            <?php while($row = mysqli_fetch_array($search_result)) {?>
                <tr class="data">
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['species']; ?></td>
                </tr>
            <?php }?>
                    
        </table>
</div>

</body>
</html>

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
function sort(type) {
    var queryString = decodeURIComponent(window.location.search);
    queryString = queryString.substring(1);
    var queries = queryString.split("&");
    var index = queries[0].indexOf("=");
    var nameIn = queries[0].substring(index + 1);
    nameIn = nameIn.replace(/_/g, " ");
    window.location = './ExhibitDetail.php?name=' + nameIn + '&sort=' + type;
}

</script>
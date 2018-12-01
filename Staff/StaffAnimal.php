<?php

$sort;

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
if (isset($_POST['search'])) {
    $animalToSearch = $_POST['name'];
    $speciesToSearch = $_POST['species'];
    $exhibitToSearch = $_POST['exhibit'];
    $typeToSearch = $_POST['type'];
    $ageMinToSearch = $_POST['ageMin'];
    $ageMaxToSearch = $_POST['ageMax'];

    if (empty($ageMinToSearch)) {
        $ageMinToSearch = 1;
    }
    if (empty($ageMaxToSearch)) {
        $ageMaxToSearch = 8;
    }

    
    if ($ageMaxToSearch < $ageMinToSearch) {
        $ageMinToSearch = 1;
        $_POST['ageMin'] = 1;
        $ageMaxToSearch = 8;
        $_POST['ageMax'] = 8;
    }
    
    if (empty($sort)){
        $query = "SELECT * FROM `Animal` WHERE (name like '%".$animalToSearch."%' AND species LIKE '%".$speciesToSearch."%'
        AND exhibit LIKE '%".$exhibitToSearch."%' AND animalType LIKE '%".$typeToSearch."%'  
        AND age >= $ageMinToSearch AND age <= $ageMaxToSearch)";
    } else {
        $query = "SELECT * FROM `Animal` WHERE (name like '%".$animalToSearch."%' AND species LIKE '%".$speciesToSearch."%'
        AND exhibit LIKE '%".$exhibitToSearch."%' AND animalType LIKE '%".$typeToSearch."%'  
        AND age >= $ageMinToSearch AND age <= $ageMaxToSearch) ORDER BY Animal.$sort ASC";
    }
} else {

    if (empty($ageMinToSearch)) {
        $ageMinToSearch = 1;
    }
    if (empty($ageMaxToSearch)) {
        $ageMaxToSearch = 8;
    }
    if (empty($sort)){
        $query = "SELECT * FROM `Animal` WHERE (name like '%".$animalToSearch."%' AND species LIKE '%".$speciesToSearch."%'
        AND exhibit LIKE '%".$exhibitToSearch."%' AND animalType LIKE '%".$typeToSearch."%'  
        AND age >= $ageMinToSearch AND age <= $ageMaxToSearch)";
    } else {
        $query = "SELECT * FROM `Animal` WHERE (name like '%".$animalToSearch."%' AND species LIKE '%".$speciesToSearch."%'
        AND exhibit LIKE '%".$exhibitToSearch."%' AND animalType LIKE '%".$typeToSearch."%'  
        AND age >= $ageMinToSearch AND age <= $ageMaxToSearch) ORDER BY Animal.$sort ASC";
    }
}

    $search_result = filterTable($query);
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
            <form class="form-inline" id="form" method="post" action="">
                    <div class="form-group row">
                        <label for="name" >Name: </label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
                        <label for="species">Species: </label>
                        <input type="text" class="form-control" id="species "name="species" value="<?php echo isset($_POST['species']) ? $_POST['species'] : '';?>">
                        <label for="type">Type: </label>
                        <input list="type" id="type1" name="type" autocomplete="off" value="<?php echo isset($_POST['type']) ? $_POST['type'] : '';?>">
                        <datalist id="type">
                            <option>Mammal</option>
                            <option>Bird</option>
                            <option>Amphibian</option>
                            <option>Reptile</option>
                            <option>Fish</option>
                            <option>Invertebrate</option>
                        </datalist>
                    </div>
                    <br>
                    <div class="form-group row"  style="padding-top:10px">
                        <label for="exhibit" >Exhibit: </label>
                        <input list="exhibit" id="exhibit1" name="exhibit" autocomplete="off" value="<?php echo isset($_POST['exhibit']) ? $_POST['exhibit'] : '';?>">
                        <datalist id="exhibit">
                            <option>Birds</option>
                            <option>Jungle</option>
                            <option>Mountainous</option>
                            <option>Pacific</option>
                            <option>Sahara</option>
                        </datalist>
                        <label for="age-min" >Min Age: </label>
                        <input list="age-min" id="ageMin" name="ageMin" autocomplete="off" value="<?php echo isset($_POST['ageMin']) ? $_POST['ageMin'] : 1;?>">
                        <datalist id="age-min">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                        </datalist>
                        </select>
                        <label for="age-max" >Max Age: </label>
                        <input list="age-max" id="ageMax" name="ageMax" autocomplete="off" value="<?php echo isset($_POST['ageMax']) ? $_POST['ageMax'] : 8;?>">
                        <datalist id="age-max">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                        </datalist>
                        <input class="btn2" type="submit" name="search" value="Search">
                    </div>
                    
                </form>
    </div>
    
    <div>
    <table class="table table-bordered" id="animalTable">
                <thead>
                    <th onclick="sort('name')">Name</th>
                    <th onclick="sort('species')">Species</th>
                    <th onclick="sort('exhibit')">Exhibit</th>
                    <th onclick="sort('age')">Age (months)</th>
                    <th onclick="sort('animalType')">Type</th>
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

        var location = "./AnimalCare.php?";
        location = location + "name=" + tableData[0];
        location = location + "&species=" + tableData[1];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});

function sort(type) {
    window.location = './StaffAnimal.php?sort=' + type;
}
</script>


</body>
</html>



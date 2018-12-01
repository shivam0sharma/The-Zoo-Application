<?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
        $sort;
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        if (isset($_POST['search'])) {
            
            $name = $_POST['name'];
            $min_num = $_POST['min_animal_num'];
            $max_num = $_POST['max_animal_num'];
            $min_size = $_POST['min_exhibit_num'];
            $max_size = $_POST['max_exhibit_num'];

            if ($_POST['min_animal_num'] == 0) {
                $min_num = 0;
            } else {
                $min_num = $_POST['min_animal_num'];
            }
            if ($_POST['max_animal_num'] == 0) {
                $max_num = PHP_INT_MAX;
            } else {
                $max_num = $_POST['max_animal_num'];
            }

            if ($_POST['min_exhibit_num'] == 0) {
                $min_size = 0;
            } else {
                $min_size = $_POST['min_exhibit_num'];
            }
            if ($_POST['max_exhibit_num'] == 0) {
                $max_size = PHP_INT_MAX;
            } else {
                $max_size = $_POST['max_exhibit_num'];
            }
            if ($_POST['wfeat'] ) {

                

                if ($_POST['wfeat'] === "No") {
                    $water_feature = "0";
                } else if ($_POST['wfeat'] === "Yes") {
                    $water_feature = "1";
                }
                $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
                FROM Exhibit
                JOIN Animal
                ON Exhibit.name=Animal.exhibit
                WHERE Exhibit.name like '%" . $name . "%'
                AND size BETWEEN " . $min_size . " AND " . $max_size . "
                AND waterFeature = " .$water_feature . "
                GROUP BY Exhibit.name
                HAVING count(*) BETWEEN " . $min_num . " AND " . $max_num;
                if(!empty($sort)) {
                    $sql = $sql . ' ORDER BY Animal.' . $sort;
                }
                $result = mysqli_query($conn, $sql);
            } else {

                $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
                FROM Exhibit
                JOIN Animal
                ON Exhibit.name=Animal.exhibit
                WHERE Exhibit.name like '%" . $name . "%'
                AND size BETWEEN " . $min_size . " AND " . $max_size . "
                GROUP BY Exhibit.name
                HAVING count(*) BETWEEN " . $min_num . " AND " . $max_num;
                if(!empty($sort)) {
                    if ($sort == "animalCount") {
                        $sql = $sql . ' ORDER BY ' . $sort;
                    } else if ($sort == "waterFeature") {
                        $sql = $sql . ' ORDER BY ' . $sort .' DESC';
                    } else {
                        $sql = $sql . ' ORDER BY Exhibit.' . $sort;
                    }
                    
                }
                $result = mysqli_query($conn, $sql);
            }

        } else {
            $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
            FROM Exhibit
            JOIN Animal
            ON Exhibit.name=Animal.exhibit
            GROUP BY Exhibit.name";
            if(!empty($sort)) {
                if ($sort == "animalCount") {
                    $sql = $sql . ' ORDER BY ' . $sort;
                } else if ($sort == "waterFeature") {
                    $sql = $sql . ' ORDER BY ' . $sort .' DESC';
                } else {
                    $sql = $sql . ' ORDER BY Exhibit.' . $sort;
                }
            }
            $result = mysqli_query($conn, $sql);
        }
        ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style>
         body {
         background-color: rgb(230, 223, 207)
         }

        .container {
         margin: 0 auto;
         width: 59%;
         border: 3px solid #73AD21;
         padding: auto;
         margin-top: auto;
         }

        .row2 {
         position: static;
         margin-top: -20%;
         margin-left: 130%;
         margin-right: 0%;
         }
         th {
             cursor:pointer;
         }

         tr.data {
             cursor:pointer;
         }
    </style>
<div align="center" class="container">
    <title>Search for Exhibits</title>
</head>
<body>
    <header>
        <h1>
            Zoo Atlanta Exhibits
        </h1>
    </header>
    <br>

    <form method="POST" action="" id="search_params">
        Name: <input list="Exhibits" name="name" placeholder="Exhibits" autocomplete="off" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        <datalist id="Exhibits">
                  <option value="Birds">
                  <option value="Jungle">
                  <option value="Mountainous">
                  <option value="Pacific">
                  <option value="Sahara">
        </datalist>
        &emsp;Water Feature:
        <input list="wfeat" name="wfeat" autocomplete="off" value="<?php echo isset($_POST['wfeat']) ? $_POST['wfeat'] : '';?>">
            <datalist id="wfeat">
                <option value="">
                <option value="Yes">
                <option value="No">
            </datalist>
        <br>
        <br>
        
        Number of Animals: &ensp;Min - 
        <input type="number" min="0" name="min_animal_num" class="animal_num" value="<?php echo isset($_POST['min_animal_num']) ? $_POST['min_animal_num'] : '';?>">
        &ensp;Max -
        <input type="number" min="0" name="max_animal_num" class="animal_num" value="<?php echo isset($_POST['max_animal_num']) ? $_POST['max_animal_num'] : '';?>">
        <br>
        <br>
        Exhibit Size: &ensp;Min -
        <input type="number" min="0" step="10" name="min_exhibit_num" class="exhibit_num" value="<?php echo isset($_POST['min_exhibit_num']) ? $_POST['min_exhibit_num'] : '';?>">
        &ensp;Max -
        <input type="number" min="0" step="10" name="max_exhibit_num" class="exhibit_num" value="<?php echo isset($_POST['max_exhibit_num']) ? $_POST['max_exhibit_num'] : '';?>">
        
        <input type="submit" hidden="hidden" name="search" value="Search">
        <br>
        <br>
        <input type="submit" name="search" value="Search">

        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
    </form>

    
    <br>
    <br>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" onclick="sort('name')">Name</th>
                    <th scope="col" onclick="sort('size')">Size</th>
                    <th scope="col" onclick="sort('animalCount')">NumAnimals</th>
                    <th scope="col" onclick="sort('waterFeature')">Water</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr class="data">
                <td class="success"><?php echo $row['name']; ?></td>
                <td class="danger"><?php echo $row['size']; ?></td>
                <td class="info"><?php echo $row['animalCount']; ?></td>
                <?php
                    if ($row['waterFeature']) {
                       ?><td class="success"><?php echo "Yes"; ?></td>
            <?php   } else {
                        ?><td class="success"><?php echo "No"; ?></td><?php
                    }
                ?>
            </tr>
        <?php } ?>

        </table>
    
    </div>
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
        window.location = './Search_Exhibits.php?sort=' + type;
    }
</script>
</body>
</div>
</html>
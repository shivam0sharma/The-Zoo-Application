<?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');

        $sort;
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $species = $_POST['species'];
            $animal_type = $_POST['select_type'];
            $exhibit = $_POST['select_exhibit'];
            if ($_POST['min_animal_num'] == 0) {
                $min_age = 0;
            } else {
                $min_age = $_POST['min_animal_num'];
            }

            if ($_POST['max_animal_num'] == 0) {
                $max_age = PHP_INT_MAX;
            } else {
                $max_age = $_POST['max_animal_num'];
            }            
            


            $sql = "SELECT name, species, exhibit, age, animalType
            FROM Animal
            WHERE name like '%" . $name . "%'
            AND species like '%" . $species . "%'
            AND animalType like '%" . $animal_type . "%'
            AND exhibit like '%" . $exhibit . "%'
            AND age >= " . $min_age . "
            AND age <= " . $max_age;
            if (!empty($sort)) {
                $sql = $sql . ' ORDER BY Animal.' . $sort;
            }
            $result = mysqli_query($conn, $sql);
        } else {

            $sql = "SELECT name, species, exhibit, age, animalType
            FROM Animal";
            if (!empty($sort)) {
                $sql = $sql . ' ORDER BY Animal.' . $sort;
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
             cursor: pointer;
         }
         tr.data {
             cursor: pointer;
         }
    </style>
        <div align="center" class="container">
    <title>Search for Animals</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <h1>
            Zoo Atlanta Animals
        </h1>
    </header>
    <br>

    <form method="POST" action="" id="search_params">
        Name: <input type="text" name="name" class="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        &emsp;Age: &ensp;Min -
        <input type="number" min="0" name="min_animal_num" class="age_num" value="<?php echo isset($_POST['min_animal_num']) ? $_POST['min_animal_num'] : '';?>">
        &ensp;&ensp;&ensp;Max -
        <input type="number" min="0" name="max_animal_num" class="age_num" value="<?php echo isset($_POST['max_animal_num']) ? $_POST['max_animal_num'] : '';?>">
        <br>
        <br>
        Species:
        <input type="text" name="species" class="text" value="<?php echo isset($_POST['species']) ? $_POST['species'] : '';?>">
        &emsp;&ensp;Type:
        <input list="types" name="select_type" id="type" autocomplete="off" value="<?php echo isset($_POST['select_type']) ? $_POST['select_type'] : '';?>">
            <datalist id="types">
                <option>Mammal</option>
                <option>Bird</option>
                <option>Amphibian</option>
                <option>Reptile</option>
                <option>Fish</option>
                <option>Invertebrate</option>
        </datalist>
        &emsp;Exhibit:
        <input list="select_exhibit" name="select_exhibit" id="exhibit" autocomplete="off" value="<?php echo isset($_POST['select_exhibit']) ? $_POST['select_exhibit'] : '';?>">
            <datalist id="select_exhibit">
            <option></option>
            <option value="birds">
            <option value="jungle">
            <option value="mountainous">
            <option value="sahara">
            <option value="pacific">
        </datalist>
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
                    <th onclick="sort('name')">Name</th>
                    <th onclick="sort('species')">Species</th>
                    <th onclick="sort('exhibit')">Exhibit</th>
                    <th onclick="sort('age')">Age (years)</th>
                    <th onclick="sort('animalType')">Type</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) { ?>

                <tr class="data">
                    <td class="data success"><?php echo $row['name']; ?></td>
                    <td class="data danger"><?php echo $row['species']; ?></td>
                    <td class="exhibit info"><?php echo $row['exhibit']; ?></td>
                    <td class="data success"><?php echo $row['age']; ?></td>
                    <td class="data danger"><?php echo $row['animalType']; ?></td>
                </tr>
            <?php } ?>

        </table>
    
    </div>
    <script>
        $("document").ready(function() {
        $("td.data").click(function() {
            var tableData = $(this).parent().children("td").map(function() {
                return $(this).text();
            }).get();

            var location = "./AnimalDetail.php?";
            location = location + "name=" + tableData[0];
            location = location + "&species=" + tableData[1];
            location = location.replace(/ /g, "_");

            window.location = location;
        });
        $("td.exhibit").click(function() {
            var tableData = $(this).parent().children("td").map(function() {
                return $(this).text();
            }).get();

            var location = "./ExhibitDetail.php?";
            location = location + "name=" + tableData[2];
            location = location.replace(/ /g, "_");

            window.location = location;
        }); 
    });

    function sort(type) {
        window.location = './Search_Animals.php?sort=' + type;
    }
    </script>
</body>


</div>
</html>
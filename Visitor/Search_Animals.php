<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Search_Animals.css">
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

    <form method="POST" action="Search_Animals.php" id="search_params">
        Name: <input type="text" name="name" class="text">
        &emsp;&emsp;&emsp;Age: &ensp;Min
        <input type="number" min="0" name="min_animal_num" class="age_num">
        &ensp;Max 
        <input type="number" min="0" name="max_animal_num" class="age_num">
        <br>
        <br>
        Species:
        <input type="text" name="species" class="text">
        &emsp;&ensp;Type:
        <select name="select_type" id="type">
            <option></option>
            <option value="amphibian">Amphibian</option>
            <option value="bird">Bird</option>
            <option value="fish">Fish</option>
            <option value="mammal">Mammal</option>
        </select>
        &emsp;Exhibit:
        <select name="select_exhibit" id="exhibit">
            <option></option>
            <option value="birds">Birds</option>
            <option value="jungle">Jungle</option>
            <option value="mountainous">Mountainous</option>
            <option value="sahara">Sahara</option>
            <option value="pacific">Pacific</option>
        </select>
        <br>
        <br>
        <input type="submit" name="search" value="Search">

    </form>

    <?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');

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
            $result = mysqli_query($conn, $sql);
        } else {

            $sql = "SELECT name, species, exhibit, age, animalType
            FROM Animal";
            $result = mysqli_query($conn, $sql);

        }
    ?>
    <br>
    <br>
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Species</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Age</th>
                    <th scope="col">Type</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr class="data">
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['species']; ?></td>
                    <td><?php echo $row['exhibit']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['animalType']; ?></td>
                </tr>
            <?php } ?>

        </table>
    
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
    </script>
</body>



</html>
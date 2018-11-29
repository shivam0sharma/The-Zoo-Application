<!DOCTYPE html>
<html>
<head>
    <style>
        body { background-color: rgb(230, 223, 207) }

    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Search for Exhibits</title>
</head>
<body>
    <header>
        <h1>
            Zoo Atlanta Exhibits
        </h1>
    </header>
    <br>

    <form method="POST" action="Search_Exhibits.php" id="search_params">
        Name: <select type="text" name="name">
            <option></option>
            <option value="birds">Birds</option>
            <option value="jungle">Jungle</option>
            <option value="mountainous">Mountainous</option>
            <option value="pacific">Pacific</option>
            <option value="sahara">Sahara</option>
        </select>
        &emsp;&emsp;Number of Animals: &ensp;Min
        <input type="number" min="0" name="min_animal_num" class="animal_num">
        &ensp;Max 
        <input type="number" min="0" name="max_animal_num" class="animal_num">
        <br>
        <br>
        Exhibit Size: &ensp;Min
        <input type="number" min="0" step="10" name="min_exhibit_num" class="exhibit_num">
        &ensp;Max
        <input type="number" min="0" step="10" name="max_exhibit_num" class="exhibit_num">
        &emsp;&emsp;&emsp;Water Feature:
        <select type="text" name="wfeat">
            <option></option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        <br>
        <br>
        <input type="submit" name="search" value="Search">
        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>

    </form>

    <?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');

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

            if ($_POST['wfeat'] === "No") {
                $water_feature = 0;
            } else if ($_POST['wfeat'] === "Yes") {
                $water_feature = 1;
            } else {
                $water_feature = -1;
            }


            $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
            FROM Exhibit
            JOIN Animal
            ON Exhibit.name=Animal.exhibit
            WHERE Exhibit.name like '%" . $name . "%'
            AND size BETWEEN " . $min_size . " AND " . $max_size . "
            AND waterFeature >= " .$water_feature . "
            GROUP BY Exhibit.name
            HAVING count(*) BETWEEN " . $min_num . " AND " . $max_num;
            $result = mysqli_query($conn, $sql);

        } else {
            $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
            FROM Exhibit
            JOIN Animal
            ON Exhibit.name=Animal.exhibit
            GROUP BY Exhibit.name";
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
                    <th scope="col">Size</th>
                    <th scope="col">NumAnimals</th>
                    <th scope="col">Water</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['size']; ?></td>
                <td><?php echo $row['animalCount']; ?></td>
                <td><?php echo $row['waterFeature']; ?></td>
            </tr>
        <?php } ?>

        </table>
    
    </div>
</body>
</html>
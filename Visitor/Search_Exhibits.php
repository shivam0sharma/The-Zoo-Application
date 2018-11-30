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

    <form method="POST" action="Search_Exhibits.php" id="search_params">
        Name: <input list="Exhibits" name="name" placeholder="Exhibits" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        <datalist id="Exhibits">
                  <option value="Birds">
                  <option value="Jungle">
                  <option value="Mountainous">
                  <option value="Pacific">
                  <option value="Sahara">
               </datalist>
        
        &emsp;&emsp;Number of Animals: &ensp;Min - 
        <input type="number" min="0" name="min_animal_num" class="animal_num" value="<?php echo isset($_POST['min_animal_num']) ? $_POST['min_animal_num'] : '';?>">
        &ensp;Max -
        <input type="number" min="0" name="max_animal_num" class="animal_num" value="<?php echo isset($_POST['max_animal_num']) ? $_POST['max_animal_num'] : '';?>">
        <br>
        <br>
        Exhibit Size: &ensp;Min -
        <input type="number" min="0" step="10" name="min_exhibit_num" class="exhibit_num" value="<?php echo isset($_POST['min_exhibit_num']) ? $_POST['min_exhibit_num'] : '';?>">
        &ensp;Max -
        <input type="number" min="0" step="10" name="max_exhibit_num" class="exhibit_num" value="<?php echo isset($_POST['max_exhibit_num']) ? $_POST['max_exhibit_num'] : '';?>">
        &emsp;Water Feature:
        <select type="text" name="wfeat" value="<?php echo isset($_POST['waterFeature']) ? $_POST['waterFeature'] : '';?>">
            <option></option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        
        <input type="submit" hidden="hidden" name="search" value="Search">
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



            $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
            FROM Exhibit
            JOIN Animal
            ON Exhibit.name=Animal.exhibit
            WHERE Exhibit.name like '%" . $name . "%'
            GROUP BY Exhibit.name";
            $result = mysqli_query($conn, $sql);

        } else {
            $sql = "SELECT Exhibit.name, size, count(*) as animalCount, waterFeature
            FROM Exhibit
            JOIN Animal
            ON Exhibit.name=Animal.exhibit
            GROUP BY Exhibit.name
            $result = mysqli_query($conn, $sql)";
        }
        ?>
    <br>
    <br>
    <div>
        <table class="table table-striped">
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
                <td class="success"><?php echo $row['name']; ?></td>
                <td class="danger"><?php echo $row['size']; ?></td>
                <td class="info"><?php echo $row['animalCount']; ?></td>
                <td class="success"><?php echo $row['waterFeature']; ?></td>
            </tr>
        <?php } ?>

        </table>
    
    </div>
    </div>

</body>
</div>
</html>
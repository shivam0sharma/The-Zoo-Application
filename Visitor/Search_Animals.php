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
         width: 45%;
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
    <title>Search for Animals</title>
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
        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>

    </form>

    <?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');

        if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $species = $_POST['species'];
            $animal_type = $_POST['select_type'];
            $exhibit = $_POST['select_exhibit'];


            $sql = "SELECT name, species, exhibit, age, animalType
            FROM Animal
            WHERE name like '%" . $name . "%'
            AND species like '%" . $species . "%'
            AND animalType like '%" . $animal_type . "%'
            AND exhibit like '%" . $exhibit . "%'";
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
        <table class="table table-striped">
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
                <tr>
                    <td class="success"><?php echo $row['name']; ?></td>
                    <td class="danger"><?php echo $row['species']; ?></td>
                    <td class="info"><?php echo $row['exhibit']; ?></td>
                    <td class="success"><?php echo $row['age']; ?></td>
                    <td class="danger"><?php echo $row['animalType']; ?></td>
                </tr>
            <?php } ?>

        </table>
    
    </div>
</body>


</div>
</html>
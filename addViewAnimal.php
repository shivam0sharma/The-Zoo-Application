<!-- need to fix so that not any user can login and then change the url to this page and access it -->
<?php
    session_start();

    if (!isset($_SESSION['email'])) {
    // redirect user to index.php page
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }

    if (isset($_GET['logout'])) {
    // redirect user to index.php page
        session_destroy();
        unset($_SESSION['email']);
        header("location: index.php");
    }

?>
<?php  include('addViewAnimalServer.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Animal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" type="image/png" href="./images/zoo_icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
th.head {
    cursor: pointer;
}

</style>
<body>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="msg">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>

    <a href="admin.php"><button class="btn">Go Home</button></a>

    <form method="post" action="addViewAnimal.php" >

        <?php  include('errors.php'); ?>


        <label style="font-weight:bold; text-align: center; display: block; line-height:150%;">Add/View Animal</label>
        <div class="input-group">
            <label>Name</label>
            <input type="text" placeholder="Name of animal" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        </div>

        <div class="input-group">
            <label>Species</label>
            <input type="text" placeholder="Species of animal" name="species" value="<?php echo isset($_POST['species']) ? $_POST['species'] : '';?>">
        </div>

        <div class="input-group">
            <label>Exhibit</label>
            
            <input list="exhibit" name="exhibit" value="<?php echo isset($_POST['exhibit']) ? $_POST['exhibit'] : '';?>">
            <datalist id="exhibit">
                <?php
                $exhibits = mysqli_query($db, "SELECT * FROM Exhibit");
                while ($exhibit = mysqli_fetch_array($exhibits)) { ?>
                    <option value="<?php echo $exhibit['name']; ?>"></option>
                <?php }?>
            </datalist>
        </div>

        <div class="input-group">
            <label>Animal Type</label>
            <input list="animalType" name="animalType" value="<?php echo isset($_POST['animalType']) ? $_POST['animalType'] : '';?>">
            <datalist id="animalType">
                <option value="Mammal"></option>
                <option value="Bird"></option>
                <option value="Amphibian"></option>
                <option value="Reptile"></option>
                <option value="Fish"></option>
                <option value="Invertebrate"></option>
            </datalist>
        </div>

        

        <div class="input-group">
            <label>Age</label>
            <input type="text" placeholder="Age" name="age">
            <label>Age Range</label>
            <input type="text" placeholder="Min" name="age_min" value="<?php echo isset($_POST['age_min']) ? $_POST['age_min'] : '';?>">
            <input type="text" placeholder="Max" name="age_max" value="<?php echo isset($_POST['age_max']) ? $_POST['age_max'] : '';?>">
        </div>

        <div class="input-group">
            <button class="btn" type="submit" name="add">Add Animal</button>
            <button class="btn" type="submit" name="search">View Animal</button>
        </div>
    </form>


    <table class="table" id="animalTable">
        <thead>
            <tr>
                <th class="head" onclick="sort('name')">Name</th>
                <th class="head" onclick="sort('species')">Species</th>
                <th class="head" onclick="sort('exhibit')">Exhibit</th>
                <th class="head" onclick="sort('age')">Age</th>
                <th class="head" onclick="sort('animalType')">Animal Type</th>
                <th colspan="1">Action</th>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($search_result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['species']; ?></td>
                <td><?php echo $row['exhibit']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['animalType']; ?></td>
                <td>
                    <a href="addViewAnimalServer.php?del_name=<?php echo $row['name']; ?>&del_species=<?php echo $row['species']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<script>
function sort(type) {
    window.location = './addViewAnimal.php?sort=' + type;
}
</script>

</body>
</html>
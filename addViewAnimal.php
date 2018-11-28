<<<<<<< HEAD
=======
<!-- need to fix so that not any user can login and then change the url to this page and access it -->
>>>>>>> 48349cc0f11d78ad7995cb517323f4217fad8189
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
</head>
<body>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="msg">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>

    <form method="post" action="addViewAnimal.php" >

        <?php  include('errors.php'); ?>


        <label style="font-weight:bold; text-align: center; display: block; line-height:150%;">Add/View Animal</label>
        <div class="input-group">
            <label>Name</label>
            <input type="text" placeholder="Name of animal" name="name">
        </div>

        <div class="input-group">
            <label>Exhibit</label>
            <select style="height: 40px; width: 200px;" name="exhibit">
                <?php
                $exhibits = mysqli_query($db, "SELECT * FROM Exhibit");
                while ($exhibit = mysqli_fetch_array($exhibits)) { ?>
                    <option value="<?php echo $exhibit['name']; ?>"><?php echo $exhibit['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="input-group">
            <label>Animal Type</label>
            <select style="height: 40px; width: 200px;" name="animalType">
                <option value="Mammal">Mammal</option>
                <option value="Bird">Bird</option>
                <option value="Amphibian">Amphibian</option>
                <option value="Reptile">Reptile</option>
                <option value="Fish">Fish</option>
                <option value="Invertebrate">Invertebrate</option>
            </select>
        </div>

        <div class="input-group">
            <label>Species</label>
            <input type="text" placeholder="Species of animal" name="species">
        </div>

        <div class="input-group">
            <label>Age</label>
            <input type="text" placeholder="Age" name="age">
            <label>Age Range</label>
            <input type="text" placeholder="Min" name="age_min">
            <input type="text" placeholder="Max" name="age_max">
        </div>

        <div class="input-group">
            <button class="btn" type="submit" name="add">Add Animal</button>
            <button class="btn" type="submit" name="search">View Animal</button>
        </div>
    </form>


    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Species</th>
                <th>Exhibit</th>
                <th>Age</th>
                <th>Animal Type</th>
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
                    <a href="addViewAnimalServer.php?del=<?php echo $row['name']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
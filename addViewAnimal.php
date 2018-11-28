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


    <table class="table" id="animalTable">
        <thead>
            <tr>
                <th class="head" onclick="sortTable(0)">Name</th>
                <th class="head" onclick="sortTable(1)">Species</th>
                <th class="head" onclick="sortTable(2)">Exhibit</th>
                <th class="head" onclick="sortTable(3)">Age</th>
                <th class="head" onclick="sortTable(4)">Animal Type</th>
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
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("animalTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

</body>
</html>
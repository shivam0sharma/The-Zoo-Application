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
<?php  include('addViewShowServer.php'); ?>
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

    <form method="post" action="addViewShow.php" >

        <?php  include('errors.php'); ?>


        <label style="font-weight:bold; text-align: center; display: block; line-height:150%;">Add/View Show</label>
        <div class="input-group">
            <label>Name</label>
            <input type="text" placeholder="Name of show" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        </div>

        <div class="input-group">
            <label>Exhibit Location</label>
            <input list="location" name="location" value="<?php echo isset($_POST['location']) ? $_POST['location'] : '';?>">
            <datalist id="location">
            <?php
                $locations = mysqli_query($db, "SELECT * FROM Exhibit");
                while ($location = mysqli_fetch_array($locations)) { ?>
                    <option value="<?php echo $location['name']; ?>">
                <?php } ?>
            </datalist>
        </div>

        <div class="input-group">
            <label>Staff</label>
            <input list="staff" name="staff" value="<?php echo isset($_POST['staff']) ? $_POST['staff'] : '';?>">
            <datalist id="staff">
                <?php
                $staffs = mysqli_query($db, "SELECT * FROM Staff");
                while ($staff = mysqli_fetch_array($staffs)) { ?>
                    <option value="<?php echo $staff['username']; ?>"><?php echo $staff['username']; ?></option>
                <?php } ?>
            </datalist>
        </div>

        <div class="input-group">
            <label>Show Time</label>
            <input type="date" name="showTime" value="<?php echo isset($_POST['showTime']) ? $_POST['showTime'] : '';?>">
        </div>

        <div class="input-group">
            <button class="btn" type="submit" name="add">Add Show</button>
            <button class="btn" type="submit" name="search">View Show</button>
        </div>
    </form>


    <table class="table" id="showTable">
        <thead>
            <tr>
                <th class="head" onclick="sortTable(0)">Name</th>
                <th class="head" onclick="sortTable(1)">Exhibit Location</th>
                <th>Date</th>
                <th colspan="1">Action</th>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($search_result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo date('d/m/y  h:i A', strtotime($row['showTime'])) ; ?></td>
                <td>
                    <a href="addViewShowServer.php?del_name=<?php echo $row['name']; ?>&del_time=<?php echo $row['showTime']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("showTable");
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
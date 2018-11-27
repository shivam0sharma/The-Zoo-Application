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

    <form method="post" action="addViewShow.php" >

        <?php  include('errors.php'); ?>


        <label style="font-weight:bold; text-align: center; display: block; line-height:150%;">Add/View Show</label>
        <div class="input-group">
            <label>Name</label>
            <input type="text" placeholder="Name of show" name="name">
        </div>

        <div class="input-group">
            <label>Exhibit Location</label>
            <select style="height: 40px; width: 200px;" name="location">
                <?php
                $locations = mysqli_query($db, "SELECT * FROM Exhibit");
                while ($location = mysqli_fetch_array($locations)) { ?>
                    <option value="<?php echo $location['name']; ?>"><?php echo $location['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="input-group">
            <label>Staff</label>
            <select style="height: 40px; width: 200px;" name="staff">
                <?php
                $staffs = mysqli_query($db, "SELECT * FROM Staff");
                while ($staff = mysqli_fetch_array($staffs)) { ?>
                    <option value="<?php echo $staff['username']; ?>"><?php echo $staff['username']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="input-group">
            <label>Show Time</label>
            <input type="datetime-local" name="showTime">
        </div>

        <div class="input-group">
            <button class="btn" type="submit" name="add">Add Show</button>
            <button class="btn" type="submit" name="search">View Show</button>
        </div>
    </form>


    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Exhibit Location</th>
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
                    <a href="addViewShowServer.php?del=<?php echo $row['name']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
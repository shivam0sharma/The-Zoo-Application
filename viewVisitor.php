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
<?php  include('viewVisitorServer.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD: CReate, Update, Delete PHP MySQL</title>
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

    <form method="post" action="" >
        <div class="input-group">
            <label>Search</label>
            <input type="text" name="valueToSearch" placeholder="Value To Search">
        </div>
        <div class="input-group">
            <button class="btn" type="submit" name="search">Search</button>
        </div>
    </form>

    <table class="table" id="visitorTable">
        <thead>
            <tr>
                <th class="head" onclick="sort('username')">Username</th>
                <th class="head" onclick="sort('email')">Email</th>
                <th colspan="1">Action</th>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($search_result)) { ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="viewVisitorServer.php?del=<?php echo $row['username']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<script>
function sort(type) {
    window.location = './viewVisitor.php?sort=' + type;
}
</script>

</body>
</html>
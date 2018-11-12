<!-- need to fix so that not any user can login and then change the url to this page and access it -->
<?php
    session_start();

    if (!isset($_SESSION['email'])) {
    // redirect user to login.php page
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
    // redirect user to login.php page
        session_destroy();
        unset($_SESSION['email']);
        header("location: login.php");
    }

?>
<?php  include('viewStaffServer.php'); ?>
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

    <form method="post" action="addAnimal.php" >
        <label style="font-weight:bold; text-align: center; display: block; line-height:150%;">Add Animal</label>
        <div class="input-group">
            <label>Name</label>
            <input type="text" placeholder="Name of animal">
        </div>

        <div class="input-group">
            <label>Exhibit</label>
            <select style="height: 40px; width: 200px;">
                <option value="volvo">Exhibit1</option>
                <option value="saab">Exhibit2</option>
                <option value="opel">Exhibit3</option>
                <option value="audi">Exhibit4</option>
            </select>
        </div>

        <div class="input-group">
            <label>Type</label>
            <select style="height: 40px; width: 200px;">
                <option value="volvo">Type1</option>
                <option value="saab">Type1</option>
                <option value="opel">Type1</option>
                <option value="audi">Type1</option>
            </select>
        </div>

        <div class="input-group">
            <label>Species</label>
            <input type="text" placeholder="Species of animal">
        </div>

        <div class="input-group">
            <label>Age</label>
            <select style="height: 40px; width: 200px;">
                <option value="volvo">1</option>
                <option value="saab">2</option>
                <option value="opel">3</option>
                <option value="audi">4</option>
            </select>
        </div>

        <div class="input-group">
            <button class="btn" type="submit">Add Animal</button>
        </div>
    </form>

</body>
</html>
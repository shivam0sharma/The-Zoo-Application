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
        unset($_SESSION['username']);
        header("location: ../index.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
<title>Staff Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

body {
  background-color: rgb(230, 223, 207)
}

.center {
    margin: auto;
    width: 45%;
    border: 3px solid #73AD21;
    padding: 10px;
}

.btn {
  margin: auto;
  width: 25%;
  border: 2px solid black;
  border-radius: 5px;
  background-color: white;
  color: black;
  padding: 14px 28px;
  font-size: auto;
  cursor:pointer;
}

/* Green */
.searchAnimal {
  border-color: #4CAF50;
  color: green;
  margin:auto;
}

.searchAnimal:hover {
  background-color: #4CAF50;
  color: white;
  margin:auto;
}

/* Orange */
.viewShows {
  border-color: #ff9800;
  color: orange;
  margin:auto;
}

.viewShows:hover {
  background: #ff9800;
  color: white;
  margin:auto;
}

/* Gray */
.logOut {
  border-color: #e7e7e7;
  color: Gray;
  margin:auto;
}

.logOut:hover {
  background: #e7e7e7;
  color: white;
  margin:auto;
}

</style>
</head>

<body>

<br>
<h1 style="text-align:center;">Welcome Staff!</h1>

<div class="center">
<p style="text-align:center;"><img src="../images/zoo.jpg" alt="Zoo" width="80%;"></p>
<h1 style="text-align:center;">
<a href="StaffAnimal.php"><button class="btn searchAnimal">Search Animals</button></a>
<a href="StaffShow.php"><button class="btn viewShows">View Shows</button></a>
<a href="StaffHome.php?logout='1'"><button class="btn logOut">Log Out</button></a>


</h1>
</div>

</body>
</html>
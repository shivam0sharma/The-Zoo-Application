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
      <title>Visitor Functionality</title>
      <link rel="shortcut icon" type="image/png" href="../images/zoo_icon.png">
      <meta name="viewport" content="width=device-width, initial-scale=1">
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
         .searchExhibit {
         border-color: #4CAF50;
         color: green;
         margin:auto;
         }
         .searchExhibit:hover {
         background-color: #4CAF50;
         color: white;
         margin:auto;
         }
         /* Blue */
         .viewExhibitHistory {
         border-color: #2196F3;
         color: dodgerblue;
         margin:auto;
         }
         .viewExhibitHistory:hover {
         background: #2196F3;
         color: white;
         margin:auto;
         }
         /* Orange */
         .searchShows {
         border-color: #ff9800;
         color: orange;
         margin:auto;
         }
         .searchShows:hover {
         background: #ff9800;
         color: white;
         margin:auto;
         }
         /* Red */
         .viewShowHistory {
         border-color: #f44336;
         color: red;
         margin:auto;
         }
         .viewShowHistory:hover {
         background: #f44336;
         color: white;
         margin:auto;
         }
         /* Brown */
         .searchForAnimals {
         border-color: #c68c53;
         color: brown;
         margin:auto;
         }
         .searchForAnimals:hover {
         background: #c68c53;
         color: brown;
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
         color: black;
         margin:auto;
         }
        .GeneratedMarquee {
        font-family:'Comic Sans MS';
        font-size:1em;
        line-height:1.3em;
        padding:1em;
        }
      </style>
   </head>
   <body>
      <br>
      <h1 style="text-align:center;"><marquee class="GeneratedMarquee" direction="left" scrollamount="5" behavior="alternate">Welcome Visitor!</marquee></h1>
      <div class="center">
         <p style="text-align:center;"><img src="zoo.jpg" alt="Zoo" width="80%;"></p>
         <h1 style="text-align:center;">
            <a href="Search_Exhibits.php"><button class="btn searchExhibit">Search Exhibit</button></a>
            <a href="ExhibitHistory.php"><button class="btn viewExhibitHistory">View Exhibit History</button></a>
            <a href="Search_Shows.php"><button class="btn searchShows">Search Shows</button></a>
            <a href="ShowHistory.php"><button class="btn viewShowHistory">View Show History</button></a>
            <a href="Search_Animals.php"><button class="btn searchForAnimals">Search for Animals</button></a>
            <a href="VisitorFunctionality.php?logout='1'"><button class="btn logOut">Log Out</button></a>
         </h1>
      </div>
   </body>
</html>
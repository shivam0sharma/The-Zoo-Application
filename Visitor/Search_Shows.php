<?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
        if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $exhibit = $_POST['select_exhibit'];
            $date = $_POST['date'];

            $sql = "SELECT name, location, showTime 
            FROM ShowTable 
            WHERE name like '%" . $name . "%' 
            AND location like '%" . $exhibit . "%'
            AND showTime like '%" . $date . "%'";
    
            $result = mysqli_query($conn, $sql);
        } else {
            $sql = "SELECT name, location, showTime FROM ShowTable";
            $result = mysqli_query($conn, $sql);
        }
    ?>
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
    <title>Search for Shows</title>

</head>
<body>
    <header>
        <h1 style="text-align: center";>
            Zoo Atlanta Shows
        </h1>
    </header>
    <br>

    <form method="post" action="Search_Shows.php" id="search_params">
        Name: 
        <input type="text" name="name" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        &emsp;Date:
        <input type="date" name="date" id="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : '';?>">
        &emsp;Exhibit:
        <select name="select_exhibit" id="exhibit" value="<?php echo isset($_POST['select_exhibit']) ? $_POST['select_exhibit'] : '';?>">
            <option></option>
            <option value="pacific">Pacific</option>
            <option value="jungle">Jungle</option>
        </select>
        <br>
        <br>
        <input type="submit" name="search" value="Search">
        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>
        <br>
        <br>
    </form>

    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Exhibit</th>
                <th>Date</th>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr class="data">
                <td class="success"><?php echo $row['name']; ?></td>
                <td class="danger"><?php echo $row['location']; ?></td>
                <td class="info"><?php echo $row['showTime']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <br>
</body>
<script>
$("document").ready(function() {
    $("tr.data").click(function() {
        var tableData = $(this).children("td").map(function() {
            return $(this).text();
        }).get();

        var location = "./ShowDetail.php?";
        location = location + "name=" + tableData[0];
        location = location + "&location=" + tableData[1];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});
</script>


</div>
</html>
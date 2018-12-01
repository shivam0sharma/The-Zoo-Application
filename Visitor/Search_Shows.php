<?php
        $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
        $sort;
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        
        if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $exhibit = $_POST['select_exhibit'];
            $date = $_POST['date'];

            
            $sql = "SELECT name, location, showTime 
            FROM ShowTable 
            WHERE name like '%" . $name . "%' 
            AND location like '%" . $exhibit . "%'
            AND showTime like '%" . $date . "%'";
            if(!empty($sort)) {
                $sql = $sql . 'ORDER BY ShowTable.' . $sort;
            }
    
            $result = mysqli_query($conn, $sql);
        } else {
            $sql = "SELECT name, location, showTime FROM ShowTable";
            if(!empty($sort)) {
                $sql = $sql . ' ORDER BY ShowTable.' . $sort;
            }
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
         tr.data {
             cursor:pointer;
         }
         th.sortable {
             cursor: pointer;
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

    <form method="post" action="" id="search_params">
        Name: 
        <input type="text" name="name" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
        &emsp;Date:
        <input type="date" name="date" id="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : '';?>">
        <br>
        &emsp;Exhibit:
        <input list="Exhibits" name="select_exhibit" placeholder="Exhibits" autocomplete="off" value="<?php echo isset($_POST['select_exhibit']) ? $_POST['select_exhibit'] : '';?>">
        <datalist id="Exhibits">    
            <option value="Birds">
            <option value="Jungle">
            <option value="Mountainous">
            <option value="Pacific">
            <option value="Sahara">
        </datalist>
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
                <th class="sortable" onclick="sort('name')">Name</th>
                <th class="sortable" onclick="sort('location')">Exhibit</th>
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
        location = location + "&time=" + tableData[2];
        location = location.replace(/ /g, "_");

        window.location = location;
    });
});
function sort(type) {
    window.location = './Search_Shows.php?sort=' + type;
}

</script>


</div>
</html>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { background-color: rgb(230, 223, 207) }

    </style>
    
    <link rel="stylesheet" type="text/css" href="Search_Shows.css">
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
        <input type="text" name="name" id="name">
        &emsp;Date:
        <input type="date" name="date" id="date">
        &emsp;Exhibit:
        <select name="select_exhibit" id="exhibit">
            <option></option>
            <option value="pacific">Pacific</option>
            <option value="jungle">Jungle</option>
        </select>
        <br>
        <br>
        <input type="submit" name="search" value="Search">
        <a href="VisitorFunctionality.php"> <button type="button"> Go back! </button></a>

    </form>

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

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Exhibit</th>
                <th>Date</th>
            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['showTime']; ?></td>
            </tr>
        <?php } ?>

    </table>


    <br>
    <br>
    <div id="log_button">
        <input type="button" name="log" value="Log Visit" id="log_button">
    </div>
</body>



</html>
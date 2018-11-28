<?php
    session_start();
?>

<?php include('Search_Shows_Server.php'); ?>
<!DOCTYPE html>
<html>
<head>
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
            <option value="pacific">Pacific</option>
        </select>
        <br>
        <br>
        <input type="submit" name="search" value="Search">

    </form>

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
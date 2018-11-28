<?php
    session_start();

    $conn = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');


    $name = "";
    $exhibit = "";
    $date = "";

    if (isset($_POST['search'])) {

    } else {
        $sql = "SELECT name, location, showTime FROM ShowTable;";
        $result = mysqli_query($conn, $query);
    }

?>
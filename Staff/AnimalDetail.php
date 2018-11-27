<?php 

    $name = $_POST['name'];
    $species = $_POST['species'];
    $hostname = "academic-mysql.cc.gatech.edu"; /*This is your hostname */
    $username = "cs4400_group53"; /*The user id you use to log in phpmyadmin */
    $password ="Efhjn754"; /* the password for phpmyadmin */
    $database = "cs4400_group53"; /* the name of the database that you wish to fetch data from */
    $ntwk = mysqli_connect($hostname, $username, $password, $database);
    $query = "SELECT * FROM `Animal` WHERE (name like '%".$name."%' AND species LIKE '%".$species."%')";
    $search_result = mysqli_query($ntwk, $query);
    
    echo json_encode($search_result);

?>
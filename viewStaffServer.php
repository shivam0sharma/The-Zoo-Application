<?php
    session_start();
    // connect to database
    $db = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
    //$db = mysqli_connect('localhost', 'root', 'root', 'cs4400_group53');

    // initialize variables
    $username = "";
    $email = "";
    $sort;

    if (isset($_GET['sort'])) {
         $sort = $_GET['sort'];
    }

    if (isset($_GET['del'])) {
        $username = $_GET['del'];
        mysqli_query($db, "DELETE FROM User WHERE username='$username'");
        $_SESSION['message'] = "Staff deleted!";
        header('location: viewStaff.php');
    }

    if(isset($_POST['search'])) {
        $valueToSearch = $_POST['valueToSearch'];
        // search in all table columns
        // using concat mysql function
        
        $query = "SELECT * FROM User WHERE (userType='Staff') AND (CONCAT(username, email) LIKE '%$valueToSearch%')";
        if (!empty($sort)) {
            $query = $query . ' ORDER BY User.' . $sort;
        }
        $search_result = mysqli_query($db, $query);
    } else {
        $query = "SELECT * FROM User WHERE userType='Staff'";
        if (!empty($sort)) {
            $query = $query . ' ORDER BY User.' . $sort;
        }
        $search_result = mysqli_query($db, $query);
    }
?>
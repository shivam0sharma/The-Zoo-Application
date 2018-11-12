<?php
    session_start();
    $db = mysqli_connect('localhost', 'root', 'root', 'cs4400_group53');

    // initialize variables
    $username = "";
    $email = "";

    if (isset($_GET['del'])) {
        $username = $_GET['del'];
        mysqli_query($db, "DELETE FROM User WHERE username='$username'");
        $_SESSION['message'] = "Visitor deleted!";
        header('location: viewVisitor.php');
    }

    if(isset($_POST['search'])) {
        $valueToSearch = $_POST['valueToSearch'];
        // search in all table columns
        // using concat mysql function
        $query = "SELECT * FROM User WHERE (userType='Visitor') AND (CONCAT(username, email) LIKE '%$valueToSearch%')";
        $search_result = mysqli_query($db, $query);
    } else {
        $query = "SELECT * FROM User WHERE userType='Visitor'";
        $search_result = mysqli_query($db, $query);
    }
?>
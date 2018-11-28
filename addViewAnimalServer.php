<?php
    session_start();
    // connect to database
    $db = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
    //$db = mysqli_connect('localhost', 'root', 'root', 'cs4400_group53');

    // initialize variables
    $name = "";
    $species = "";
    $animalType = "";
    $age = "";
    $age_min = "";
    $age_max = "";
    $exhibit = "";
    $errors = array();

    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $animalType = $_POST['animalType'];
        $age = $_POST['age'];
        $exhibit = $_POST['exhibit'];

        // form validation: ensure that the form is correctly filled
        if (empty($name)) { array_push($errors, "Name is required"); }
        if (empty($species)) { array_push($errors, "Species is required"); }
        if (empty($animalType)) { array_push($errors, "Animal Type is required"); }
        if (empty($age)) { array_push($errors, "Age is required"); }
        if (empty($exhibit)) { array_push($errors, "Exhibit is required"); }

        // add animal if there are no errors in the form
        if (count($errors) == 0) {
            mysqli_query($db, "INSERT INTO Animal (name, species, animalType, age, exhibit) VALUES ('$name', '$species', '$animalType', '$age', '$exhibit')");
            $_SESSION['message'] = "Animal added";
            header('location: addViewAnimal.php');
        }
    }

    if (isset($_GET['del'])) {
        $name = $_GET['del'];
        mysqli_query($db, "DELETE FROM Animal WHERE name='$name'");
        $_SESSION['message'] = "Animal deleted!";
        header('location: addViewAnimal.php');
    }

    if(isset($_POST['search'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $animalType = $_POST['animalType'];
        $age_min = $_POST['age_min'];
        $age_max = $_POST['age_max'];
        $exhibit = $_POST['exhibit'];
        // $valueToSearch = $_POST['valueToSearch'];

        // form validation: ensure that the form is correctly filled
        if (empty($name)) { array_push($errors, "Name is required"); }
        if (empty($species)) { array_push($errors, "Species is required"); }
        if (empty($animalType)) { array_push($errors, "Animal Type is required"); }
        if (empty($age_min)) { array_push($errors, "Min Age is required"); }
        if (empty($age_max)) { array_push($errors, "Max Age is required"); }
        if (empty($exhibit)) { array_push($errors, "Exhibit is required"); }

        // search animal if there are no errors in the form
        if (count($errors) == 0) {
            // search in all table columns
            // using concat mysql function
            $query = "SELECT * FROM Animal WHERE (age>='$age_min') AND (age<='$age_max') AND (exhibit LIKE '%$exhibit%') AND (animalType LIKE '%$animalType%') AND (species LIKE '%$species%') AND (name LIKE '%$name%')";
            $search_result = mysqli_query($db, $query);
        } else {
            $query = "SELECT * FROM Animal";
            $search_result = mysqli_query($db, $query);
        }
    } else {
        $query = "SELECT * FROM Animal";
        $search_result = mysqli_query($db, $query);
    }
?>
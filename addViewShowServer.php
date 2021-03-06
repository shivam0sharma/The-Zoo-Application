<?php
    session_start();
    // connect to database
    $db = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
    //$db = mysqli_connect('localhost', 'root', 'root', 'cs4400_group53');

    // initialize variables
    $name = "";
    $location = "";
    $staff = "";
    $showTime = "";
    $addShowTime;
    $sort;

    $errors = array();

    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $staff = $_POST['staff'];
        $addShowTime = $_POST['addShowTime'];

        // form validation: ensure that the form is correctly filled
        if (empty($name)) { array_push($errors, "Name is required"); }
        if (empty($location)) { array_push($errors, "Exhibit Location is required"); }
        if (empty($staff)) { array_push($errors, "Staff is required"); }
        if (empty($addShowTime)) { array_push($errors, "Show Data and Time is required"); }

        // check case: A staff member cannot host multiple shows at the same time.
        // check case: A staff member cannot host multiple shows at the same time.
        $staff_hosting_time_check_query = "SELECT * FROM ShowTable WHERE host='$staff' AND showTime='$addShowTime' LIMIT 1";
        $staff_hosting_time_check_query_result = mysqli_query($db, $staff_hosting_time_check_query);
        $staff_exists = mysqli_fetch_assoc($staff_hosting_time_check_query_result);
        if ($staff_exists) { // if staff already have a show at that time
            array_push($errors, "Staff cannot host multiple shows at the same time");
        }

        // add show if there are no errors in the form
        if (count($errors) == 0) {
            mysqli_query($db, "INSERT INTO ShowTable (name, showTime, host, location) VALUES ('$name', '$addShowTime', '$staff', '$location')");
            $_SESSION['message'] = "Show added";
            header('location: addViewShow.php');
        }
    }

    if (isset($_GET['del_name'])) {
        $name = $_GET['del_name'];
        $showTime = $_GET['del_time'];
        mysqli_query($db, "DELETE FROM ShowTable WHERE name='$name' AND showTime='$showTime'");
        $_SESSION['message'] = "Show deleted!";
        header('location: addViewShow.php');
    }
    if (isset($_GET['sort'])) {
        $sort = str_replace('_', " ", htmlspecialchars($_GET["sort"]));
    }

    if(isset($_POST['search'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $showTime = $_POST['showTime'];
        // search show if there are no errors in the form
        if (count($errors) == 0) {
            // search in all table columns
            // using concat mysql function
            if (empty($showTime)) {
                $query = "SELECT * FROM ShowTable WHERE (name LIKE '%$name%') AND (location LIKE '%$location%')";
            } else {
                $query = "SELECT * FROM ShowTable WHERE (name LIKE '%$name%') AND (location LIKE '%$location%') AND (showTime like '%$showTime%')";
            }
            if (!empty($sort)) {
                $query = $query . ' ORDER BY ShowTable.' . $sort;
            }
            $search_result = mysqli_query($db, $query);
        } else {
            $query = "SELECT * FROM ShowTable";
            if (!empty($sort)) {
                $query = $query . ' ORDER BY ShowTable.' . $sort;
            }
            $search_result = mysqli_query($db, $query);
        }
    } else {
        $query = "SELECT * FROM ShowTable";
        if (!empty($sort)) {
            $query = $query . ' ORDER BY ShowTable.' . $sort;
        }
        $search_result = mysqli_query($db, $query);

    }
?>
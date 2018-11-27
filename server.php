<?php
	session_start();

	// login/register variable declaration
	$username = "";
	$email    = "";
    $userType = "";
	$errors = array();
	$_SESSION['success'] = "";

	// connect to database
    $db = mysqli_connect('academic-mysql.cc.gatech.edu', 'cs4400_group53', 'Efhjn754', 'cs4400_group53');
    //$db = mysqli_connect('localhost', 'root', 'root', 'cs4400_group53');

	// REGISTER USER
	if (isset($_POST['register_user'])) {
		// receive all input values from the form
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];
        $userType = $_POST['register_user'];

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

        // first check the database to make sure
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM User WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }

		// register user if there are no errors in the form
		if (count($errors) == 0) {
            // insert user into User table
			$password = md5($password_1);//encrypt the password before saving in the database
			$add_user_query = "INSERT INTO User (username, email, password, userType)
					  VALUES('$username', '$email', '$password', '$userType')";
			mysqli_query($db, $add_user_query);

            // insert user into appropirate table: Visitor or Staff
            if ($_POST['register_user'] === "Visitor") {
                // insert to visitor
                $add_visitor_query = "INSERT INTO Visitor (username)
                      VALUES('$username')";
                mysqli_query($db, $add_visitor_query);

                // redirect user to visitor's home page
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: visitor.php');
            } else {
                // insert to staff
                $add_staff_query = "INSERT INTO Staff (username)
                      VALUES('$username')";
                mysqli_query($db, $add_staff_query);
                // redirect user to visitor's home page
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: staff.php');
            }
		}
	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM User WHERE email='$email' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
                // get userType
                $row = $results->fetch_assoc();
                $userType = $row["userType"];

                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";

                // redirect user to designated home page
                if ($userType === "Admin") {
                    // redirect user to admin.php page
                    header('location: admin.php');
                } else if ($userType === "Staff") {
                    // redirect user to staff.php page
                    header('location: staff.php');
                } else {
                    // redirect user to visitor.php page
                    header('location: visitor.php');
                }
			} else {
				array_push($errors, "Wrong email/password combination");
			}
		}
	}

?>
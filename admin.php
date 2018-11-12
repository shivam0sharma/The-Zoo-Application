<!-- need to fix so that not any user can login and then change the url to this page and access it -->
<?php
    session_start();

    if (!isset($_SESSION['email'])) {
    // redirect user to login.php page
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
    // redirect user to login.php page
        session_destroy();
        unset($_SESSION['email']);
        header("location: login.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Admin's Home Page</h2>
    </div>
    <div class="content">

        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- logged in user information -->
        <?php  if (isset($_SESSION['email'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['email']; ?></strong></p>
        <?php endif ?>
        &ensp;
        <div>
            <div>

                &ensp;&ensp;&ensp;&ensp;&ensp;<a href="viewVisitor.php"><button class="btn">View Visitors</button></a>
                &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<a href="viewStaff.php"><button class="btn">View Staff</button></a>
            </div>
            <br>
            <div>
                &ensp;&ensp;&ensp;&ensp;&ensp;<button class="btn">View Shows</button>
                &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<a href="addAnimal.php"><button class="btn">View Animal</button></a>
            </div>
            <br>
            <div>
                &ensp;&ensp;&ensp;&ensp;&ensp;<button class="btn">Add Show</button>
                &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<a href="admin.php?logout='1'"><button class="btn">Log Out</button></a>
            </div>
        </div>
    </div>
</body>
</html>

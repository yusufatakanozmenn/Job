<?php
require_once '../libs/ayar.php';
require_once '../libs/vars.php';

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            setcookie("auth[username]", $row["username"], time() + (60 * 60), "/", "", true, true);
            setcookie("auth[role]", $row["role"], time() + (60 * 60), "/", "", true, true);

            // Check the user's role and redirect accordingly
            if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'IK') {
                header('Location: index.php');
            } else if ($_SESSION['role'] == 'employee') {
                header('Location: ../src/index.php');
            }
            exit;
        } else {
            $login_error = "Incorrect username or password";
        }
    } else {
        $login_error = "Incorrect username or password";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard Login Page</title>
    <!-- loader-->
    <link href="./assets/css/pace.min.css" rel="stylesheet" />
    <script src="./assets/js/pace.min.js"></script>
    <!--favicon-->
    <link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="./assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="./assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Custom Style-->
    <link href="./assets/css/app-style.css" rel="stylesheet" />
</head>

<body class="bg-theme bg-theme1">

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">

        <div class="loader-wrapper">
            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="card card-authentication1 mx-auto my-5">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="./assets/images/logo-icon.png" alt="logo icon">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Sign In</div>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" id="username" name="username" class="form-control input-shadow" placeholder="Enter Username" required>
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password" id="password" name="password" class="form-control input-shadow" placeholder="Enter Password" required>
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (isset($login_error)) {
                            echo "<div class='alert alert-danger text-center'>{$login_error}</div>";
                        }
                        ?>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <div class="icheck-material-white">
                                    <input type="checkbox" id="user-checkbox" checked="" />
                                    <label for="user-checkbox">Remember me</label>
                                </div>
                            </div>
                            <div class="form-group col-6 text-right">
                                <a href="reset.php">Reset Password</a>
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-light btn-block">Sign In</button>


                        <!-- <div class="form-row mt-4">
                            <div class="form-group mb-0 col-6">
                                <button type="button" class="btn btn-light btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
                            </div>
                            <div class="form-group mb-0 col-6 text-right">
                                <button type="button" class="btn btn-light btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
                            </div>
                        </div> -->

                    </form>
                </div>
            </div>
            <div class="card-footer text-center py-3">
                <p class="text-warning mb-0">Do not have an account? <a href="register.php"> Sign Up here</a></p>
            </div>
        </div>



    </div>
    <!--wrapper-->

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

    <!-- sidebar-menu js -->
    <script src="./assets/js/sidebar-menu.js"></script>

    <!-- Custom scripts -->
    <script src="./assets/js/app-script.js"></script>

</body>

</html>
<?php
require_once '../libs/ayar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
            $_SESSION['lang'] = $row['lang'];


            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;


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
    <?php include 'include/head.php'; ?>
    <title>Login</title>
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const usernameInput = document.getElementById('username');
        const rememberMeCheckbox = document.getElementById('remember-me');

        // Check if the cookie exists and set the username
        if (document.cookie.includes('username=')) {
            const username = document.cookie.split('; ').find(row => row.startsWith('username=')).split('=')[1];
            usernameInput.value = decodeURIComponent(username);
            rememberMeCheckbox.checked = true;
        }

        // Set the cookie when the form is submitted
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            if (rememberMeCheckbox.checked) {
                const username = usernameInput.value;
                document.cookie = "username=" + encodeURIComponent(username) + "; path=/; max-age=" +
                    60 * 60 * 24 * 30; // 30 days
            } else {
                document.cookie = "username=; path=/; max-age=0"; // Delete cookie
            }
        });
    });
    </script>
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
                        <img src="./assets/images/logo_ysf.png" width="100" height="100" alt="logo icon">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Sign In</div>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" id="username" name="username" class="form-control input-shadow"
                                    placeholder="Enter Username" required>
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password" id="password" name="password" class="form-control input-shadow"
                                    placeholder="Enter Password" required>
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
                                    <input type="checkbox" id="remember-me" name="remember-me" />
                                    <label for="remember-me">Remember me</label>
                                </div>
                            </div>
                            <div class="form-group col-6 text-right">
                                <div class="icheck-material-white">
                                    <a href="reset.php">Reset Password</a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-light btn-block">Sign In</button>
                        <!-- <div class="form-row mt-4">
                            <div class="form-group mb-0 col-4 text-right">
                                <button type="button" class="btn btn-light btn-block"><i class="fa fa-google"></i>
                                    Google</button>
                            </div>
                        </div> -->
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
    <!--Start footer-->
    <footer class="footer">
        <div class="container">
            <div class="text-center">© 2024 Yusuf Atakan Özmen. Tüm Hakları Saklıdır.</div>
        </div>
    </footer>
    <!--End footer-->

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
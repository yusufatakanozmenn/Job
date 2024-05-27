<?php

require "../libs/ayar.php";

$username = $email = $password = $role = "";
$username_err = $email_err = $password_err = $role_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    if (empty($username)) {
        $username_err = "Please enter a username.";
    }

    if (empty($email)) {
        $email_err = "Please enter a email.";
    }

    if (empty($password)) {
        $password_err = "Please enter a password.";
    }

    if (empty($role)) {
        $role_err = "Please enter a role.";
    }

    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($role_err)) {

        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('ssss', $username, $email, $password, $role);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Kayıt başarısız: " . $connection->error;
            }
        }
    }
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
    <title>İşe Alım Register</title>
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
    <!-- Start wrapper-->
    <div id="wrapper">
        <div class="container my-3">

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <form action="register.php" method="POST" novalidate>

                                <div class="mb-3">
                                    <label for="username" class="form-label">username</label>
                                    <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : '' ?>" value="<?php echo $username; ?>" name="username" id="username">
                                    <span class="invalid-feedback"><?php echo $username_err ?></span>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">email</label>
                                    <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : '' ?>" value="<?php echo $email; ?>" name="email" id="email">
                                    <span class="invalid-feedback"><?php echo $email_err ?></span>

                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">password</label>
                                    <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '' ?>" value="<?php echo $password; ?>" name="password" id="password">
                                    <span class="invalid-feedback"><?php echo $password_err ?></span>

                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">role</label>
                                    <input type="text" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : '' ?>" value="<?php echo $role; ?>" name="role" id="role">
                                    <span class="invalid-feedback"><?php echo $role_err ?></span>
                                </div>

                                <input type="submit" name="register" value="Submit" class="btn btn-primary">

                            </form>
                        </div>
                    </div>

                </div>

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
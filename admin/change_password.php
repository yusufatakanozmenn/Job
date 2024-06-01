<?php
include '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    header('Location: user_list.php');
    exit;
}

if (isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Şifreyi güncelle
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: user_list.php?status=password_changed');
        } else {
            $password_error = "Error changing password";
        }

        mysqli_stmt_close($stmt);
    } else {
        $password_error = "Passwords do not match";
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
    <title>Change Password</title>
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- simplebar CSS-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="assets/css/app-style.css" rel="stylesheet" />

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
        <!--Start sidebar-wrapper-->
        <?php include 'include/sidebar.php'; ?>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <?php include 'include/header.php'; ?>
        <!--End topbar header-->


        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="card-title">Change Password</h2>
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($password_error)): ?>
                                <div class="alert alert-danger"><?php echo $password_error; ?></div>
                                <?php endif; ?>
                                <form action="change_password.php?id=<?php echo $user_id; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control" required>
                                    </div>
                                    <button type="submit" name="change_password" class="btn btn-primary">Change
                                        Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        <?php include 'include/footer.php'; ?>
        <!--End footer-->

    </div>
    <!--End wrapper-->


    <!-- Bootstrap core JavaScript-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

    <!-- simplebar js -->
    <script src="./assets/plugins/simplebar/js/simplebar.js"></script>
    <!-- sidebar-menu js -->
    <script src="./assets/js/sidebar-menu.js"></script>

    <!-- Custom scripts -->
    <script src="./assets/js/app-script.js"></script>

</body>

</html>
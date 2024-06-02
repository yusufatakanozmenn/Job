<?php
include '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

// Kullanıcıları veritabanından çek
$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);

if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    die("Error: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['user_list']; ?></title>

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
                        <h2 class="card-title"><?php echo $lang['user_list']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($_GET['status'])): ?>
                                <div class="alert alert-success">
                                    <?php
                                        if ($_GET['status'] === 'deleted') echo "User deleted successfully";
                                        if ($_GET['status'] === 'updated') echo "User updated successfully";
                                        if ($_GET['status'] === 'password_changed') echo "Password changed successfully";
                                        if ($_GET['status'] === 'notfound') echo "User not found";
                                        if ($_GET['status'] === 'error') echo "An error occurred";
                                        ?>
                                </div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"><?php echo $lang['username']; ?></th>
                                                <th scope="col"><?php echo $lang['email']; ?></th>
                                                <th scope="col"><?php echo $lang['role']; ?></th>
                                                <th scope="col"><?php echo $lang['create_at']; ?></th>
                                                <th scope="col"><?php echo $lang['actions']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                            <tr>
                                                <th scope="row"><?php echo $user['id']; ?></th>
                                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                                <td><?php echo htmlspecialchars($user['date']); ?></td>
                                                <td>
                                                    <a href="edit_user.php?id=<?php echo $user['id']; ?>"
                                                        class="btn btn-primary btn-sm"><?php echo $lang['edit']; ?></a>
                                                    <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                    <a href="change_password.php?id=<?php echo $user['id']; ?>"
                                                        class="btn btn-warning btn-sm"><?php echo $lang['change_password']; ?></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overlay toggle-menu"></div>

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
<?php
include '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Kullanıcı bilgilerini veritabanından çek
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header('Location: user_list.php?status=notfound');
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    header('Location: user_list.php');
    exit;
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Kullanıcı bilgilerini güncelle
    $query = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $username, $email, $role, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: user_list.php?status=updated');
    } else {
        $update_error = "Error updating user";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['edit_profile']; ?></title>

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
                        <h2 class="card-title"><?php echo $lang['edit_profile']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($update_error)): ?>
                                <div class="alert alert-danger"><?php echo $update_error; ?></div>
                                <?php endif; ?>
                                <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="username"><?php echo $lang['username']; ?></label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><?php echo $lang['email']; ?></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="admin"
                                                <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>
                                                <?php echo $lang['admin']; ?>
                                            </option>
                                            <option value="IK" <?php echo $user['role'] === 'IK' ? 'selected' : ''; ?>>
                                                <?php echo $lang['IK']; ?></option>
                                            <option value="employee"
                                                <?php echo $user['role'] === 'employee' ? 'selected' : ''; ?>>
                                                <?php echo $lang['employee']; ?>
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" name="update"
                                        class="btn btn-primary"><?php echo $lang['update']; ?></button>
                                    <button type="button" onclick="history.back();"
                                        class="btn btn-secondary"><?php echo $lang['cancel']; ?></button>
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
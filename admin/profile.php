<?php
require_once '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

// Oturumdaki kullanıcı adını al
$username = $_SESSION['username'];

// Kullanıcı bilgilerini veritabanından çekme
$stmt = $connection->prepare("SELECT username, email , role FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// contact_info
$stmt2 = $connection->prepare("SELECT * FROM contact_info");
$stmt2->execute();
$result2 = $stmt2->get_result();
$contact = $result2->fetch_assoc();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Kullanıcı bulunamadı.";
    exit;
}

$stmt->close();

$updateMessage = '';

// Kullanıcı bilgilerini güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update_stmt = $connection->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE username = ?");
    $update_stmt->bind_param('ssss', $new_username, $new_email, $new_password, $username);

    if ($update_stmt->execute()) {
        $updateMessage = "Bilgiler başarıyla güncellendi.";
        // Oturumdaki kullanıcı adını güncelle
        $_SESSION['username'] = $new_username;
    } else {
        $updateMessage = "Güncelleme sırasında hata oluştu.";
    }

    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['profile']; ?></title>
    <script type="text/javascript">
    <?php if (!empty($updateMessage)) { ?>
    alert("<?php echo $updateMessage; ?>");
    <?php } ?>
    </script>
</head>

<body class="bg-theme bg-theme1">

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

                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="assets/images/admin-logo.jpg" alt="Card image cap">
                            </div>
                            <div class="card-body pt-5">
                                <img src="assets/images/admin-logo.jpg" alt="profile-image" class="profile">
                                <h4 class="card-title"><i class="fa fa-user"></i>
                                    <?php echo $_COOKIE["auth"]["username"]; ?> ||
                                    <?php echo $_COOKIE["auth"]["role"]; ?></h4>
                                <div class="icon-block">
                                    <a href="<?php echo $contact['linkedin_link'] ?>" target="_blank"> <i
                                            class="fa fa-linkedin bg-linkedin text-white"></i></a>
                                    <a href="mailto:<?php echo $contact['email_address'] ?>" target="_blank"> <i
                                            class="fa fa-envelope bg-email text-white"></i></a>
                                    <a href="<?php echo $contact['facebook_link'] ?>" target="_blank"> <i
                                            class="fa fa-facebook bg-facebook text-white"></i></a>
                                    <a href="<?php echo $contact['twitter_link'] ?>" target="_blank"> <i
                                            class="fa fa-twitter bg-twitter text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                    <li class="nav-item">
                                        <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                                            class="nav-link active"><i class="icon-user"></i> <span
                                                class="hidden-xs"><?php echo $lang['profile']; ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void();" data-target="#edit" data-toggle="pill"
                                            class="nav-link"><i class="icon-note"></i> <span
                                                class="hidden-xs"><?php echo $lang['edit']; ?></span></a>
                                    </li>
                                </ul>
                                <div class="tab-content p-3">
                                    <div class="tab-pane active" id="profile">
                                        <h5 class="mb-3"><?php echo $lang['user_profile']; ?></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5><?php echo $lang['username']; ?></h5>
                                                <p>
                                                    <?php echo htmlspecialchars($user['username']); ?>
                                                </p>
                                                <h5><?php echo $lang['email']; ?></h5>
                                                <p>
                                                    <?php echo htmlspecialchars($user['email']); ?>
                                                </p>
                                                <h5><?php echo $lang['phone_number']; ?></h5>
                                                <p>
                                                    <?php echo htmlspecialchars($contact['phone_number']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <!--/row-->
                                    </div>
                                    <div class="tab-pane" id="edit">
                                        <h5 class="mb-3"><?php echo $lang['edit_profile']; ?></h5>
                                        <form method="post" action="">
                                            <div class="form-group">
                                                <label for="username"><?php echo $lang['username']; ?></label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email"><?php echo $lang['email']; ?></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password"><?php echo $lang['password']; ?></label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['save_changes']; ?></button>
                                        </form>
                                    </div>
                                    <!-- Rest of the code... -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--start overlay-->
                <div class="overlay toggle-menu"></div>
                <!--end overlay-->

            </div>
            <!-- End container-fluid-->
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
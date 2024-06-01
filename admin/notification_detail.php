<?php
require_once '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

if (isset($_GET['id'])) {
    $notification_id = intval($_GET['id']);

    // Bildirimi okundu olarak işaretleme
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $notification_id);
    mysqli_stmt_execute($stmt);
    $stmt->close();

    // Bildirim detaylarını çekme
    $query = "SELECT * FROM notifications WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $notification_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $notification = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    header('Location: index.php');
    exit;
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
    <title>Notification Detail</title>
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/sidebar-menu.css" rel="stylesheet" />
    <link href="assets/css/app-style.css" rel="stylesheet" />
</head>

<body class="bg-theme bg-theme1">
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <?php include 'include/header.php'; ?>

        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="card-title">Notification Detail</h2>
                        <div class="card">
                            <div class="card-body">
                                <?php if ($notification): ?>
                                <p><?php echo $notification['message']; ?></p>
                                <?php else: ?>
                                <p>Notification not found.</p>
                                <?php endif; ?>
                                <a href="index.php">Back to notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <?php include 'include/footer.php'; ?>
    </div>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/app-script.js"></script>
</body>

</html>
<?php
include '../libs/vars.php';
include 'admin_check.php';
// Include database connection and any other necessary files
require_once '../libs/ayar.php';

// Query to select comments from the database
$sql = "SELECT * FROM comments";
$result = $connection->query($sql);

// Check if there are any comments
if ($result->num_rows > 0) {
    // Initialize an empty array to store comments
    $comments = [];

    // Fetch comments from the result set
    while ($row = $result->fetch_assoc()) {
        // Add each comment to the comments array
        $comments[] = $row;
    }
} else {
    // No comments found
    echo "No comments available.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['comments']; ?></title>

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
                        <h2 class="card-title"><?php echo $lang['comments']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"><?php echo $lang['name']; ?></th>
                                                <th scope="col"><?php echo $lang['blog_id']; ?></th>
                                                <th scope="col"><?php echo $lang['email']; ?></th>
                                                <th scope="col"><?php echo $lang['subject']; ?></th>
                                                <th scope="col"><?php echo $lang['comment']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comments as $comment): ?>
                                            <tr>
                                                <th scope="row"><?php echo $comment['id']; ?></th>
                                                <td><?php echo $comment['author']; ?></td>
                                                <td><?php echo $comment['blog_id']; ?></td>
                                                <td><?php echo $comment['email']; ?></td>
                                                <td><?php echo $comment['subject']; ?></td>
                                                <td><?php echo $comment['comment']; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Row-->
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
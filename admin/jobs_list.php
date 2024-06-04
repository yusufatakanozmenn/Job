<?php
include '../libs/vars.php';
include 'admin_check.php';
include '../libs/database.php';

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanından iş listesini çek
    $sql = "SELECT * FROM jobs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>





<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['job_list']; ?></title>

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
                        <h2 class="card-title"><?php echo $lang['job_list']; ?></h2>
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="create_job.php"
                                        class="btn btn-primary"><?php echo $lang['create_job']; ?></a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"><?php echo $lang['title']; ?></th>
                                                <th scope="col"><?php echo $lang['description']; ?></th>
                                                <th scope="col"><?php echo $lang['sector']; ?></th>
                                                <th scope="col"><?php echo $lang['city']; ?></th>
                                                <th scope="col"><?php echo $lang['actions']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($jobs as $job): ?>
                                            <tr>
                                                <th scope="row"><?php echo $job['id']; ?></th>
                                                <td><?php echo $job['title']; ?></td>
                                                <td><?php echo substr($job['description'], 0, 70) . (strlen($job['description']) > 50 ? '...' : ''); ?>
                                                </td>
                                                <td><?php echo $job['sector']; ?></td>
                                                <td><?php echo $job['city']; ?></td>
                                                <td>
                                                    <a href="edit_job.php?id=<?php echo $job['id']; ?>"
                                                        class="btn btn-primary"><?php echo $lang['edit']; ?></a>
                                                    <a href="delete_job.php?id=<?php echo $job['id']; ?>"
                                                        class="btn btn-danger"><?php echo $lang['delete']; ?></a>
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
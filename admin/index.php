<?php
include '../libs/vars.php';
include 'admin_check.php';
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanından iş listesini çek
    $sql = "SELECT * FROM jobs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // İş başvurularının sayısını çek
    $stmt = $conn->prepare("SELECT COUNT(*) as total_applications FROM job_applications");
    $stmt->execute();
    $total_applications = $stmt->fetch(PDO::FETCH_ASSOC)['total_applications'];

    // Blogların sayısını çek
    $stmt = $conn->prepare("SELECT COUNT(*) as total_blogs FROM blog_posts");
    $stmt->execute();
    $total_blogs = $stmt->fetch(PDO::FETCH_ASSOC)['total_blogs'];

    // Yorumların sayısını çek
    $stmt = $conn->prepare("SELECT COUNT(*) as total_comments FROM comments");
    $stmt->execute();
    $total_comments = $stmt->fetch(PDO::FETCH_ASSOC)['total_comments'];

    // Contact Message sayısını çek
    $stmt = $conn->prepare("SELECT COUNT(*) as total_messages FROM contact_messages");
    $stmt->execute();
    $total_messages = $stmt->fetch(PDO::FETCH_ASSOC)['total_messages'];

    // En yüksek değeri bulmak için toplamları al
    $max_value = max($total_applications, $total_blogs, $total_comments, $total_messages);

    // Progress bar genişliğini hesapla
    $applications_width = ($total_applications / $max_value) * 100;
    $blogs_width = ($total_blogs / $max_value) * 100;
    $comments_width = ($total_comments / $max_value) * 100;
    $messages_width = ($total_messages / $max_value) * 100;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/head.php'; ?>
    <title>Dashboard</title>
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
                <!--Start Dashboard Content-->
                <div class="card mt-3">
                    <div class="card-content">
                        <div class="row row-group m-0">
                            <div class="col-12 col-lg-6 col-xl-3 border-light">
                                <div class="card-body">
                                    <h5 class="text-white mb-0">
                                        <?php echo $total_applications; ?>
                                        <span class="float-right"><i class="fa fa-briefcase"></i></span>
                                    </h5>
                                    <div class="progress my-3" style="height: 3px">
                                        <div class="progress-bar" style="width: <?php echo $applications_width; ?>%">
                                        </div>
                                    </div>
                                    <p class="mb-0 text-white small-font">
                                        Total Applications
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-3 border-light">
                                <div class="card-body">
                                    <h5 class="text-white mb-0">
                                        <?php echo $total_blogs; ?>
                                        <span class="float-right"><i class="fa fa-pencil"></i></span>
                                    </h5>
                                    <div class="progress my-3" style="height: 3px">
                                        <div class="progress-bar" style="width: <?php echo $blogs_width; ?>%"></div>
                                    </div>
                                    <p class="mb-0 text-white small-font">
                                        Total Blogs
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-3 border-light">
                                <div class="card-body">
                                    <h5 class="text-white mb-0">
                                        <?php echo $total_comments; ?>
                                        <span class="float-right"><i class="fa fa-comments"></i></span>
                                    </h5>
                                    <div class="progress my-3" style="height: 3px">
                                        <div class="progress-bar" style="width: <?php echo $comments_width; ?>%"></div>
                                    </div>
                                    <p class="mb-0 text-white small-font">
                                        Total Comments
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-3 border-light">
                                <div class="card-body">
                                    <h5 class="text-white mb-0">
                                        <?php echo $total_messages; ?>
                                        <span class="float-right"><i class="fa fa-envelope"></i></span>
                                    </h5>
                                    <div class="progress my-3" style="height: 3px">
                                        <div class="progress-bar" style="width: <?php echo $messages_width; ?>%"></div>
                                    </div>
                                    <p class="mb-0 text-white small-font">
                                        Total Messages
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Dashboard Content-->

                <!--Start Job List Content-->
                <div class="clearfix"></div>


                <div class="col-lg-12">
                    <h2 class="card-title">Job List</h2>
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-end mb-3">
                                <a href="create_job.php" class="btn btn-primary">Create Job</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Sector</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Actions</th>
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
                                                    class="btn btn-primary">Edit</a>
                                                <a href="delete_job.php?id=<?php echo $job['id']; ?>"
                                                    class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--End Row-->

                        <!--start overlay-->
                        <div class="overlay toggle-menu"></div>
                        <!--end overlay-->

                    </div>
                    <!-- End container-fluid-->

                </div>
                <!--End Job List Content-->
            </div>
            <!-- End container-fluid-->
        </div>
        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i>
        </a>
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
    <!-- loader scripts -->
    <script src="./assets/js/jquery.loading-indicator.js"></script>
    <!-- Custom scripts -->
    <script src="./assets/js/app-script.js"></script>
    <!-- Chart js -->

    <script src="./assets/plugins/Chart.js/Chart.min.js"></script>

    <!-- Index js -->
    <script src="./assets/js/index.js"></script>
</body>

</html>
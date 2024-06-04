<?php
include '../libs/vars.php';
include 'admin_check.php';
include '../libs/database.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If there is a 'mark_as_read' parameter in the URL, update the read_status of the corresponding application
    if (isset($_GET['mark_as_read'])) {
        $stmt = $conn->prepare("UPDATE job_applications SET read_status = 'read' WHERE id = ?");
        $stmt->execute([$_GET['mark_as_read']]);
    }
    
    // If there is a 'delete' parameter in the URL, delete the corresponding application
    if (isset($_GET['delete'])) {
        $stmt = $conn->prepare("DELETE FROM job_applications WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
    }


    $stmt = $conn->prepare("SELECT * FROM job_applications ORDER BY application_date DESC");
    $stmt->execute();
    $job_applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['job_applications']; ?></title>
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
                        <h2 class="card-title"><?php echo $lang['job_applications']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col"><?php echo $lang['job_id']; ?></th>
                                                <th scope="col"><?php echo $lang['name']; ?></th>
                                                <th scope="col"><?php echo $lang['email']; ?></th>
                                                <th scope="col"><?php echo $lang['phone_number']; ?></th>
                                                <th scope="col"><?php echo $lang['cover_letter']; ?></th>
                                                <th scope="col"><?php echo $lang['resume']; ?></th>
                                                <th scope="col"><?php echo $lang['app_date']; ?></th>
                                                <th scope="col"><?php echo $lang['read_status']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($job_applications as $job_application): ?>
                                            <tr>
                                                <td><?php echo $job_application['id']; ?></td>
                                                <td><?php echo $job_application['job_id']; ?>
                                                </td>
                                                <td><?php echo $job_application['name']; ?></td>
                                                <td><?php echo $job_application['email']; ?></td>
                                                <td><?php echo $job_application['phone']; ?></td>
                                                <td><?php echo $job_application['cover_letter']; ?></td>
                                                <td><a href="../admin/uploads/<?php echo $job_application['resume']; ?>"
                                                        target="_blank"><?php echo $lang['view_resume']; ?></a></td>
                                                <td><?php echo $job_application['application_date']; ?></td>
                                                <td>
                                                    <?php if ($job_application['read_status'] == 'unread'): ?>
                                                    <a href="jobs_apply_list.php?mark_as_read=<?php echo $job_application['id']; ?>"
                                                        class="btn btn-primary"><?php echo $lang['mark_as_read']; ?></a>
                                                    <?php else: ?>
                                                    <span class="btn btn-success"><?php echo $lang['read']; ?></span>
                                                    <?php endif; ?>
                                                    <a href="jobs_apply_list.php?delete=<?php echo $job_application['id']; ?>"
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
                <div class="overlay toggle-menu"></div>
            </div>
        </div>

        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

        <!--Start footer-->
        <?php include 'include/footer.php'; ?>
        <!--End footer-->
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/app-script.js"></script>
</body>

</html>
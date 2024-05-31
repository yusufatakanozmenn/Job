<?php
include '../libs/vars.php';
include 'admin_check.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If there is a 'mark_as_read' parameter in the URL, update the read_status of the corresponding application
    if (isset($_GET['mark_as_read'])) {
        $stmt = $conn->prepare("UPDATE job_applications SET read_status = 'read' WHERE id = ?");
        $stmt->execute([$_GET['mark_as_read']]);
    }

    $stmt = $conn->prepare("SELECT * FROM job_applications ORDER BY application_date DESC");
    $stmt->execute();
    $job_applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
    <title>Job Applications</title>
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
                        <h2 class="card-title">Job Applications</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Job ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Cover Letter</th>
                                                <th scope="col">Resume</th>
                                                <th scope="col">Application Date</th>
                                                <th scope="col">Read Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($job_applications as $job_application): ?>
                                            <tr>
                                                <td><?php echo $job_application['id']; ?></td>
                                                <td><a
                                                        href="../src/job_details.php?id=<?php echo $job_application['job_id']; ?>"><?php echo $job_application['job_id']; ?></a>
                                                </td>
                                                <td><?php echo $job_application['name']; ?></td>
                                                <td><?php echo $job_application['email']; ?></td>
                                                <td><?php echo $job_application['phone']; ?></td>
                                                <td><?php echo $job_application['cover_letter']; ?></td>
                                                <td><a href="../uploads/<?php echo $job_application['resume']; ?>"
                                                        target="_blank">View Resume</a></td>
                                                <td><?php echo $job_application['application_date']; ?></td>
                                                <td>
                                                    <?php if ($job_application['read_status'] == 'unread'): ?>
                                                    <a href="jobs_apply_list.php?mark_as_read=<?php echo $job_application['id']; ?>"
                                                        class="btn btn-primary">Mark as Read</a>
                                                    <?php else: ?>
                                                    Read
                                                    <?php endif; ?>
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

        <footer class="footer">
            <div class="container">
                <div class="text-center">Copyright © 2024 Yusuf Atakan Özmen</div>
            </div>
        </footer>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/app-script.js"></script>
</body>

</html>
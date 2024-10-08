<?php
// Veritabanı bağlantısı ve gerekli dosyaların dahil edilmesi
require_once '../libs/ayar.php';
include '../libs/language.php';

// İş ilanlarını ve başvuru sayılarını veritabanından çekme
$search_query = "";
if (isset($_POST['type'])) {
    $type = $_POST['type'];
    $stmt = $connection->prepare("
        SELECT jobs.*, COUNT(job_applications.id) AS application_count 
        FROM jobs 
        LEFT JOIN job_applications ON jobs.id = job_applications.job_id 
        WHERE jobs.type = ?
        GROUP BY jobs.id
    ");
    $stmt->bind_param("s", $type);
} else if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
    $search = '%' . $search_query . '%';
    $stmt = $connection->prepare("
        SELECT jobs.*, COUNT(job_applications.id) AS application_count 
        FROM jobs 
        LEFT JOIN job_applications ON jobs.id = job_applications.job_id 
        WHERE jobs.title LIKE ?
        GROUP BY jobs.id
    ");
    $stmt->bind_param("s", $search);
} else {
    $stmt = $connection->prepare("
        SELECT jobs.*, COUNT(job_applications.id) AS application_count 
        FROM jobs 
        LEFT JOIN job_applications ON jobs.id = job_applications.job_id 
        GROUP BY jobs.id
    ");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include '../includes/_header.php'; ?>
    <title><?php echo $lang['jobs']; ?></title>
</head>

<body>
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <?php include '../includes/_navbar.php'; ?>
    </header>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4><?php echo $lang['jobs']; ?></h4>
                            <h2><?php echo $lang['featured_jobs']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Banner Ends Here -->

    <!-- Search Form -->
    <section class="search-form">
        <div class="container">
            <form action="jobs.php" method="POST">
                <div class="row">
                    <div class="col-md-10 col-xs-12">
                        <input type="text" name="search" class="form-control"
                            placeholder="<?php echo $lang['search_jobs']; ?>"
                            value="<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo $lang['search']; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="all-blog-posts">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="row">
                            <?php
                            // İş ilanlarını döngü ile görüntüleme
                            while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-sm-4">
                                <div class="blog-post1">
                                    <div class="blog-thumb">
                                        <!-- İş ilanı resmi buraya gelecek -->
                                        <img src="../admin/<?php echo htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8'); ?>"
                                            alt="">
                                    </div>
                                    <div class="down-content">
                                        <span><?php echo htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <a href="job-details.php?id=<?php echo $row['id']; ?>">
                                            <h4><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                        </a>
                                        <p><?php echo $row['description']; ?></p>
                                        <div class="post-options">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="post-tags">
                                                        <li><i class="fa fa-bullseye"></i></li>
                                                        <li><a
                                                                href="job-details.php?id=<?php echo $row['id']; ?>"><?php echo $lang['view_job']; ?></a>
                                                        </li>
                                                        <li><i class="fa fa-users"></i>
                                                            <?php echo $row['application_count']; ?>
                                                            <?php echo $lang['applications']; ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/_footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/owl.js"></script>
    <script src="../assets/js/slick.js"></script>
    <script src="../assets/js/isotope.js"></script>
    <script src="../assets/js/accordions.js"></script>

    <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) { //declaring the array outside of the
        if (!cleared[t.id]) { // function makes it static and global
            cleared[t.id] = 1; // you could use true and false, but that's more typing
            t.value = ''; // with more chance of typos
            t.style.color = '#fff';
        }
    }
    </script>

</body>

</html>
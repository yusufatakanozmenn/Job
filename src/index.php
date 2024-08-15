<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
include '../libs/database.php';

include '../libs/language.php';
try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanından verileri çek
    $sql = "SELECT * FROM jobs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Veritabanından en son eklenen iş ilanlarını çek
    $sql_latest = "SELECT * FROM jobs ORDER BY date DESC LIMIT 6";
    $stmt_latest = $conn->prepare($sql_latest);
    $stmt_latest->execute();
    $latest_jobs = $stmt_latest->fetchAll(PDO::FETCH_ASSOC);

     // Veritabanından blog gönderilerini çek
     $stmt = $conn->prepare("SELECT * FROM blog_posts");
     $stmt->execute();
     $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>


<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include '../includes/_header.php'; ?>
    <title>Job Pursuit</title>

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <?php include '../includes/_navbar.php'; ?>
    </header>

    <!-- Banner Starts Here -->
    <div class="main-banner header-text">
        <div class="container-fluid">
            <div class="owl-banner owl-carousel">
                <?php if ($latest_jobs) : ?>
                <?php foreach ($latest_jobs as $job) : ?>
                <div class="item">
                    <img src="<?php echo '../admin/' . $job['img']; ?>" alt="" />
                    <div class="item-content">
                        <div class="main-content">
                            <div class="meta-category">
                                <span><?php echo htmlspecialchars($job['sector']); ?></span>
                            </div>

                            <a href="job-details.php?id=<?php echo $job['id']; ?>">
                                <h4><?php echo htmlspecialchars($job['title']); ?></h4>
                            </a>

                            <ul class="post-info">
                                <li><i class="fa fa-briefcase"></i> <?php echo htmlspecialchars($job['description']); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <p><?php echo $lang['no_jobs']; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Banner Ends Here -->



    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4><?php echo $lang['about_us']; ?></h4>
                            <a href="about.php">
                                <h2><?php echo $lang['more_about_us']; ?></h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Banner Ends Here -->

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="all-blog-posts">
                <h2 class="text-center"><?php echo $lang['featured_jobs']; ?></h2>
                <br>
                <div class="row">
                    <?php if ($jobs) : ?>
                    <?php foreach ($jobs as $job) : ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="<?php echo '../admin/' . $job['img']; ?>" alt="">
                            </div>
                            <div class="down-content">
                                <span><?php echo htmlspecialchars($job['sector']); ?></span>
                                <a href="job-details.php?id=<?php echo $job['id']; ?>">
                                    <h4><?php echo htmlspecialchars($job['title']); ?></h4>
                                </a>
                                <p><?php echo htmlspecialchars($job['description']); ?></p>
                                <div class="post-options">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="post-tags">
                                                <li><i class="fa fa-bullseye"></i></li>
                                                <li><a
                                                        href="job-details.php?id=<?php echo $job['id']; ?>"><?php echo $lang['view_job']; ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <p><?php echo $lang['no_jobs']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4><?php echo $lang['for_more_info']; ?></h4>
                            </div>
                            <div class="col-lg-4">
                                <div class="main-button">
                                    <a href="contact.php"><?php echo $lang['contact_us']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="all-blog-posts">
                <h2 class="text-center"><?php echo $lang['blog']; ?></h2>
                <br>
                <div class="row">
                    <?php foreach ($posts as $post): ?>

                    <div class="col-md-4 col-sm-6">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="<?php echo '../admin/' . $post['img']; ?>" alt="">
                            </div>
                            <div class="down-content">
                                <a href="blog-details.php?id=<?php echo $post['id']; ?>">
                                    <h3><?php echo $post['title']; ?></h3>
                                </a>
                                <p><?php echo htmlspecialchars(substr($post['content'], 0, 70)) . (strlen($post['content']) > 70 ? '...' : ''); ?>
                                </p>
                                </p>
                                <ul class="post-info">
                                    <li><?php echo $post['author_id']; ?></li>
                                    <li><?php echo $post['created_at']; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
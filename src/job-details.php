<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // jobs ID'sini URL parametresinden al
    $jobs_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // jobs gönderisini veritabanından çek
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = :id");
    $stmt->bindParam(':id', $jobs_id, PDO::PARAM_INT);
    $stmt->execute();
    $jobs_post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$jobs_post) {
        // Eğer jobs gönderisi bulunamazsa, hata mesajı göster
        die("jobs post not found.");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/_header.php'; ?>
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

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Job Details</h4>
                            <h2><?php echo htmlspecialchars($jobs_post['title']); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Banner Ends Here -->

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div>
                        <img src="<?php echo '../admin/' . $jobs_post['img']; ?>" alt="" class="img-fluid wc-image">
                    </div>

                    <br>
                </div>

                <div class="col-md-8">
                    <div class="sidebar-item recent-posts">
                        <div class="sidebar-heading">
                            <h2>
                                <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($jobs_post['city']); ?>
                                &nbsp;&nbsp;
                                <i class="fa fa-calendar"></i><?php echo htmlspecialchars($jobs_post['date']); ?>
                                &nbsp;&nbsp;
                                <i class="fa fa-file"></i> <?php echo htmlspecialchars($jobs_post['sector']); ?>
                            </h2>
                        </div>

                        <div class="content">
                            <p>To apply for this position, please click the button below:</p>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="main-button">
                                <a href="#">Apply for this Job</a>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br><br>
                </div>
            </div>
        </div>
    </section>

    <div class="section contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sidebar-item recent-posts">
                        <br><br>
                        <div class="sidebar-heading">
                            <h2>Company Information</h2>
                        </div>

                        <div class="content">
                            <p class="lead">
                                <?php echo htmlspecialchars($jobs_post['company_name']); ?>
                            </p>

                            <br>

                            <p><?php echo htmlspecialchars($jobs_post['description']); ?></p>

                            <br>


                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-item recent-posts">
                        <br><br>
                        <div class="sidebar-heading">
                            <h2>Contact Details</h2>
                        </div>

                        <div class="content">
                            <p>
                                <span>Address</span>

                                <br>

                                <strong>
                                    <?php echo htmlspecialchars($jobs_post['city']); ?>
                                </strong>
                            </p>

                            <p>
                                <span>Email</span>

                                <br>

                                <strong>
                                    <a href="mailto:<?php echo htmlspecialchars($jobs_post['email']); ?>">
                                        <?php echo htmlspecialchars($jobs_post['email']); ?>
                                    </a>
                                </strong>
                            </p>

                            <p>
                                <span>Website</span>

                                <br>

                                <strong>
                                    <a href="http://www.cannonguards.com/">http://www.example.com/</a>
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

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
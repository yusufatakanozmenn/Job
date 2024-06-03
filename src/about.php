<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

include '../libs/language.php';

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanından verileri çek
    $sql = "SELECT * FROM about";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $about = $stmt->fetch(PDO::FETCH_ASSOC);
    
     // Veritabanından iletişim bilgilerini çek
     $stmt = $conn->prepare("SELECT * FROM contact_info LIMIT 1");
     $stmt->execute();
     $contact = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include '../includes/_header.php'; ?>
    <title><?php echo $lang['about']; ?></title>

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
                            <h4><?php echo $lang['about_us']; ?></h4>
                            <h2><?php echo $lang['more_about_us']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Banner Ends Here -->

    <section class="about-us">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($about) : ?>
                    <img src="<?php echo '../admin/' . $about['image_path']; ?>" alt="">
                    <p><?php echo $about['text']; ?></p>
                    <?php else : ?>
                    <p><?php echo $lang['about_section']; ?>.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <ul class="social-icons">
                        <li><a href="<?php echo $contact['facebook_link']; ?>"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo $contact['twitter_link']; ?>"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php echo $contact['linkedin_link']; ?>"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
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
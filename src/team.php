<?php

include '../libs/language.php';
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // Create database connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all team members
    $sql = "SELECT * FROM team";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include '../includes/_header.php'; ?>
    <title><?php echo $lang['team']; ?></title>
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
                            <h4><?php echo $lang['team']; ?></h4>
                            <h2><?php echo $lang['our_team']; ?></h2>
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
                <div class="row">
                    <?php foreach ($teamMembers as $member) { ?>
                    <div class="col-md-3 col-sm-4">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="../admin/<?php echo $member['image_path']; ?>" alt="">
                            </div>
                            <div class="down-content">
                                <span><?php echo $member['position']; ?></span>
                                <h4><?php echo $member['name']; ?></h4>
                                <?php if (!empty($member['social_media'])) { ?>
                                <ul class="post-info">
                                    <li><a href="<?php echo $member['social_media']; ?>"><i
                                                class="fa fa-linkedin"></i></a></li>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
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

    // Veritabanından blog gönderilerini çek
    $stmt = $conn->prepare("SELECT * FROM blog_posts");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Değişiklik burada yapıldı
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
                            <h4>Blog</h4>
                            <h2>Our Recent Blog Posts</h2>
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
                <div class="col-lg-12">
                    <div class="all-blog-posts">
                        <div class="row">
                            <?php foreach ($posts as $post): ?>
                            <div class="col-lg-4">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="../admin/uploads/<?php echo $post['img']; ?>" alt="">
                                    </div>
                                    <div class="down-content">
                                        <a href="blog-details.php?id=<?php echo $post['id']; ?>">
                                            <h4><?php echo $post['title']; ?></h4>
                                        </a>
                                        <p><?php echo substr($post['content'], 0, 150) . (strlen($post['content']) > 150 ? '...' : ''); ?>
                                        </p>
                                        <ul class="post-info">
                                            <li><a href="#"><?php echo $post['author_id']; ?></a></li>
                                            <li><a href="#"><?php echo $post['created_at']; ?></a></li>
                                            <li><a href="#"><i class="fa fa-comments" title="Comments"></i> 12</a></li>
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
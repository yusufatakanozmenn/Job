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

    // Blog ID'sini URL parametresinden al
    $blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Blog gönderisini veritabanından çek
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = :id");
    $stmt->bindParam(':id', $blog_id, PDO::PARAM_INT);
    $stmt->execute();
    $blog_post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog_post) {
        // Eğer blog gönderisi bulunamazsa, hata mesajı göster
        die("Blog post not found.");
    }

    // Yorumları veritabanından çek
    $stmt = $conn->prepare("SELECT * FROM comments WHERE blog_id = :blog_id ORDER BY date DESC");
    $stmt->bindParam(':blog_id', $blog_id, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                            <h4>Post Details</h4>
                            <h2><?php echo htmlspecialchars($blog_post['title']); ?></h2>
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
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="<?php echo '../admin/uploads/' . $blog_post['img']; ?>" alt="">
                                    </div>
                                    <div class="down-content">
                                        <a href="blog-details.php?id=<?php echo $blog_post['id']; ?>">
                                            <h4><?php echo htmlspecialchars($blog_post['title']); ?></h4>
                                        </a>
                                        <ul class="post-info">
                                            <li><a href="#"><?php echo htmlspecialchars($blog_post['author_id']); ?></a>
                                            </li>
                                            <li><a
                                                    href="#"><?php echo htmlspecialchars($blog_post['created_at']); ?></a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-comments" title="Comments"></i>
                                                    <?php echo count($comments); ?></a></li>
                                        </ul>
                                        <p><?php echo nl2br(htmlspecialchars($blog_post['content'])); ?></p>
                                        <div class="post-options">
                                            <div class="row">
                                                <div class="col-6">

                                                </div>
                                                <div class="col-6">
                                                    <ul class="post-share">
                                                        <li><i class="fa fa-share-alt"></i></li>
                                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://localhost.com/blog-details.php?id=' . $post['id']); ?>"
                                                                target="_blank">Facebook</a>,</li>
                                                        <li><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://localhost.com/blog-details.php?id=' . $post['id']); ?>"
                                                                target="_blank">Twitter</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item comments">
                                    <div class="sidebar-heading">
                                        <h2><?php echo count($comments); ?> comments</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <?php foreach ($comments as $comment) { ?>
                                            <li>
                                                <div class="author-thumb">
                                                    <img src="../assets/images/comment-author-01.jpg" alt="">
                                                </div>
                                                <div class="right-content">
                                                    <h4><?php echo htmlspecialchars($comment['author']); ?><span><?php echo htmlspecialchars($comment['date']); ?></span>
                                                    </h4>
                                                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item submit-comment">
                                    <div class="sidebar-heading">
                                        <h2>Your comment</h2>
                                    </div>
                                    <div class="content">
                                        <form id="comment" action="../admin/add_comment.php" method="post">
                                            <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <fieldset>
                                                        <input name="author" type="text" id="author"
                                                            placeholder="Your name" required="">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <fieldset>
                                                        <input name="email" type="email" id="email"
                                                            placeholder="Your email" required="">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input name="subject" type="text" id="subject"
                                                            placeholder="Subject">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <textarea name="comment" rows="6" id="comment"
                                                            placeholder="Type your comment" required=""></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <button type="submit" id="form-submit"
                                                            class="main-button">Submit</button>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sidebar-item search">
                                    <form id="search_form" name="gs" method="GET" action="#">
                                        <input type="text" name="q" class="searchText" placeholder="type to search..."
                                            autocomplete="on">
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item recent-posts">
                                    <div class="sidebar-heading">
                                        <h2>Recent Posts</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <!-- Recent Posts Loop -->
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 5");
                                            $stmt->execute();
                                            $recent_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($recent_posts as $recent) {
                                                echo '<li><a href="blog-details.php?id=' . $recent['id'] . '">';
                                                echo '<h4>' . htmlspecialchars($recent['title']) . '</h4>';
                                                echo '<p>' . htmlspecialchars($recent['content']) . '</p>';
                                                echo '<span>' . htmlspecialchars($recent['created_at']) . '</span>';
                                                echo '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
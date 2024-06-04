<?php
include '../libs/vars.php';
include 'admin_check.php';
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
include '../libs/database.php';

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
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['blog_list']; ?></title>
</head>

<body class="bg-theme bg-theme1">

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

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
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="card-title"><?php echo $lang['blogs']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="create_post.php"
                                        class="btn btn-primary"><?php echo $lang['add_blog']; ?></a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"><?php echo $lang['title']; ?></th>
                                                <th scope="col"><?php echo $lang['content']; ?></th>
                                                <th scope="col"><?php echo $lang['author']; ?></th>
                                                <th scope="col"><?php echo $lang['actions']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($posts as $post): ?>
                                            <tr>
                                                <th scope="row"><?php echo $post['id']; ?></th>
                                                <td><?php echo $post['title']; ?></td>
                                                <td><?php echo substr($post['content'], 0, 70) . (strlen($post['content']) > 70 ? '...' : ''); ?>
                                                </td>
                                                <td><?php echo $post['author_id']; ?></td>
                                                <td>
                                                    <a href="update_blog.php?id=<?php echo $post['id']; ?>"
                                                        class="btn btn-primary"><?php echo $lang['edit_blog']; ?></a>
                                                    <a href="delete_post.php?id=<?php echo $post['id']; ?>"
                                                        class="btn btn-danger"><?php echo $lang['delete_blog']; ?></a>
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
                <!--End Row-->

                <!--start overlay-->
                <div class="overlay toggle-menu"></div>
                <!--end overlay-->

            </div>
            <!-- End container-fluid-->
        </div>




        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
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

    <!-- Custom scripts -->
    <script src="./assets/js/app-script.js"></script>

</body>

</html>
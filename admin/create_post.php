<?php
require_once '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

// Oturumdaki kullanıcı adını al
$username = $_SESSION['username'];

// Kullanıcı ID'sini veritabanından çekme
$stmt = $connection->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

$stmt->close();

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $img = '';

    // Resim yükleme işlemi
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $imgTmpPath = $_FILES['img']['tmp_name'];
        $imgName = $_FILES['img']['name'];
        $imgSize = $_FILES['img']['size'];
        $imgType = $_FILES['img']['type'];
        $imgNameCmps = explode(".", $imgName);
        $imgExtension = strtolower(end($imgNameCmps));
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($imgExtension, $allowedfileExtensions)) {
            // Resmin yeni adını oluştur
            $uniqueId = uniqid();
            $img = $uniqueId . '.' . $imgExtension;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $img;

            if (move_uploaded_file($imgTmpPath, $dest_path)) {
                // Resim başarıyla yüklendi
            } else {
                echo "Resim yüklenirken bir hata oluştu.";
            }
        } else {
            echo "Yalnızca JPG, JPEG, PNG veya GIF dosyaları yüklenebilir.";
        }
    } else {
        echo "Resim yüklemeniz gerekmektedir.";
    }

    // Veritabanına blog gönderisini ekleme
    if (!empty($title) && !empty($content) && !empty($img)) {
        $stmt = $connection->prepare("INSERT INTO blog_posts (title, content, img, author_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $title, $content, $img, $user_id);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            echo "Blog gönderisi eklenirken bir hata oluştu.";
        }

        $stmt->close();
    }
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
    <title>Create Blog</title>
    <!-- loader-->
    <link href="./assets/css/pace.min.css" rel="stylesheet" />
    <script src="./assets/js/pace.min.js"></script>
    <!--favicon-->
    <link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon" />
    <!-- Vector CSS -->
    <link href="./assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- simplebar CSS-->
    <link href="./assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="./assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="./assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="./assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="./assets/css/app-style.css" rel="stylesheet" />
</head>


<body class="bg-theme bg-theme1">


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
                <div class="row mt-3">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card">
                            <div class="card-body">
                                <h2>Create Blog</h2>
                                <form action="create_post.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title">Başlık</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">İçerik</label>
                                        <textarea name="content" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="img">Resim</label>
                                        <input type="file" name="img" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gönderiyi Oluştur</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container-fluid-->
        </div>


        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        <!--Start footer-->
        <footer class="footer">
            <div class="container">
                <div class="text-center">Copyright © 2024 Yusuf Atakan Özmen</div>
            </div>
        </footer>
        <!--End footer-->
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
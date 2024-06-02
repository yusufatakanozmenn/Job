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

// Blog gönderisi ID'sini al
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Belirli bir blog gönderisini veritabanından al
    $stmt = $connection->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc(); // Blog gönderisini $post değişkenine ata
    $stmt->close();
} else {
    header('Location: blog_list.php');
    exit;
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Resim yükleme işlemi
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];

        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array($imageExt, $allowed)) {
            echo "Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        } elseif ($imageSize >= 5000000) {
            echo "Image size is too big!";
            exit;
        } else {
            $imageNewName = uniqid('', true) . "." . $imageExt;
            $imageDestination = 'uploads/' . $imageNewName;

            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                // Eski resmi sil
                if ($post['image_path']) {
                    unlink($post['image_path']);
                }
                
                // Resim yolu veritabanında güncelle
                $stmt = $connection->prepare("UPDATE blog_posts SET image_path = ? WHERE id = ?");
                $stmt->bind_param('si', $imageDestination, $post_id);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Failed to upload image.";
                exit;
            }
        }
    }

    // Veritabanında blog gönderisini güncelleme
    $stmt = $connection->prepare("UPDATE blog_posts SET title = ?, content = ? WHERE id = ? AND author_id = ?");
    $stmt->bind_param('ssii', $title, $content, $post_id, $user_id);

    if ($stmt->execute()) {
        header('Location: blog_list.php');
        exit;
    } else {
        echo "Blog gönderisi güncellenirken bir hata oluştu.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['edit_blog']; ?></title>

    <script>
    window.onload = function() {
        // URL parametrelerini kontrol et
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        // Eğer hata veya başarı mesajı varsa göster
        if (successMessage) {
            alert(successMessage);
        } else if (errorMessage) {
            alert(errorMessage);
        }
    }
    </script>
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
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="card-title"><?php echo $lang['edit_blog']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_blog.php?id=<?php echo $post_id; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="title"><?php echo $lang['title']; ?></label>
                                        <input type="text" name="title" class="form-control"
                                            value="<?php echo $post['title']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content"><?php echo $lang['content']; ?></label>
                                        <textarea name="content" class="form-control"
                                            required><?php echo $post['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><?php echo $lang['image']; ?></label>
                                        <input type="file" name="image" class="form-control-file">
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary"><?php echo $lang['update']; ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Row-->


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
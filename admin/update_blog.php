<?php

require_once '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

// Veritabanı bağlantısı
$connection = new mysqli($server, $username, $password, $database);
mysqli_set_charset($connection, "UTF8");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Oturumdaki kullanıcı adını al
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: login.php'); // Oturum açılmadıysa, kullanıcıyı giriş sayfasına yönlendirin
    exit;
}

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
    $post = $result->fetch_assoc();
    $stmt->close();
} else {
    header('Location: blog_list.php');
    exit;
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');

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
            $imageDestination = $imageNewName;

            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                // Eski resmi sil
                if (isset($post['img']) && file_exists($post['img'])) {
                    unlink($post['img']);
                }

                // Resim yolu veritabanında güncelle
                $stmt = $connection->prepare("UPDATE blog_posts SET img = ? WHERE id = ?");
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
        header('Location: blog_list.php?success=1');
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
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        if (successMessage) {
            alert(successMessage);
        } else if (errorMessage) {
            alert(errorMessage);
        }
    }
    </script>
</head>

<body class="bg-theme bg-theme1">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <?php include 'include/header.php'; ?>
        <div class="clearfix"></div>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="card-title"><?php echo $lang['edit_blog']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_blog.php?id=<?php echo $post_id; ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title"><?php echo $lang['title']; ?></label>
                                        <input type="text" name="title" class="form-control"
                                            value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content"><?php echo $lang['content']; ?></label>
                                        <textarea name="content" class="form-control"
                                            required><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
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
                <?php include 'include/footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/app-script.js"></script>
</body>

</html>
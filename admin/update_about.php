<?php
include '../libs/vars.php';
include 'admin_check.php';
include '../libs/database.php';


function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mevcut about kaydını al
    $sql = "SELECT * FROM about LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $about = $stmt->fetch(PDO::FETCH_ASSOC);

    // Form gönderildiyse veriyi güncelle
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['text'])) {
            $text = sanitizeInput($_POST['text']);

            // Yeni bir resim yüklendi mi kontrol et
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
                $imageName = $image['name'];
                $imageTmpName = $image['tmp_name'];
                $imageSize = $image['size'];
                $imageError = $image['error'];
                $imageType = $image['type'];

                $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $allowed = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($imageExt, $allowed)) {
                    header("Location: update_about.php?error=Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.");
                    exit;
                } elseif ($imageSize >= 5000000) {
                    header("Location: update_about.php?error=Image size is too big!");
                    exit;
                } else {
                    $imageNewName = uniqid('', true) . "." . $imageExt;
                    $imageDestination = '../admin/uploads/' . $imageNewName;

                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        // Eski resmi sil
                        if ($about['image_path']) {
                            unlink($about['image_path']);
                        }

                        // Veritabanını güncelle
                        $sql = "UPDATE about SET text = :text, image_path = :image_path WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':text', $text);
                        $stmt->bindParam(':image_path', $imageDestination);
                        $stmt->bindParam(':id', $about['id']);
                        $stmt->execute();

                        header("Location: update_about.php?success=About section updated successfully.");
                        exit;
                    } else {
                        header("Location: update_about.php?error=Failed to upload image.");
                        exit;
                    }
                }
            } else {
                // Sadece metin güncellenirse
                $sql = "UPDATE about SET text = :text WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':id', $about['id']);
                $stmt->execute();

                header("Location: update_about.php?success=About section updated successfully.");
                exit;
            }
        } else {
            header("Location: update_about.php?error=Text field is required.");
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['edit_about']; ?></title>
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
                        <h1><?php echo $lang['edit_about']; ?></h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_about.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="text"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['text']; ?></label>
                                        <div class="col-lg-9">
                                            <textarea name="text" id="text" cols="30" rows="10"
                                                class="form-control"><?php echo htmlspecialchars($about['text']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['image']; ?></label>
                                        <div class="col-lg-9">
                                            <?php if ($about['image_path']) : ?>
                                            <img src="<?php echo $about['image_path']; ?>" alt="Current Image"
                                                style="max-width: 200px;"><br><br>
                                            <?php endif; ?>
                                            <label for="image"><?php echo $lang['new_image']; ?>:</label><br>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['update']; ?></button>
                                        </div>
                                    </div>
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

    <!-- CKEditor -->
    <script src="path/to/ckeditor.js"></script>
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

        // CKEditor'u textarea'ya uygula
        CKEDITOR.replace('text');
    }
    </script>

</body>

</html>
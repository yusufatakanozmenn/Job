<?php

include '../libs/vars.php';
include 'admin_check.php';
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

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
            $text = $_POST['text'];

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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Create About</title>
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
                <div class="row mt-3">
                    <div class="col-lg-8 offset-lg-2">
                        <h1>Update About</h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_about.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="text"
                                            class="col-lg-3 col-form-label form-control-label">Text:</label>
                                        <div class="col-lg-9">
                                            <textarea name="text" id="text" cols="30" rows="10"
                                                class="form-control"><?php echo htmlspecialchars($about['text']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image" class="col-lg-3 col-form-label form-control-label">Current
                                            Image:</label>
                                        <div class="col-lg-9">
                                            <?php if ($about['image_path']) : ?>
                                            <img src="<?php echo $about['image_path']; ?>" alt="Current Image"
                                                style="max-width: 200px;"><br><br>
                                            <?php endif; ?>
                                            <label for="image">Upload New Image:</label><br>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
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

</body>

</html>
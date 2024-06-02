<?php
include '../libs/vars.php';
include 'admin_check.php';
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

// Form gönderildiğinde çalışacak kodlar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alın
    $name = $_POST['name'];
    $position = $_POST['position'];
    $social_media = $_POST['social_media'];
    
    // Resim dosyasını alın
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];

    // Resim dosyasını yüklemek için izin verilen dosya türleri
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Resim dosyasının uzantısını kontrol edin
    if (in_array($imageExt, $allowed)) {
        // Resim yükleme hatası kontrolü
        if ($imageError === 0) {
            // Resim dosya boyutunu kontrol edin (maksimum 5MB)
            if ($imageSize < 5000000) {
                // Resmin yeni adını oluşturun
                $imageNewName = uniqid('', true) . "." . $imageExt;
                $imageDestination = 'uploads/' . $imageNewName;

                // Resmi hedef klasöre taşıyın
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    // Veritabanına ekibinizi ekleyin
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "INSERT INTO team (name, position, social_media, image_path) VALUES ('$name', '$position', '$social_media', '$imageDestination')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Team member added successfully!');</script>";
                        header("Location: ../src/team.php");
                    } else {
                        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
                    }

                    $conn->close();
                } else {
                    echo "<script>alert('Failed to upload image.');</script>";
                }
            } else {
                echo "<script>alert('Image size is too big!');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image: " . $imageError . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['create_team']; ?></title>
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
                        <h1><?php echo $lang['add_team']; ?></h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="create_team.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['name']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="position"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['position']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="position" name="position" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="social_media"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['social_media']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="social_media" name="social_media"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['image']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="file" id="image" name="image" accept="image/*"
                                                class="form-control-file" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['add_team']; ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
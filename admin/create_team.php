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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Create Team</title>
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
                        <h1>Add Team Member</h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="create_team.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-lg-3 col-form-label form-control-label">Name:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="position"
                                            class="col-lg-3 col-form-label form-control-label">Position:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="position" name="position" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="social_media"
                                            class="col-lg-3 col-form-label form-control-label">Social Media:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="social_media" name="social_media"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label">Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" id="image" name="image" accept="image/*"
                                                class="form-control-file" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Add Team Member</button>
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
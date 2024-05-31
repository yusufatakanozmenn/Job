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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['text'], $_FILES['image'])) {
            $text = $_POST['text'];
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $imageTmpName = $image['tmp_name'];
            $imageSize = $image['size'];
            $imageError = $image['error'];
            $imageType = $image['type'];

            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($imageExt, $allowed)) {
                if ($imageError === 0) {
                    if ($imageSize < 5000000) {
                        // Hedef dizini kontrol edin ve yoksa oluşturun
                        $uploadDir = 'uploads/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }

                        $imageNewName = uniqid('', true) . "." . $imageExt;
                        $imageDestination = $uploadDir . $imageNewName;

                        if (move_uploaded_file($imageTmpName, $imageDestination)) {
                            $sql = "INSERT INTO about (text, image_path) VALUES (:text, :image_path)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':text', $text);
                            $stmt->bindParam(':image_path', $imageDestination);
                            $stmt->execute();

                            echo "About section updated successfully";
                            header ("Location: index.php");
                        } else {
                            echo "Failed to upload image. Please try again later.";
                        }
                    } else {
                        echo "Image size is too big! Please upload an image smaller than 5MB.";
                    }
                } else {
                    echo "Error uploading image: " . $imageError;
                }
            } else {
                echo "Invalid file type! Please upload an image with JPG, JPEG, PNG, or GIF format.";
            }
        } else {
            echo "All form fields are required.";
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
                        <h1>Create About</h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="create_about.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="text"
                                            class="col-lg-3 col-form-label form-control-label">Text:</label>
                                        <div class="col-lg-9">
                                            <textarea name="text" id="text" cols="30" rows="10"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label">Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Create</button>
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
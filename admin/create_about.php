<?php
include '../libs/vars.php';
include 'admin_check.php';
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
include '../libs/database.php';

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
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['create_about']; ?></title>
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
                        <h1><?php echo $lang['create_about']; ?></h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="create_about.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="text"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['text']; ?></label>
                                        <div class="col-lg-9">
                                            <textarea name="text" id="text" cols="30" rows="10"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['image']; ?></label>
                                        <div class="col-lg-9">
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['edit_about']; ?></button>
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
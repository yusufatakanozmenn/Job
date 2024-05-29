<?php
// Veritabanı bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Form verilerini al
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Form verilerini doğrula ve al
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $sector = htmlspecialchars(trim($_POST['sector']));
        $city = htmlspecialchars(trim($_POST['city']));

        
        session_start();
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 8;
        // Resim dosyasını kontrol et
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $imageTempName = $image['tmp_name'];
            $imageSize = $image['size'];

            // İstenen dosya türlerini kontrol etmek için izin verilen dosya uzantılarını belirle
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

            if (in_array($imageExtension, $allowedExtensions)) {
                // Dosya boyutunu kontrol et
                if ($imageSize < 5000000) { // 5MB sınırı
                    // Yeni bir dosya adı oluştur
                    $newImageName = uniqid('', true) . '.' . $imageExtension;
                    $imageDestination = 'uploads/' . $newImageName;

                    // Dosyayı belirtilen hedefe taşı
                    if (move_uploaded_file($imageTempName, $imageDestination)) {
                        // Veritabanına iş ilanı eklemek için SQL sorgusunu hazırla
                        $sql = "INSERT INTO jobs (title, description, sector, city, user_id, img) 
                                VALUES (:title, :description, :sector, :city, :user_id, :img)";
                        // PDO sorgusunu hazırla ve bağlı parametreleri ayarla
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':title', $title);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':sector', $sector);
                        $stmt->bindParam(':city', $city);
                        $stmt->bindParam(':user_id', $user_id);
                        $stmt->bindParam(':img', $imageDestination);

                        // Sorguyu çalıştır
                        $stmt->execute();

                        // İş ilanı başarıyla eklendiğine dair mesajı göster
                        echo "<script>alert('New job listing added successfully');</script>";
                        header ("Location: index.php");
                    } else {
                        echo "<script>alert('Failed to upload image.');</script>";
                    }
                } else {
                    echo "<script>alert('Image size is too big!');</script>";
                }
            } else {
                echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
            }
        } else {
            echo "<script>alert('Image is required.');</script>";
        }
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Connection failed: " . $e->getMessage() . "</p>";
}

// Veritabanı bağlantısını kapat
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
                        <h1>Create Job</h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="create_job.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="title"
                                            class="col-lg-3 col-form-label form-control-label">Title:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="title" name="title" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description"
                                            class="col-lg-3 col-form-label form-control-label">Description:</label>
                                        <div class="col-lg-9">
                                            <textarea id="description" name="description" cols="30" rows="10"
                                                class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sector"
                                            class="col-lg-3 col-form-label form-control-label">Sector:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="sector" name="sector" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city"
                                            class="col-lg-3 col-form-label form-control-label">City:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="city" name="city" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label">Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" id="image" name="image" class="form-control-file"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
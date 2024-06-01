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

   
    // İş ilanı id'sini al
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // İş ilanını veritabanından seç
        $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$job) {
            // İş ilanı bulunamazsa, kullanıcıyı iş listesine yönlendir
            header("Location: jobs_list.php");
            exit();
        }
    } else {
        // Eğer id belirtilmemişse, kullanıcıyı iş listesine yönlendir
        header("Location: jobs_list.php");
        exit();
    }

    // Form gönderildiğinde
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Formdan gelen verileri al
        $title = $_POST['title'];
        $description = $_POST['description'];
        $email = $_POST['email'];
        $company_name = $_POST['company_name'];
        $sector = $_POST['sector'];
        $city = $_POST['city'];
    

        // Veritabanında iş ilanını güncelle
        $stmt = $conn->prepare("UPDATE jobs SET title = :title, description = :description, email = :email, company_name = :company_name, sector = :sector, city = :city WHERE id = :id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // İş ilanı başarıyla güncellendiyse, kullanıcıyı iş listesine yönlendir
        header("Location: jobs_list.php");
        exit();
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
    <title>Edit Job</title>
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
                        <h2>Edit Job</h2>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST">
                                    <div class="form-group row">
                                        <label for="title"
                                            class="col-lg-3 col-form-label form-control-label">Title:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="<?php echo $job['title']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description"
                                            class="col-lg-3 col-form-label form-control-label">Description:</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="description" name="description" cols="30"
                                                rows="10" required><?php echo $job['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email"
                                            class="col-lg-3 col-form-label form-control-label">Email:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="<?php echo $job['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_name"
                                            class="col-lg-3 col-form-label form-control-label">Company Name:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="company_name"
                                                name="company_name" value="<?php echo $job['company_name']; ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sector"
                                            class="col-lg-3 col-form-label form-control-label">Sector:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="sector" name="sector"
                                                value="<?php echo $job['sector']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city"
                                            class="col-lg-3 col-form-label form-control-label">City:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="<?php echo $job['city']; ?>" required>
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
                                            <button type="submit" class="btn btn-primary">Update</button>
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
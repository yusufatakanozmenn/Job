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
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['edit_job']; ?></title>
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
                        <h2><?php echo $lang['edit_job']; ?></h2>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST">
                                    <div class="form-group row">
                                        <label for="title"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['title']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="<?php echo $job['title']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['description']; ?>:</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="description" name="description" cols="30"
                                                rows="10" required><?php echo $job['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['email']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="<?php echo $job['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_name"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['company_name']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="company_name"
                                                name="company_name" value="<?php echo $job['company_name']; ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sector"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['sector']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="sector" name="sector"
                                                value="<?php echo $job['sector']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['city']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="<?php echo $job['city']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['image']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="file" id="image" name="image" class="form-control-file"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['edit']; ?></button>
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
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

    // Mevcut iletişim bilgilerini al
    $sql = "SELECT * FROM contact_info LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    // Form gönderildiyse veriyi güncelle
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['phone_number']) && isset($_POST['email_address']) && isset($_POST['google_maps_embed']) &&
            isset($_POST['facebook_link']) && isset($_POST['twitter_link']) && isset($_POST['linkedin_link'])) {
            
            $phone_number = $_POST['phone_number'];
            $email_address = $_POST['email_address'];
            $google_maps_embed = $_POST['google_maps_embed'];
            $facebook_link = $_POST['facebook_link'];
            $twitter_link = $_POST['twitter_link'];
            $linkedin_link = $_POST['linkedin_link'];

            if ($contact) {
                // Mevcut kaydı güncelle
                $sql = "UPDATE contact_info SET phone_number = :phone_number, email_address = :email_address, google_maps_embed = :google_maps_embed, facebook_link = :facebook_link, twitter_link = :twitter_link, linkedin_link = :linkedin_link WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':phone_number', $phone_number);
                $stmt->bindParam(':email_address', $email_address);
                $stmt->bindParam(':google_maps_embed', $google_maps_embed);
                $stmt->bindParam(':facebook_link', $facebook_link);
                $stmt->bindParam(':twitter_link', $twitter_link);
                $stmt->bindParam(':linkedin_link', $linkedin_link);
                $stmt->bindParam(':id', $contact['id']);
            } else {
                // Yeni kayıt ekle
                $sql = "INSERT INTO contact_info (phone_number, email_address, google_maps_embed, facebook_link, twitter_link, linkedin_link) VALUES (:phone_number, :email_address, :google_maps_embed, :facebook_link, :twitter_link, :linkedin_link)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':phone_number', $phone_number);
                $stmt->bindParam(':email_address', $email_address);
                $stmt->bindParam(':google_maps_embed', $google_maps_embed);
                $stmt->bindParam(':facebook_link', $facebook_link);
                $stmt->bindParam(':twitter_link', $twitter_link);
                $stmt->bindParam(':linkedin_link', $linkedin_link);
            }

            $stmt->execute();

            header("Location: update_contact.php?success=Contact information updated successfully.");
            exit;
        } else {
            header("Location: update_contact.php?error=All fields are required.");
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
    <title>Update Contact Information</title>
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
                        <h1>Update Contact Information</h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_contact.php" method="POST">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control"
                                            value="<?php echo $contact ? $contact['phone_number'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_address">Email Address</label>
                                        <input type="email" name="email_address" class="form-control"
                                            value="<?php echo $contact ? $contact['email_address'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="google_maps_embed">Google Maps Embed Code</label>
                                        <textarea name="google_maps_embed" class="form-control"
                                            required><?php echo $contact ? $contact['google_maps_embed'] : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="facebook_link">Facebook Link</label>
                                        <input type="text" name="facebook_link" class="form-control"
                                            value="<?php echo $contact ? $contact['facebook_link'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_link">Twitter Link</label>
                                        <input type="text" name="twitter_link" class="form-control"
                                            value="<?php echo $contact ? $contact['twitter_link'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="linkedin_link">LinkedIn Link</label>
                                        <input type="text" name="linkedin_link" class="form-control"
                                            value="<?php echo $contact ? $contact['linkedin_link'] : ''; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
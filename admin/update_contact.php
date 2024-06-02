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
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['update_contact']; ?></title>

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
                        <h1><?php echo $lang['update_contact']; ?></h1>
                        <div class="card">
                            <div class="card-body">
                                <form action="update_contact.php" method="POST">
                                    <div class="form-group">
                                        <label for="phone_number"><?php echo $lang['phone_number']; ?></label>
                                        <input type="text" name="phone_number" class="form-control"
                                            value="<?php echo $contact ? $contact['phone_number'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_address"><?php echo $lang['email']; ?></label>
                                        <input type="email" name="email_address" class="form-control"
                                            value="<?php echo $contact ? $contact['email_address'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="google_maps_embed"><?php echo $lang['google_maps_embed']; ?></label>
                                        <textarea name="google_maps_embed" class="form-control"
                                            required><?php echo $contact ? $contact['google_maps_embed'] : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="facebook_link"><?php echo $lang['facebook_link']; ?></label>
                                        <input type="text" name="facebook_link" class="form-control"
                                            value="<?php echo $contact ? $contact['facebook_link'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_link"><?php echo $lang['twitter_link']; ?></label>
                                        <input type="text" name="twitter_link" class="form-control"
                                            value="<?php echo $contact ? $contact['twitter_link'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="linkedin_link"><?php echo $lang['linkedin_link']; ?></label>
                                        <input type="text" name="linkedin_link" class="form-control"
                                            value="<?php echo $contact ? $contact['linkedin_link'] : ''; ?>">
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary"><?php echo $lang['update']; ?></button>
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
<?php
include '../libs/vars.php';
include 'admin_check.php';
include '../libs/database.php';


try {
    // Create database connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id']; // Get the ID from the URL
    $sql = "SELECT * FROM team WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $team = $stmt->fetch(PDO::FETCH_ASSOC);

    // If form is submitted, update the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']) && isset($_POST['position']) && isset($_POST['social_media'])) {
            $name = $_POST['name'];
            $position = $_POST['position'];
            $social_media = $_POST['social_media'];

            // Check if a new image is uploaded
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
                    header("Location: update_team.php?id=$id&error=Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.");
                    exit;
                } elseif ($imageSize >= 5000000) {
                    header("Location: update_team.php?id=$id&error=Image size is too big!");
                    exit;
                } else {
                    $imageNewName = uniqid('', true) . "." . $imageExt;
                    $imageDestination = '../admin/uploads/' . $imageNewName;

                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        // Delete old image if exists
                        if ($team['image_path']) {
                            unlink($team['image_path']);
                        }

                        // Update the database
                        $sql = "UPDATE team SET name = :name, position = :position, social_media = :social_media, image_path = :image_path WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':position', $position);
                        $stmt->bindParam(':social_media', $social_media);
                        $stmt->bindParam(':image_path', $imageDestination);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();

                        header("Location: team_list.php");
                        exit;
                    } else {
                        header("Location: update_team.php?id=$id&error=Failed to upload image.");
                        exit;
                    }
                }
            } else {
                // If only text is updated
                $sql = "UPDATE team SET name = :name, position = :position, social_media = :social_media WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':social_media', $social_media);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                header("Location: team_list.php");
                exit;
            }
        } else {
            header("Location: update_team.php?id=$id&error=Name, Position and Social Media fields are required.");
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
    <title><?php echo $lang['edit_team']; ?></title>
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
                        <h1><?php echo $lang['edit_team']; ?></h1>
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
                                <?php } ?>
                                <?php if (isset($_GET['success'])) { ?>
                                <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
                                <?php } ?>
                                <form action="update_team.php?id=<?php echo $team['id']; ?>" method="post"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $team['id']; ?>">
                                    <input type="hidden" name="old_image_path"
                                        value="<?php echo $team['image_path']; ?>">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['name']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="<?php echo $team['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="position"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['position']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="position" name="position" class="form-control"
                                                value="<?php echo $team['position']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="social_media"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['social_media']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="social_media" name="social_media"
                                                class="form-control" value="<?php echo $team['social_media']; ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image"
                                            class="col-lg-3 col-form-label form-control-label"><?php echo $lang['image']; ?>:</label>
                                        <div class="col-lg-9">
                                            <input type="file" id="image" name="image" accept="image/*"
                                                class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo $lang['edit_team']; ?></button>
                                            <a href="team_list.php"
                                                class="btn btn-secondary"><?php echo $lang['cancel']; ?></a>
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
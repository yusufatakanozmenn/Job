<?php
require "../libs/ayar.php";
require '../vendor/autoload.php'; // PHPMailer yüklemesi

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$username = $email = $password = $role = "";
$username_err = $email_err = $password_err = $role_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must be at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate role
    if (empty(trim($_POST["role"]))) {
        $role_err = "Please enter a role.";
    } else {
        $role = trim($_POST["role"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($role_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

        if ($stmt = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $username, $email, $password_hashed, $role);

            // Set parameters
            $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Send email
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP sunucusu
                    $mail->SMTPAuth = true;
                    $mail->Username = 'yusufatakanozmen06@gmail.com'; // Gmail kullanıcı adınız
                    $mail->Password = 'qxtd blss sirz znoz'; // Gmail uygulama şifreniz
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom('no-reply@jobs.com', 'jobs');
                    $mail->addAddress($email); // Kullanıcının e-posta adresi

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Kayıt Başarılı';
                    $mail->Body = "Merhaba $username,<br><br>Kayıt işleminiz başarıyla tamamlandı.<br><br>Rolünüz: $role";

                    $mail->send();
                    echo 'Kayıt başarılı, e-posta gönderildi.';
                } catch (Exception $e) {
                    echo "Kayıt başarılı ancak e-posta gönderilemedi. Mailer Error: {$mail->ErrorInfo}";
                }

                // Redirect to login page
                header('Location: login.php');
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>
    <title><?php echo $lang['register']; ?></title>
</head>

<body class="bg-theme bg-theme1">
    <!-- Start wrapper-->
    <div id="wrapper">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="register.php" method="POST" novalidate>
                                <div class="mb-3">
                                    <label for="username" class="form-label"><?php echo $lang['username']; ?></label>
                                    <input type="text"
                                        class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : '' ?>"
                                        value="<?php echo htmlspecialchars($username); ?>" name="username"
                                        id="username">
                                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label"><?php echo $lang['email']; ?></label>
                                    <input type="text"
                                        class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : '' ?>"
                                        value="<?php echo htmlspecialchars($email); ?>" name="email" id="email">
                                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label"><?php echo $lang['password']; ?></label>
                                    <input type="password"
                                        class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '' ?>"
                                        value="<?php echo htmlspecialchars($password); ?>" name="password"
                                        id="password">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label"><?php echo $lang['role']; ?></label>
                                    <select class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : '' ?>"
                                        name="role" id="role">
                                        <option value=""><?php echo $lang['select_role']; ?></option>
                                        <option value="IK" <?php echo ($role === 'IK') ? 'selected' : ''; ?>>
                                            <?php echo $lang['IK']; ?></option>
                                        <option value="Admin" <?php echo ($role === 'Admin') ? 'selected' : ''; ?>>
                                            <?php echo $lang['admin']; ?>
                                        </option>
                                        <option value="Calisan" <?php echo ($role === 'Employee') ? 'selected' : ''; ?>>
                                            <?php echo $lang['employee']; ?></option>
                                    </select>
                                    <span class="invalid-feedback"><?php echo $role_err; ?></span>
                                </div>

                                <input type="submit" name="register" value="Submit" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--wrapper-->

    <!--Start footer-->
    <?php include 'include/footer.php'; ?>
    <!--End footer-->

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- sidebar-menu js -->
    <script src="./assets/js/sidebar-menu.js"></script>
    <!-- Custom scripts -->
    <script src="./assets/js/app-script.js"></script>
</body>

</html>
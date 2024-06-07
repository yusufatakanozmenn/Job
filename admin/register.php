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
                $mail->CharSet = 'UTF-8'; // Türkçe karakter desteği
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
                    $mail->Subject = 'Kayıt Basarili';
                    $mail->Body = "Merhaba $username,<br><br>Kayit işleminiz başariyla tamamlandi.<br><br>Rolünüz: $role";

                    $mail->send();
                    echo 'Kayit başarili, e-posta gönderildi.';
                } catch (Exception $e) {
                    echo "Kayit basarili ancak e-posta gönderilemedi. Mailer Error: {$mail->ErrorInfo}";
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
    <title>Register</title>
</head>

<body class="bg-theme bg-theme1">
    <!-- Start wrapper-->
    <!-- Start wrapper-->
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="./assets/images/logo_ysf.png" width="100" height="100" alt="logo icon">
                </div>
                <div class="card-title text-uppercase text-center py-3">Register</div>
                <form action="register.php" method="POST" novalidate>
                    <div class="form-group">
                        <label for="username" class="sr-only">Username</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="username" name="username" class="form-control input-shadow"
                                placeholder="Enter Username" value="<?php echo htmlspecialchars($username); ?>"
                                required>
                            <div class="form-control-position">
                                <i class="icon-user"></i>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="email" name="email" class="form-control input-shadow"
                                placeholder="Enter Email" value="<?php echo htmlspecialchars($email); ?>" required>
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password" name="password" class="form-control input-shadow"
                                placeholder="Enter Password" value="<?php echo htmlspecialchars($password); ?>"
                                required>
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="role" class="sr-only">Role</label>
                        <div class="position-relative has-icon-right">
                            <select class="form-control input-shadow" name="role" id="role" required>
                                <option value="">Select Role</option>
                                <option value="IK" <?php echo ($role === 'IK') ? 'selected' : ''; ?>>HR</option>
                                <option value="Calisan" <?php echo ($role === 'Employee') ? 'selected' : ''; ?>>Employee
                                </option>
                            </select>
                            <div class="form-control-position">
                                <i class="icon-briefcase"></i>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?php echo $role_err; ?></span>
                    </div>
                    <button type="submit" name="register" class="btn btn-light btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!--wrapper-->
    <!--wrapper-->

    <footer class="footer">
        <div class="container">
            <div class="text-center">© 2024 Yusuf Atakan Özmen. All Rights Reserved.</div>
        </div>
    </footer>
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
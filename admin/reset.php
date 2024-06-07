<?php
// Veritabanı bağlantısını içeri aktarın
require_once '../libs/ayar.php';
require '../vendor/autoload.php'; // PHPMailer yüklemesi

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Form gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // E-posta adresini alın
    $email = trim($_POST["email"]);

    // E-posta adresine göre kullanıcıyı sorgulayın
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $connection->prepare($sql)) {
        // Parametreleri bağlayın
        $stmt->bind_param("s", $param_email);
        // Parametre değerini ayarlayın
        $param_email = $email;
        // Sorguyu çalıştırın
        if ($stmt->execute()) {
            // Sonuçları alın
            $result = $stmt->get_result();
            // Eğer sonuç varsa
            if ($result->num_rows == 1) {
                // Kullanıcıyı alın
                $row = $result->fetch_assoc();
                // Yeni bir şifre oluşturun
                $new_password = generateRandomString(8); // Örnek bir şifre oluşturma işlevi kullanılabilir
                // Şifreyi güncelleyin
                $sql = "UPDATE users SET password = ? WHERE email = ?";
                if ($stmt = $connection->prepare($sql)) {
                    // Parametreleri bağlayın
                    $stmt->bind_param("ss", $param_password, $param_email);
                    // Parametre değerlerini ayarlayın
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Şifreyi hashleyin
                    $param_email = $email;
                    // Sorguyu çalıştırın
                    if ($stmt->execute()) {
                        // PHPMailer ile e-posta gönderin
                        $mail = new PHPMailer(true);
                        $mail->CharSet = 'UTF-8'; // Türkçe karakter desteği
                        try {
                            //Server settings
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP sunucusu
                            $mail->SMTPAuth = true;
                            $mail->Username = 'yusufatakanozmen06@gmail.com'; // Gmail kullanıcı adınız
                            $mail->Password = 'qxtd blss sirz znoz'; // Uygulama şifresi
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Güvenlik türü
                            $mail->Port = 587; // TCP portu
                            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Alternatif olarak, port 465 için
                            // $mail->Port = 465;

                            //Recipients
                            $mail->setFrom('no-reply@jobs.com', 'jobs');
                            $mail->addAddress($email); // Kullanıcının e-posta adresi

                            //Content
                            $mail->isHTML(true);
                            $mail->Subject = 'Yeni Sifreniz';
                            $mail->Body = "Yeni şifreniz: $new_password";

                            $mail->send();
                            echo 'Yeni şifre e-posta adresinize gönderildi.';
                            header("Location: login.php");
                        } catch (Exception $e) {
                            echo "E-posta gönderilemedi. Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        echo "Şifre sıfırlama başarısız.";
                    }
                }
            } else {
                echo "Böyle bir e-posta ile ilişkili hesap bulunamadı.";
            }
        } else {
            echo "Sorgu yürütülemedi.";
        }
        // Bildirimi kapat
        $stmt->close();
    }
    // Bağlantıyı kapat
    $connection->close();
}

// Rastgele bir dize oluşturan işlev
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <?php include 'include/head.php'; ?>

    <title>Reset Password</title>
</head>

<body class="bg-theme bg-theme1">
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="./assets/images/logo_ysf.png" width="100" height="100" alt="logo icon">
                </div>
                <div class="card-title text-uppercase text-center py-3">Reset Password</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" id="email" name="email" class="form-control input-shadow"
                                placeholder="Enter Email" required>
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light btn-block">Reset Password</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <p class="text-warning mb-0">Remembered your password? <a href="login.php"> Sign In here</a></p>
        </div>
    </div>
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
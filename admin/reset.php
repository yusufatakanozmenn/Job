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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama</title>
</head>

<body>
    <h2>Şifre Sıfırlama Formu</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">E-posta Adresi:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <input type="submit" value="Şifreyi Sıfırla">
        </div>
    </form>
</body>

</html>
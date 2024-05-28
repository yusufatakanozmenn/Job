<?php
require_once '../libs/ayar.php';
require_once '../libs/vars.php';

session_start();

// Kullanıcı oturumu kontrolü
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Form verilerini al
$username = $_SESSION['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hata kontrolü
$errors = [];
$success = "";

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Geçerli bir e-posta giriniz.";
}

if (!empty($password) && strlen($password) < 6) {
    $errors[] = "Şifre en az 6 karakter uzunluğunda olmalıdır.";
}

if (empty($errors)) {
    // Veritabanını güncelle
    if (!empty($password)) {
        // Şifreyi hashle
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("UPDATE users SET email = ?, password = ? WHERE username = ?");
        $stmt->bind_param('sss', $email, $password_hashed, $username);
    } else {
        $stmt = $connection->prepare("UPDATE users SET email = ? WHERE username = ?");
        $stmt->bind_param('ss', $email, $username);
    }

    if ($stmt->execute()) {
        $success = "Bilgileriniz başarıyla güncellendi.";
        header('Location: profile.php');
        exit;
    } else {
        $errors[] = "Bir hata oluştu. Lütfen tekrar deneyin.";
    }

    $stmt->close();
}

// Bağlantıyı kapat
$connection->close();

// JSON formatında hataları ve başarı mesajını döndür
$response = [
    'errors' => $errors,
    'success' => $success
];

echo json_encode($response);
exit;

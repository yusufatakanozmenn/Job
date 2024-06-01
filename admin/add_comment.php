<?php
include '../libs/vars.php';
include 'admin_check.php';

// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

// MySQL bağlantısını oluştur
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantı hatası var mı kontrol et
if (!$connection) {
    die("Veritabanı bağlantısı kurulamadı: " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $notifId = $_POST['id'];

    // Bildirimin durumunu "okundu" olarak güncelle
    $query = "UPDATE notifications SET status = 'read' WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $notifId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Notification marked as read";
} else {
    echo "No notification ID provided";
}

// Formdan gelen verileri al
$blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
$author = isset($_POST['author']) ? trim($_POST['author']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
$date = date('Y-m-d H:i:s');

// Kullanıcı kimliğini al
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 1;

$message = "New comment added to blog ID $blog_id by $author";
$query = "INSERT INTO notifications (user_id, type, message) VALUES (?, 'blog_comment', ?)";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 'is', $user_id, $message);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($blog_id > 0 && $author && $email && $comment) {
    // Yorumları veritabanına ekle
    $stmt = $connection->prepare("INSERT INTO comments (blog_id, author, email, subject, comment, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssss', $blog_id, $author, $email, $subject, $comment, $date);
    $stmt->execute();
    $stmt->close();
}

// Yorum eklendikten sonra blog detay sayfasına yönlendir
header("Location: ../src/blog-details.php?id=" . $blog_id);
exit;
?>
<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Formdan gelen verileri al
    $blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
    $author = isset($_POST['author']) ? trim($_POST['author']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $date = date('Y-m-d H:i:s');

    if ($blog_id > 0 && $author && $email && $comment) {
        // Yorumları veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO comments (blog_id, author, email, subject, comment, date) VALUES (:blog_id, :author, :email, :subject, :comment, :date)");
        $stmt->bindParam(':blog_id', $blog_id, PDO::PARAM_INT);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Yorum eklendikten sonra blog detay sayfasına yönlendir
    header("Location: ../src/blog-details.php?id=" . $blog_id);
    exit;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
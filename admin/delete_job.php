<?php
include '../libs/vars.php';
include 'admin_check.php';

// Veritabanı bağlantısı için gerekli bilgileri ekleyin
include '../libs/database.php';

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // İş ilanı id'sini al
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // İş ilanıyla ilişkili başvuruları sil
        $stmt = $conn->prepare("DELETE FROM job_applications WHERE job_id = :job_id");
        $stmt->bindParam(':job_id', $id);
        $stmt->execute();

        // İş ilanını veritabanından sil
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // İş ilanı başarıyla silindiyse, kullanıcıyı iş listesine yönlendir
        header("Location: jobs_list.php");
        exit();
    } else {
        // Eğer id belirtilmemişse, kullanıcıyı iş listesine yönlendir
        header("Location: jobs_list.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
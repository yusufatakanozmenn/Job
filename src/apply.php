<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "jobs";

$connection = mysqli_connect($server, $username, $password, $database);
mysqli_set_charset($connection, "UTF8");
if (mysqli_connect_errno() > 0) {
    die("error: " . mysqli_connect_errno());
}

// Formdan gelen verileri al
$job_id = $_POST['job_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$cover_letter = $_POST['cover_letter'];
$resume = $_FILES['resume'];

// Özgeçmişi yüklemek için hedef dizin
$target_dir = "../admin/uploads/";
$target_file = $target_dir . basename($resume["name"]);
move_uploaded_file($resume["tmp_name"], $target_file);

// Başvuru tarihini al
$application_date = date("Y-m-d H:i:s");

// Veritabanına başvuruyu kaydet
$query = "INSERT INTO job_applications (job_id, name, email, phone, cover_letter, resume, application_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("issssss", $job_id, $name, $email, $phone, $cover_letter, $target_file, $application_date);

if ($stmt->execute()) {
    echo "<script>alert('Başvurunuz başarıyla alındı!'); window.location.href = 'jobs.php';</script>";
} else {
    echo "<script>alert('Başvuru sırasında bir hata oluştu.'); window.location.href = 'job_details.php?id=$job_id';</script>";
}

$stmt->close();
$connection->close();
?>
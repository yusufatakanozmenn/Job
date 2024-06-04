<?php
include '../libs/vars.php';
include '../libs/database.php';
include '../libs/language.php';
$connection = mysqli_connect($server, $username, $password, $database);
mysqli_set_charset($connection, "UTF8");
if (mysqli_connect_errno()) {
    die("error: " . mysqli_connect_error());
}

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = 1;
}

$message = "New job application received from User ID $user_id";
$query = "INSERT INTO notifications (user_id, type, message) VALUES (?, 'job_application', ?)";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 'is', $user_id, $message);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$job_id = $_POST['job_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$cover_letter = $_POST['cover_letter'];
$resume = $_FILES['resume'];

$target_dir = "../admin/uploads/";

$file_info = pathinfo($resume["name"]);
$hashed_filename = hash('sha256', basename($resume["name"])) . '.' . $file_info['extension'];

$target_file = $target_dir . $hashed_filename;
move_uploaded_file($resume["tmp_name"], $target_file);

$application_date = date("Y-m-d H:i:s");

$query = "INSERT INTO job_applications (job_id, name, email, phone, cover_letter, resume, application_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($query);

if ($stmt) {
    $stmt->bind_param('issssss', $job_id, $name, $email, $phone, $cover_letter, $hashed_filename, $application_date);
    if ($stmt->execute()) {
        // Redirect on success
        header("Location: jobs.php");
        exit;
    } else {
        // Error executing statement
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Error preparing statement
    echo "Error preparing query: " . $connection->error;
}

$connection->close();
?>
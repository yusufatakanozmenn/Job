<?php

include '../libs/ayar.php'; // Include file with database connection details


$connection = mysqli_connect($server, $username, $password, $database);
mysqli_set_charset($connection, "UTF8");

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user_id is set in cookie, default to 1 if not set
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 1;

// Prepare notification message
$message = "New job application received from User ID $user_id";

// Insert notification into notifications table
$query = "INSERT INTO notifications (user_id, type, message) VALUES (?, 'job_application', ?)";
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'is', $user_id, $message);
    if (!mysqli_stmt_execute($stmt)) {
        die("Notification insert failed: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die("Notification prepare statement failed: " . mysqli_error($connection));
}

// Process job application data
$job_id = $_POST['job_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$cover_letter = $_POST['cover_letter'];
$resume = $_FILES['resume'];

// File upload handling
$target_dir = "../admin/uploads/";
$file_info = pathinfo($resume["name"]);
$hashed_filename = hash('sha256', basename($resume["name"])) . '.' . $file_info['extension'];
$target_file = $target_dir . $hashed_filename;

if (!move_uploaded_file($resume["tmp_name"], $target_file)) {
    die("File upload failed: " . $_FILES['resume']['error']);
}

$application_date = date("Y-m-d H:i:s");

// Insert job application into job_applications table
$query = "INSERT INTO job_applications (job_id, name, email, phone, cover_letter, resume, application_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($query);

if ($stmt) {
    $stmt->bind_param('issssss', $job_id, $name, $email, $phone, $cover_letter, $hashed_filename, $application_date);
    if ($stmt->execute()) {
        // Redirect on success to prevent form resubmission
        header("Location: jobs.php");
        exit;
    } else {
        // Error executing statement
        die("Job application insert failed: " . $stmt->error);
    }
    $stmt->close();
} else {
    // Error preparing statement
    die("Job application prepare statement failed: " . $connection->error);
}

$connection->close();

?>
<?php
include '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $notificationId = $_POST['id'];

    // Bildirimi "okundu" olarak işaretle
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $notificationId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Notification marked as read";
} else {
    echo "Invalid request";
}
?>
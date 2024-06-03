<?php
include '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notificationId = $_POST['id'];

    // Update the notification status
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $notificationId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update notification status']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($connection);
?>
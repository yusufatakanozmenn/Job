<?php
require_once '../libs/ayar.php';

header('Content-Type: application/json');

$query = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($connection, $query);
$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($notifications);
?>
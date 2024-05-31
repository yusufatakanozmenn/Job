<?php
require_once '../libs/ayar.php';
include '../libs/vars.php';
include 'admin_check.php';


// Oturumdaki kullanıcı adını al
$username = $_SESSION['username'];

// Kullanıcı ID'sini veritabanından çekme
$stmt = $connection->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

$stmt->close();

// Blog gönderisini ID ile al
$post_id = $_GET['id'];
$stmt = $connection->prepare("DELETE FROM blog_posts WHERE id = ? AND author_id = ?");
$stmt->bind_param('ii', $post_id, $user_id);

if ($stmt->execute()) {
    header('Location: blog_list.php');
    exit;
} else {
    echo "Blog gönderisi silinirken bir hata oluştu.";
}

$stmt->close();
?>
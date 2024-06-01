<?php
require_once '../libs/ayar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Contact mesajını kaydetme
    $stmt = $connection->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, $message);
    $stmt->execute();
    $contact_message_id = $stmt->insert_id;
    $stmt->close();

    // Bildirimi kaydetme
    $notification_message = "New contact message from $name";
    $stmt = $connection->prepare("INSERT INTO notifications (user_id, type, message) VALUES (?, 'contact_message', ?)");
    $user_id = 0; // Sistem mesajları için kullanıcı ID'si 0 olabilir.
    $stmt->bind_param('is', $user_id, $notification_message);
    $stmt->execute();
    $stmt->close();

    header('Location: ../src/contact.php');
    exit;
}
?>
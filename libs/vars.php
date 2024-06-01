<?php

// Oturum başlatılmamışsa başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı giriş yapmamışsa veya oturumu başlatmamışsa veya oturumu yoksa

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Kullanıcıyı giriş sayfasına yönlendir
    header("Location: ../admin/login.php");
    exit;

}

?>
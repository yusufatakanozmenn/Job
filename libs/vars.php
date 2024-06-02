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
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en'; // Varsayılan dil
}

if (isset($_GET['lang'])) {
    $_SESSION['language'] = $_GET['lang'];
}

include 'lang_' . $_SESSION['language'] . '.php';
?>
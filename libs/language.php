<?php

// Oturum başlatılmamışsa başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Varsayılan dil ayarı
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en'; // Varsayılan dil
}

// URL parametresinde dil seçimi varsa oturumda güncelle
if (isset($_GET['lang'])) {
    $_SESSION['language'] = $_GET['lang'];
}

// Dil dosyasının yolu
$langFile = '../admin/lang_' . $_SESSION['language'] . '.php';

// Dil dosyasının varlığını kontrol et ve dahil et
if (file_exists($langFile)) {
    require $langFile;
} else {
    // Dil dosyası bulunamazsa varsayılan dile geç
    $_SESSION['language'] = 'en';
    require '../admin/lang_en.php';
}
?>
<?php
//sesion kontrol admin ise göster

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'IK') {
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
} else {
// Yetkisiz giriş varsa login sayfasına yönlendir
header("Location: login.php");
exit;
}
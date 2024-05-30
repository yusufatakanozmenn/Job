<?php

session_start();
// Kullanıcı oturumu kontrolü
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
<?php
include '../libs/vars.php';

if (isset($_POST['language'])) {
    $language = $_POST['language'];
    $_SESSION['language'] = $language;
}
?>
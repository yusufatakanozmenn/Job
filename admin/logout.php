<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the cookies by setting their expiration time to the past
if (isset($_COOKIE['auth'])) {
    setcookie("auth[username]", "", time() - 3600, "/");
    setcookie("auth[role]", "", time() - 3600, "/");
}

// Redirect to login page
header("Location: ../src/index.php");
exit;

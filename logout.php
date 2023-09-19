<?php

// Initialize the session
session_unset();

// Destroy the session.
session_destroy();

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

// Unset all of the session variables
$_SESSION = array();

// Redirect to login page
header("location: login.php");
exit;
?>
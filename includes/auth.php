<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to sign-in page
    header("Location: signin.php");
    exit;
}
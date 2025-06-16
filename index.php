<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // User logged in, redirect to dashboard
    header('Location: dashboard.php');
    exit;
} else {
    // Not logged in, redirect to signin page
    header('Location: signin.php');
    exit;
}
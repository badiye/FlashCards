<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Flashcard App</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
<div class="container">
    <a class="navbar-brand" href="dashboard.php">Flashcard App</a>
    <div class="ms-auto">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    <?php else: ?>
        <a href="signin.php" class="btn btn-outline-primary btn-sm">Sign In</a>
    <?php endif; ?>
    </div>
</div>
</nav>
<div class="container mt-4">
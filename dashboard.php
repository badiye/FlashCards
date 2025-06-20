<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            min-height: 250px;
            font-size: 1.1rem;
        }
        .card h4 {
            font-size: 1.8rem;
        }
        .card p {
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Flashcard App</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span>Welcome, <?= htmlspecialchars($userName) ?></span>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container text-center mt-5">
    <h2>Welcome back, <?= htmlspecialchars($userName) ?>!</h2>
    <p class="lead">What would you like to do today?</p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6 mb-4">
            <div class="card p-5 shadow-sm">
                <h4>📚 Review Flashcards</h4>
                <p>Practice questions you've already added.</p>
                <a href="categories.php" class="btn btn-primary w-100">Go to Review</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-5 shadow-sm">
                <h4>✏️ Create Flashcards</h4>
                <p>Add new categories and questions.</p>
                <a href="create.php" class="btn btn-success w-100">Add Flashcards</a>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
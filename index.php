<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Flashcard App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-img {
            max-width: 100%;
            height: 400px;
        }
        .feature-icon {
            font-size: 2rem;
        }
    </style>
</head>
<body class="bg-light">

<?php include 'includes/header.php'; ?>

<div class="container text-center mt-5">
    <h1 class="display-4 fw-bold">Welcome to Flashcard App</h1>
    <p class="lead mb-4">Boost your memory, study smarter, and track your progress — all in one place.</p>

    <img src="img\wulan-sari-CVJE0kNLszk-unsplash.jpg" alt="Study illustration" class="hero-img rounded shadow-sm mb-4">

    <?php if (!$isLoggedIn): ?>
        <div class="mt-3">
            <a href="signup.php" class="btn btn-success btn-lg me-2">Get Started</a>
        </div>
    <?php else: ?>
        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Why You'll Love It</h2>
    <div class="row text-center">
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow-sm h-100">
                <div class="feature-icon mb-3 text-primary">📚</div>
                <h5>Custom Flashcards</h5>
                <p>Create your own questions and answers to study what matters most to you.</p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow-sm h-100">
                <div class="feature-icon mb-3 text-success">⏱️</div>
                <h5>Efficient Learning</h5>
                <p>Flip through flashcards quickly and focus on mastering each topic.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
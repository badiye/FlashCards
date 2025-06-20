<?php
session_start();
require 'includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Please enter both email and password.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct - log user in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];

            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sign In</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <a href="index.php" class="btn btn-btn-primary mb-3">← Back to Home</a>
    <div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="text-center mb-4">Flashcard App - Sign In</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?=htmlspecialchars($error)?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="border p-4 rounded bg-white shadow-sm">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required
                />
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
        <p class="text-center mt-3">
        Don't have an account? <a href="signup.php">Sign up here</a>
        </p>
    </div>
    </div>
</div>
</body>
</html>
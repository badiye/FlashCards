<?php
require 'includes/auth.php';
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die("User not authenticated.");
}

$categoryId = $_POST['category_id'] ?? null;
$newCategory = trim($_POST['new_category'] ?? '');
$questionText = trim($_POST['question'] ?? '');
$answerText = trim($_POST['answer'] ?? '');

// Validate question and answer
if ($questionText === '' || $answerText === '') {
    die("Please fill out both question and answer.");
}

// Determine category ID to use
if ($newCategory !== '') {
    // Check if category already exists
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->execute([$newCategory]);
    $existingCategory = $stmt->fetch();

    if ($existingCategory) {
        $categoryId = $existingCategory['id'];
    } else {
        // Insert new category and get ID
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$newCategory]);
        $categoryId = $pdo->lastInsertId();
    }
} else {
    // No new category entered
    // Make sure existing category is selected
    if (empty($categoryId)) {
        die("Please select an existing category or enter a new one.");
    }
    // Optionally validate that category_id exists in DB
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    if (!$stmt->fetch()) {
        die("Selected category does not exist.");
    }
}

// Insert question
$stmt = $pdo->prepare("INSERT INTO questions (question_text, category_id, user_id) VALUES (?, ?, ?)");
$stmt->execute([$questionText, $categoryId, $userId]);
$questionId = $pdo->lastInsertId();

// Insert answer
$stmt = $pdo->prepare("INSERT INTO answers (question_id, answer_text) VALUES (?, ?)");
$stmt->execute([$questionId, $answerText]);
$answerId = $pdo->lastInsertId();

// Insert flashcard
$stmt = $pdo->prepare("INSERT INTO flashcards (user_id, category_id, question_id, answer_id) VALUES (?, ?, ?, ?)");
$stmt->execute([$userId, $categoryId, $questionId, $answerId]);

header("Location: categories.php?msg=Flashcard+added+successfully");
exit;
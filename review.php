<?php
require 'includes/auth.php';
require 'includes/header.php';
require 'includes/db.php';


$userId = $_SESSION['user_id'];
$categoryId = $_GET['category_id'] ?? null;

if (!$categoryId) {
    die("Category not specified.");
}

// Fetch category name
$stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->execute([$categoryId]);
$category = $stmt->fetch();

if (!$category) {
    die("Category not found.");
}

// Fetch flashcards for this user and category
$stmt = $pdo->prepare("
    SELECT q.id AS question_id, q.question_text, a.answer_text 
    FROM flashcards f
    JOIN questions q ON f.question_id = q.id
    JOIN answers a ON f.answer_id = a.id
    WHERE f.user_id = ? AND f.category_id = ?
");
$stmt->execute([$userId, $categoryId]);
$flashcards = $stmt->fetchAll();
?>

<a href="categories.php" class="btn btn-secondary mb-3">← Back to Categories</a>

<h2 class="text-center mb-4">Review: <?= htmlspecialchars($category['name']) ?></h2>

<?php if (count($flashcards) === 0): ?>
    <p class="text-center">No flashcards in this category yet. <a href="create.php">Add some!</a></p>
<?php else: ?>

<div class="d-flex flex-column align-items-center">

    <div id="flashcard" class="flip-card" style="width: 350px; height: 200px; cursor: pointer;">
        <div class="flip-card-inner">
            <div class="flip-card-front d-flex align-items-center justify-content-center p-3 border rounded bg-white shadow-sm">
                <p id="question" class="mb-0"></p>
            </div>
            <div class="flip-card-back d-flex align-items-center justify-content-center p-3 border rounded bg-primary text-white shadow-sm">
                <p id="answer" class="mb-0"></p>
            </div>
        </div>
    </div>

    <button id="nextBtn" class="btn btn-primary mt-3">Next</button>

    <p class="mt-2" id="progress"></p>
</div>

<script>
const flashcards = <?= json_encode($flashcards, JSON_HEX_TAG) ?>;
let currentIndex = 0;
let flipped = false;

const flashcardInner = document.querySelector('.flip-card-inner');
const questionEl = document.getElementById('question');
const answerEl = document.getElementById('answer');
const progressEl = document.getElementById('progress');
const nextBtn = document.getElementById('nextBtn');

function showFlashcard(index) {
    const card = flashcards[index];
    questionEl.textContent = card.question_text;
    answerEl.textContent = card.answer_text;
    progressEl.textContent = `Card ${index + 1} of ${flashcards.length}`;
    if (flipped) {
        flipCard(false);
    }
}

function flipCard(doFlip) {
    if (doFlip) {
        flashcardInner.style.transform = 'rotateY(180deg)';
        flipped = true;
    } else {
        flashcardInner.style.transform = 'rotateY(0deg)';
        flipped = false;
    }
}

// Initialize first card
showFlashcard(currentIndex);

// Flip on card click
document.getElementById('flashcard').addEventListener('click', () => {
    flipCard(!flipped);
});

// Next button shows next card
nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % flashcards.length;
    showFlashcard(currentIndex);
});
</script>

<style>
.flip-card {
background-color: transparent;
perspective: 1000px;
}

.flip-card-inner {
position: relative;
width: 100%;
height: 100%;
text-align: center;
transition: transform 0.6s;
transform-style: preserve-3d;
}

.flip-card-front, .flip-card-back {
position: absolute;
width: 100%;
height: 100%;
backface-visibility: hidden;
border-radius: 10px;
box-sizing: border-box;
}

.flip-card-back {
transform: rotateY(180deg);
}
</style>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>

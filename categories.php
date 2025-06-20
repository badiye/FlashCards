<?php
require 'includes/auth.php';
require 'includes/header.php';
require 'includes/db.php';

$userId = $_SESSION['user_id'];

// Get categories where this user has flashcards (join flashcards or questions)
$stmt = $pdo->prepare("
    SELECT DISTINCT c.id, c.name 
    FROM categories c
    JOIN flashcards f ON f.category_id = c.id
    WHERE f.user_id = ?
    ORDER BY c.name ASC
");
$stmt->execute([$userId]);
$categories = $stmt->fetchAll();
?>

<a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>


<h2 class="text-center mb-4">Your Categories</h2>

<div class="row justify-content-center">
<?php if (count($categories) > 0): ?>
    <?php foreach ($categories as $cat): ?>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-5">
        <h5 class="card-title text-center"><?= htmlspecialchars($cat['name']) ?></h5>
        <a href="review.php?category_id=<?= $cat['id'] ?>" class="btn btn-primary w-100">Review</a>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center">No flashcards yet. <a href="create.php">Create your first one!</a></p>
<?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
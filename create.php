<?php
require 'includes/auth.php';
require 'includes/header.php';
require 'includes/db.php';

$stmt = $pdo->prepare("SELECT id, name FROM categories ORDER BY name ASC");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<h2 class="text-center mb-4">Add New Flashcard</h2>

<form action="save_flashcard.php" method="POST" class="mx-auto" style="max-width: 600px;">
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category_id" id="category" class="form-control">
            <option value="">Select existing category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Or enter a new category below:</small>
        <input type="text" name="new_category" class="form-control mt-1" placeholder="New category name">
    </div>

    <div class="mb-3">
        <label for="question" class="form-label">Question</label>
        <textarea name="question" id="question" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="answer" class="form-label">Answer</label>
        <textarea name="answer" id="answer" class="form-control" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-success w-100">Save Flashcard</button>
</form>

<?php include 'includes/footer.php'; ?>

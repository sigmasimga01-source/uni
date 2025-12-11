<?php
require_once '../app.php';
$post = $postController->getPost($_GET['id'] ?? null);

if (!$post) {
    header("Location: posts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
$name = "Post - " . $post['title'];
include 'partials/header.php';
?>

<body>
  <?php include 'partials/navbar.php'; ?>
  <main>
    <div class="single-post-container">
        <a href="posts.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Posts
        </a>
        
        <article class="post-detail">
            <header class="post-header">
                <h1><?= htmlspecialchars($post['title']) ?></h1>
                <div class="post-meta">
                    <span class="author">
                        <i class="fas fa-user"></i> @<?= htmlspecialchars($post['username']) ?>
                    </span>
                    <span class="date">
                        <i class="far fa-calendar-alt"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?>
                    </span>
                </div>
            </header>
            
            <div class="post-content">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>
        </article>
    </div>
  </main>
</body>

</html>
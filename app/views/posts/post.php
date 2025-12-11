<?php
require_once '../../app.php';
$post = $postController->getPost($_GET['id'] ?? null);

if (!$post) {
    header("Location: posts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
$name = "Post - " . $post->getTitle();
include '../_partials/header.php';
?>

<body>
  <?php include '../_partials/navbar.php'; ?>
  <main>
    <div class="single-post-container">
        <a href="posts.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Posts
        </a>
        
        <article class="post-detail">
            <header class="post-header">
                <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
                <div class="post-meta">
                    <span class="author">
                        <i class="fas fa-user"></i> @<?= htmlspecialchars($post->getOwner()) ?>
                    </span>
                    <span class="date">
                        <i class="far fa-calendar-alt"></i> <?= date('F j, Y', strtotime($post->getCreatedAt())) ?>
                    </span>
                </div>
            </header>
            
            <div class="post-content">
                <?= nl2br(htmlspecialchars($post->getContent())) ?>
            </div>
        </article>
    </div>
  </main>
</body>

</html>
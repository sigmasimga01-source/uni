<?php
require_once '../controllers/PostController.php';

$controller = new PostController();
$controller->handleRequest();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>

    <main>
        <h1>Community Posts</h1>

        <?php if (!empty($controller->message)): ?>
            <p class="message"><?= htmlspecialchars($controller->message) ?></p>
        <?php endif; ?>

        <!-- Post Creation Form -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="create-post">
                <h2>Create a New Post</h2>
                <form action="" method="post">
                    <input type="text" name="title" placeholder="Post Title" required>
                    <textarea name="content" placeholder="What's on your mind?" required></textarea>
                    <button type="submit" name="create_post">Publish</button>
                </form>
            </div>
        <?php else: ?>
            <p><a href="login.php">Log in</a> to create a post.</p>
        <?php endif; ?>

        <!-- Posts List -->
        <div class="posts-list">
            <?php foreach ($controller->posts as $post): ?>
                <div class="post">
                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <small>Posted by @<?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>

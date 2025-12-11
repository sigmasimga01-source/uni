<?php
require_once '../app.php';

$postController->handleRequest();
?>

<!DOCTYPE html>
<html lang="en">
<?php 
$name = "Create Post";
include 'partials/header.php'; 
?>
<body>
    <?php include 'partials/navbar.php'; ?>

    <main>
        <h1>Create a New Post</h1>

        <?php if (!empty($postController->message)): ?>
            <div class="message <?= strpos($postController->message, 'success') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($postController->message) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <form action="" method="post">
                <input type="text" name="title" placeholder="Post Title" required>
                <textarea name="content" placeholder="What's on your mind?" required></textarea>
                <button type="submit" name="create_post">Publish</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Log in</a> to create a post.</p>
        <?php endif; ?>
    </main>
</body>
</html>

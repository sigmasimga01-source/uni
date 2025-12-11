<?php
require_once '../app.php';

$postController->getPosts();
?>

<!DOCTYPE html>
<html lang="en">
<?php
$name = "Posts";
include 'partials/header.php';
?>

<body>
  <?php include 'partials/navbar.php'; ?>

  <main>
    <h1>Community Posts</h1>

    <?php if (!empty($postController->message)): ?>
      <p class="message"><?= $postController->message ?></p>
    <?php endif; ?>

    <!-- Posts List -->
    <div class="posts-list">
      <?php if (!empty($postController->posts)): ?>
        <?php foreach ($postController->posts as $post): ?>
          <a href="post.php?id=<?= ($post['post_id']) ?>">

            <div class="post">
              <h3><?= $post['title'] ?></h3>
              <p><?= $post['content'] ?></p>
              <small>Posted by @<?= $post['username'] ?> on <?= $post['created_at'] ?></small>
            </div>
          </a>
        <?php endforeach; ?>
      <?php elseif (empty($postController->message)): ?>
        <p>No posts found.</p>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>
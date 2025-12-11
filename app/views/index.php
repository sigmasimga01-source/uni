<!DOCTYPE html>
<html lang="en">
<?php
$name = "Home";
include 'partials/header.php';
?>

<body>
  <?php include 'partials/navbar.php'; ?>

  <main>
    <section class="hero">
      <h1>Welcome to X</h1>
      <p>The best place to share your thoughts and connect with others. Join our community today!</p>

      <div class="hero-actions">
        <a href="posts.php" class="btn">View Posts</a>
        <?php if (!isset($_SESSION['logged_in'])): ?>
          <a href="register.php" class="btn btn-secondary">Get Started</a>
        <?php else: ?>
          <a href="create_post.php" class="btn btn-secondary">Create Post</a>
        <?php endif; ?>
      </div>
    </section>

    <section class="features">
      <div class="feature-card">
        <h3>Share Your Story</h3>
        <p>Create posts and share your experiences with the community. Your voice matters here.</p>
      </div>
      <div class="feature-card">
        <h3>Connect with Others</h3>
        <p>Read what others are saying and engage in meaningful conversations.</p>
      </div>
      <div class="feature-card">
        <h3>Secure & Private</h3>
        <p>Your data is safe with us. We prioritize your privacy and security above all else.</p>
      </div>
    </section>
  </main>
</body>

</html>
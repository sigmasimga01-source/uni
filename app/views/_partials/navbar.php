<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<nav>
    <a href="index.php">Home</a>
    <?php if (!$isLoggedIn): ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php else: ?>
        <a href="profile.php">Profile</a>
        <a href="posts.php">Posts</a>
        <a href="create_post.php">Create Post</a>
        <a href="login.php?action=logout">Logout</a>
    <?php endif; ?>
</nav>
  <nav>
    <?php if ($auth->isUserLoggedIn()): ?>
      <a href="secret.php">Secret</a>
      <a href="profile.php">Profile</a>
      <a href="login.php?action=logout">Logout</a>
    <?php else: ?>
      <a href="index.php">Register</a>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
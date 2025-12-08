<?php

require_once '../controllers/AuthController.php';

$controller = new AuthController();

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $controller->logout();
}

// Handle login
$controller->login();

// Check if user is logged in
$isLoggedIn = $controller->isUserLoggedIn();
$userData = $controller->getUserData();

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styless.css">
</head>

<body>
  <nav>
    <a href="index.php">Register</a>
    <a href="login.php">Login</a>
  </nav>
  <main>
    <?php if (!empty($controller->message)): ?>
      <p><?= $controller->message ?></p>
    <?php endif; ?>

    <?php if (!$isLoggedIn): ?>
      <form action="" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">Login</button>
      </form>
    <?php else: ?>
      <div class="profile-card">
        <h2>Welcome, <?= $userData['username'] ?></h2>

        <div class="info">
          <div><strong>Name:</strong> <?= $userData['name'] ?></div>
          <div><strong>Last Name:</strong> <?= $userData['lastname'] ?></div>
          <div><strong>Username:</strong> @<?= $userData['username'] ?></div>
          <div><strong>Phone:</strong> <?= $userData['tel'] ?></div>
        </div>

        <a class="logout-btn" href="login.php?action=logout">Logout</a>
      </div>
    <?php endif; ?>

  </main>
</body>

</html>
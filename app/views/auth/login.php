<?php

require_once '../../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  if ($auth->login()) {
    header('Location: ../user/profile.php');
    exit();
  } else {
    header('Location: login');
    exit();
  }
}

$isLoggedIn = $auth->isLoggedIn();

if ($isLoggedIn) {
  header('Location: ../user/profile.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Login";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <?php
    $response = $auth->getResponse();
    if (!empty($response)):
    ?>
      <div class="response <?= strpos($response, 'successful') !== false ? 'success' : 'error' ?>">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <h2>Login</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <p style="text-align: center; margin-top: 15px;">
        Don't have an account? <a href="register.php">Register</a>
      </p>
    </form>
  </main>
</body>

</html>
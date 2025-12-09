<?php

require_once '../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
}

$auth->login();

$isLoggedIn = $auth->isLoggedIn();

if ($isLoggedIn) {
  header('Location: profile.php');
  exit();
}

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
  <?php include_once './partials/navbar.php'; ?>
  <main>
    <p style="color: red;"><?= $auth->getMessage() ?></p>

    <form action="" method="post">
      <input type="text" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="login">Login</button>
    </form>
  </main>
</body>

</html>
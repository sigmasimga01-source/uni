<?php

require_once '../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
  header('Location: login.php');
  exit();
}

$isLoggedIn = $auth->isLoggedIn();
if (!$isLoggedIn) {
  header('Location: login.php');
  exit();
}
$userData = $auth->getUserData();
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
  <p style="color: green; text-align: center;"><?= $auth->getMessage() ?></p>
  <div class="profile-card">
    <h2>Welcome, <?= $userData['username'] ?></h2>
    <div class="info">
      <div><strong>Name:</strong> <?= $userData['name'] ?></div>
      <div><strong>Last Name:</strong> <?= $userData['lastname'] ?></div>
      <div><strong>Username:</strong> @<?= $userData['username'] ?></div>
      <div><strong>Phone:</strong> <?= $userData['tel'] ?></div>
    </div>

  </div>
</body>

</html>
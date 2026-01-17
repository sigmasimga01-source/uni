<?php

require_once '../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
  $auth->register();
}

$isLoggedIn = $auth->isLoggedIn();

if ($isLoggedIn) {
  header('Location: ../user/profile.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Register";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <?php
    $response = $auth->getResponse();
    if (!empty($response)):
    ?>
      <div class="response error">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <h2>Register</h2>
      <input type="text" name="name" placeholder="First Name" required>
      <input type="text" name="lastname" placeholder="Last Name" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="register">Register</button>
      <p style="text-align: center; margin-top: 15px;">
        Already have an account? <a href="login.php">Login</a>
      </p>
    </form>
  </main>
</body>

</html>
<?php

require_once '../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
  $auth->register();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title="Register"; include_once '../_partials/header.php'; ?>

<body>

  <?php 
    $response = $auth->getMessage();
    if (!empty($response)) echo "<p>" . $response . "</p>";
  ?>

  <?php include_once '../_partials/navbar.php'; ?>

  <form action="" method="post">
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="lastname" placeholder="Lastname">
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="tel" placeholder="Telephone">
    <input type="password" name="password" placeholder="password" required>
    <button type="submit" name="register">Register</button>
  </form>

</body>

</html>
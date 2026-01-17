<?php

require_once '../app.php';

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Welcome to ShopCart";
include_once './_partials/header.php'; ?>

<body>
  <?php include_once './_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">Welcome to Shop</h1>

    <?php if ($auth->isLoggedIn()): ?>
      <p>Hello, <strong><?= $auth->getUser()->getName() ?></strong>! Ready to shop?</p>
      <br>
      <a href="items/shop.php" class="btn btn-primary">Browse Products</a>
      <a href="cart/cart.php" class="btn btn-success">View Cart</a>
    <?php else: ?>
      <p>login or register to start shopping.</p>
      <br>
      <a href="auth/login.php" class="btn btn-primary">Login</a>
      <a href="auth/register.php" class="btn btn-success">Register</a>
    <?php endif; ?>
  </main>
</body>

</html>
<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login');
  exit();
}

$user_id = $auth->getUserId();
$userOrders = $orders->getOrders($user_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "My Orders";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">My Orders</h1>

    <?php
    $response = $orders->getResponse();
    if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <?php if (empty($userOrders)): ?>
      <div class="cart-container">
        <div class="cart-empty">
          <h3>No orders yet</h3>
          <br>
          <a href="../items/shop" class="btn btn-primary">Start Shopping</a>
        </div>
      </div>
    <?php else: ?>
      <div class="orders-list">
        <?php foreach ($userOrders as $order): ?>
          <div class="order-item">
            <div>
              <span class="order-id">Order #<?= $order->getOrderId() ?></span>
              <br>
              <small style="color: gray;"><?= $order->getCreatedAt() ?></small>
            </div>
            <div>
              <strong style="font-size: 1.2rem; color: green;">$<?= $order->getTotal() ?></strong>
            </div>
            <div>
              <span class="order-status <?= $order->getStatus() ?>"><?= $order->getStatus() ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <br>
      <a href="../items/shop" class="btn btn-primary">Continue Shopping</a>
    <?php endif; ?>
  </main>
</body>

</html>
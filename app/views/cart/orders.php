<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login.php');
  exit();
}

$user_id = $auth->getUserId();
$orders = $cart->getOrders($user_id);

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
    $response = $cart->getResponse();
    if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
      <div class="cart-container">
        <div class="cart-empty">
          <h3>No orders yet</h3>
          <br>
          <a href="../items/shop.php" class="btn btn-primary">Start Shopping</a>
        </div>
      </div>
    <?php else: ?>
      <div class="orders-list">
        <?php foreach ($orders as $order): ?>
          <div class="order-item">
            <div>
              <span class="order-id">Order #<?= $order['order_id'] ?></span>
              <br>
              <small style="color: #7f8c8d;"><?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></small>
            </div>
            <div>
              <strong style="font-size: 1.2rem; color: #27ae60;">$<?= number_format($order['total'], 2) ?></strong>
            </div>
            <div>
              <span class="order-status <?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <br>
      <a href="../items/shop.php" class="btn btn-primary">Continue Shopping</a>
    <?php endif; ?>
  </main>
</body>

</html>
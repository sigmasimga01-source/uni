<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login.php');
  exit();
}

$user = $auth->getUser();
if ($user->getEmail() !== 'admin@gmail.com') {
  header('Location: ../items/shop.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];

  if (in_array($status, ['pending', 'completed', 'cancelled'])) {
    $cart->updateOrderStatus($order_id, $status);
  }
  header('Location: orders.php');
  exit();
}

$allOrders = $cart->getAllOrders();

$pendingCount = count(array_filter($allOrders, fn($order) => $order['status'] === 'pending'));
$completedCount = count(array_filter($allOrders, fn($order) => $order['status'] === 'completed'));
$cancelledCount = count(array_filter($allOrders, fn($order) => $order['status'] === 'cancelled'));

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Manage Orders";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">Admin Panel</h1>

    <?php $a=2; include_once './_partials/tabs.php' ?>

    <?php
      $response = $cart->getResponse();
      if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <?php include_once './_partials/orders/order-stats.php' ?>

    <div class="admin-section">
      <h2>All Orders</h2>

      <?php if (empty($allOrders)): ?>
        <div class="cart-empty">
          <h3>No orders yet</h3>
        </div>
      <?php else: ?>
        <div class="orders-list">
          <?php foreach ($allOrders as $order): ?>
            <div class="order-item admin-order">
              <div class="order-details">
                <span class="order-id">Order #<?= $order['order_id'] ?></span>
                <br>
                <small style="color: gray;">
                  <?= $order['created_at'] ?>
                </small>
                <br>
                <small style="color: blue;">
                  Customer: <?= $order['username'] ?> (<?= $order['email'] ?>)
                </small>
              </div>
              <div>
                <strong style="font-size: 1.2rem; color: green;">
                  $<?= number_format($order['total'], 2) ?>
                </strong>
              </div>
              <div>
                <span class="order-status <?= $order['status'] ?>">
                  <?= ucfirst($order['status']) ?>
                </span>
              </div>
              <div>
                <form method="POST" class="status-form">
                  <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                  <select name="status" class="status-select">
                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                  </select>
                  <button type="submit" name="update_status" class="btn btn-primary btn-small">Update</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>
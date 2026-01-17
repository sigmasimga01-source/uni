<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login');
  exit();
}

$user = $auth->getUser();
if ($user->getRole() !== 'admin') {
  header('Location: ../notfound');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];

  if ($status) {
    $orders->updateOrderStatus($order_id, $status);
  }
  header('Location: orders');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
  $order_id = $_POST['order_id'];

  if ($order_id) {
    $orders->deleteOrder($order_id);
  }
  header('Location: orders');
  exit();
}

$allOrders = $orders->getAllOrders();

$pendingCount = count(array_filter($allOrders, fn($order) => $order->getStatus() === 'pending'));
$completedCount = count(array_filter($allOrders, fn($order) => $order->getStatus() === 'completed'));
$cancelledCount = count(array_filter($allOrders, fn($order) => $order->getStatus() === 'cancelled'));

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
      $response = $orders->getResponse();
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
                <span class="order-id">Order #<?= $order->getOrderId() ?></span>
                <br>
                <small style="color: gray;">
                  <?= $order->getCreatedAt() ?>
                </small>
                <br>
                <small style="color: blue;">
                  Customer: <?= $order->getUsername() ?> (<?= $order->getEmail() ?>)
                </small>
              </div>
              <div>
                <strong style="font-size: 1.2rem; color: green;">
                  $<?= number_format($order->getTotal(), 2) ?>
                </strong>
              </div>
              <div>
                <span class="order-status <?= $order->getStatus() ?>">
                  <?= ucfirst($order->getStatus()) ?>
                </span>
              </div>
              <div>
                <form method="POST" class="status-form">
                  <input type="hidden" name="order_id" value="<?= $order->getOrderId() ?>">
                  <select name="status" class="status-select">
                    <option value="pending" <?= $order->getStatus() === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= $order->getStatus() === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $order->getStatus() === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                  </select>
                  <button type="submit" name="update_status" class="btn btn-primary btn-small">Update</button>
                  <button type="submit" name="delete_order" class="btn btn-danger btn-small">Delete</button>
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
<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login.php');
  exit();
}

$user_id = $auth->getUserId();

// cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $cart->updateQuantity($item_id, $quantity);
    header('Location: cart');
    exit();
  }

  if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];
    $cart->removeFromCart($item_id);
    header('Location: cart');
    exit();
  }

  if (isset($_POST['clear_cart'])) {
    $cart->clearCart();
    header('Location: cart');
    exit();
  }

  if (isset($_POST['checkout'])) {
    $order_id = $orders->checkout($user_id);
    if ($order_id) {
      header('Location: orders');
      exit();
    }
  }
}

$cartItems = $cart->getCart();
$cartTotal = $cart->getCartTotal();

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Shopping Cart";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">Shopping Cart</h1>

    <?php
    $response = $cart->getResponse() ?: $orders->getResponse();
    if (!empty($response)):
    ?>
      <div class="response" style="background-color: orange;">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
      <div class="cart-container">
        <div class="cart-empty">
          <h1>CART EMPTY</h1>
          <br>
          <a href="../items/shop" class="btn btn-primary">Start Shopping</a>
        </div>
      </div>
    <?php else: ?>
      <div class="cart-container">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cartItems as $item): ?>
              <tr>
                <td>
                  <strong><?= $item->getItemName() ?></strong>
                </td>
                <td>$<?= $item->getItemPrice() ?></td>
                <td>
                  <form action="" method="post" class="quantity-control" style="display: inline-flex; padding: 0; box-shadow: none; margin: 0;">
                    <input type="hidden" name="item_id" value="<?= $item->getItemId() ?>">
                    <input type="number" name="quantity" style="margin-bottom: 0;" value="<?= $item->getQuantity() ?>" min="1" max=<?= $item->getItemStock() ?>>
                    <button type="submit" name="update_quantity" class="btn btn-small btn-primary">Update</button>
                  </form>
                </td>
                <td>$<?= $item->getItemPrice() * $item->getQuantity() ?></td>
                <td>
                  <form action="" method="post" style="display: inline; padding: 0; box-shadow: none; margin: 0;">
                    <input type="hidden" name="item_id" value="<?= $item->getItemId() ?>">
                    <button type="submit" name="remove_item" class="btn btn-small btn-danger">Remove</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <form action="" method="post" style="all: unset; display: inline-block;">
          <button type="submit" name="clear_cart" class="btn btn-danger" style="margin-bottom: 1rem; padding:0.3rem" onclick="return confirm('Are you sure you want to clear your cart?');">
            Clear Cart
          </button>
        </form>
        <div class="cart-total">
          <h3>Cart Total</h3>
          <div class="total-price">$<?= $cartTotal ?></div>
          <br>
          <form action="" method="post">
            <button type="submit" name="checkout" class="btn btn-success" style="margin-bottom: 1rem; padding:1rem; width: 20rem">Checkout</button>
            <a href="../items/shop" class="btn btn-primary">Continue Shopping</a>
          </form>
        </div>
      </div>
    <?php endif; ?>
  </main>
</body>

</html>
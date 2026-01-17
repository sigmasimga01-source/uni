<?php

require_once '../../app.php';

// add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
  if (!$auth->isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit();
  }

  $item_id = $_POST['item_id'];
  $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

  $cart->addToCart($item_id, $quantity);
  header('Location: shop.php');
  exit();
}

// get all items || search results
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
  $allItems = $items->searchItems($search);
} else {
  $allItems = $items->getAllItems();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Shop";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">Shop</h1>

    <?php
    $response = $cart->getResponse();
    if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <form action="" method="get" style="max-width: 100%; margin-bottom: 20px; display: flex; gap: 10px;">
      <input type="text" name="search" placeholder="Search products..." value="<?= $search ?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 0;">
      <button type="submit" style="flex:1;" class="btn btn-primary">Search</button>
      <?php if (!empty($search)): ?>
        <a href="shop.php" class="btn btn-danger" style="margin: 0;">Clear</a>
      <?php endif; ?>
    </form>

    <?php if (empty($allItems)): ?>
      <div class="cart-empty">
        <h3>Not found</h3>
      </div>
    <?php else: ?>
      <div class="products-grid">
        <?php foreach ($allItems as $item): ?>
          <div class="product-card">
            <div class="product-image">
              <?php if (!empty($item['image'])): ?>
                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
              <?php else: ?>
                📦
              <?php endif; ?>
            </div>
            <div class="product-info">
              <div class="product-name"><?= $item['name'] ?></div>
              <div class="product-description"><?= $item['description'] ?? '' ?></div>
              <div class="product-price">$<?= number_format($item['price'], 2) ?></div>
              <div class="product-stock">In stock: <?= $item['stock'] ?></div>

              <?php if ($auth->isLoggedIn()): ?>
                <form action="" method="post" class="product-add">
                  <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                  <input type="number" name="quantity" value="1" min="1" max="<?= $item['stock'] ?>" style="width: 60px; padding: 8px; margin: 0;">
                  <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
                </form>
              <?php else: ?>
                <a href="../auth/login.php" class="btn btn-primary">Login to Buy</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>

</html>
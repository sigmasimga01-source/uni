<?php
require_once __DIR__ . '/routes.php';

$base = "/uni/app/views/";
$isLoggedIn = $auth->isLoggedIn();
$cartCount = $cart->getCartCount();
$isAdmin = $isLoggedIn && $auth->getUser()->getRole() === 'admin';
?>

<nav>
  <a href="<?= $base ?>" class="nav-brand">🛒 ScamShop</a>
  <div>
    <?php foreach ($routes as $key => $route): ?>
      <?php
      if (isset($route['admin']) && $route['admin'] && !$isAdmin) continue;

      if (isset($route['auth'])) {
        if ($route['auth'] && !$isLoggedIn) continue;
        if (!$route['auth'] && $isLoggedIn) continue;
      }
      ?>
      <a href="<?= $base . $route['path'] ?>">
        <?= $route['label'] ?>
        <?php if ($key === 'cart' && $cartCount > 0): ?>
          <span class="cart-badge"><?= $cartCount ?></span>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>
</nav>
<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Item.php';

class CartService extends Dbh {

  public function __construct() {
    parent::__construct();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
  }

  public function add_to_cart($item_id, $quantity = 1) {
    if (isset($_SESSION['cart'][$item_id])) {
      $_SESSION['cart'][$item_id] += $quantity;
    } else {
      $_SESSION['cart'][$item_id] = $quantity;
    }
    return true;
  }

  public function get_cart() {
    $cart = [];

    if (empty($_SESSION['cart'])) {
      return $cart;
    }

    foreach ($_SESSION['cart'] as $item_id => $quantity) {
      $query = "SELECT item_id, name, description, price, stock, image FROM items WHERE item_id = ?";
      $stmt = $this->connection->prepare($query);
      $stmt->bind_param("i", $item_id);
      $stmt->execute();
      $result = $stmt->get_result();
      
      $row = $result->fetch_assoc();
      if ($row) {
        $item = new Item(
          $row['item_id'],
          $row['name'],
          $row['description'],
          $row['price'],
          $row['stock'],
          $row['image'] ?? null
        );
        $cart[] = new Cart($item, $quantity);
      }
      $stmt->close();
    }
    return $cart;
  }

  public function update_quantity($item_id, $quantity) {
    if ($quantity <= 0) {
      return $this->remove_from_cart($item_id);
    }
    $_SESSION['cart'][$item_id] = $quantity;
    return true;
  }

  public function remove_from_cart($item_id) {
    unset($_SESSION['cart'][$item_id]);
    return true;
  }

  public function clear_cart() {
    $_SESSION['cart'] = [];
    return true;
  }

  public function get_cart_total() {
    $cart = $this->get_cart();
    $total = 0;
    foreach ($cart as $cartItem) {
      $total += $cartItem->getItem()->getPrice() * $cartItem->getQuantity();
    }
    return $total;
  }

  public function get_cart_count() {
    $count = 0;
    foreach ($_SESSION['cart'] as $quantity) {
      $count += $quantity;
    }
    return $count;
  }
}

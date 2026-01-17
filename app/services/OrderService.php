<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Cart.php';

class OrderService extends Dbh {

  public function checkout($user_id, $cart) {
    if (empty($cart)) {
      return ['success' => false, 'error' => 'empty_cart'];
    }

    // calculate total
    $total = 0;
    foreach ($cart as $item) {
      $total += $item->getItemPrice() * $item->getQuantity();
    }

    // check user balance
    $query = "SELECT balance FROM users WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user['balance'] < $total) {
      return [
        'success' => false,
        'error' => 'low_balance',
        'balance' => $user['balance'],
        'total' => $total
      ];
    }

    // deduct balance
    $query = "UPDATE users SET balance = balance - ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("di", $total, $user_id);
    $stmt->execute();
    $stmt->close();

    // create order
    $query = "INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $this->connection->insert_id;
    $stmt->close();

    // insert order items and update stock
    foreach ($cart as $item) {
      $query = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)";
      $stmt = $this->connection->prepare($query);
      $itemId = $item->getItemId();
      $quantity = $item->getQuantity();
      $price = $item->getItemPrice();
      $stmt->bind_param("iiid", $order_id, $itemId, $quantity, $price);
      $stmt->execute();
      $stmt->close();

      $query = "UPDATE items SET stock = stock - ? WHERE item_id = ?";
      $stmt = $this->connection->prepare($query);
      $stmt->bind_param("ii", $quantity, $itemId);
      $stmt->execute();
      $stmt->close();
    }

    return [
      'success' => true,
      'order_id' => $order_id
    ];
  }

  public function get_orders($user_id) {
    $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
      $orders[] = new Order(
        $row['order_id'],
        $row['user_id'],
        $row['total'],
        $row['status'],
        $row['created_at']
      );
    }
    $stmt->close();
    return $orders;
  }

  public function get_all_orders() {
    $query = "SELECT o.*, u.username, u.email
              FROM orders o
              INNER JOIN users u ON o.user_id = u.user_id
              ORDER BY o.created_at DESC";

    $result = $this->connection->query($query);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
      $orders[] = new Order(
        $row['order_id'],
        $row['user_id'],
        $row['total'],
        $row['status'],
        $row['created_at'],
        $row['username'],
        $row['email']
      );
    }
    return $orders;
  }

  public function update_order_status($order_id, $status) {
    $query = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function delete_order($order_id) {
    $query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $order_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }
}

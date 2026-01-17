<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../models/Item.php';

class ItemService extends Dbh {

  public function get_all_items() {
    $query = "SELECT * FROM items WHERE stock > 0 ORDER BY name";
    $result = $this->connection->query($query);

    $items = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $items[] = new Item(
          $row['item_id'],
          $row['name'],
          $row['description'],
          $row['price'],
          $row['stock'],
          $row['image'] ?? null
        );
      }
    }
    return $items;
  }

  public function get_item_by_id($item_id) {
    $query = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $stmt->close();
      return new Item(
        $row['item_id'],
        $row['name'],
        $row['description'],
        $row['price'],
        $row['stock'],
        $row['image'] ?? null
      );
    }

    $stmt->close();
    return null;
  }

  public function search_items($keyword) {
    $query = "SELECT * FROM items 
              WHERE name LIKE ? OR description LIKE ?";
    $stmt = $this->connection->prepare($query);
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
      $items[] = new Item(
        $row['item_id'],
        $row['name'],
        $row['description'],
        $row['price'],
        $row['stock'],
        $row['image'] ?? null
      );
    }
    $stmt->close();
    return $items;
  }

  public function update_stock($item_id, $quantity) {
    $query = "UPDATE items SET stock = stock - ? WHERE item_id = ? AND stock >= ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("iii", $quantity, $item_id, $quantity);
    $result = $stmt->execute();
    $stmt->close();
    return $result && $this->connection->affected_rows > 0;
  }

  public function add_item($name, $description, $price, $stock, $image = null) {
    $query = "INSERT INTO items (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("ssdis", $name, $description, $price, $stock, $image);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function get_all_items_admin() {
    $query = "SELECT * FROM items ORDER BY item_id DESC";
    $result = $this->connection->query($query);

    $items = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $items[] = new Item(
          $row['item_id'],
          $row['name'],
          $row['description'],
          $row['price'],
          $row['stock'],
          $row['image'] ?? null
        );
      }
    }
    return $items;
  }

  public function update_item($item_id, $name, $description, $price, $stock, $image = null) {
    $query = "UPDATE items 
              SET name = ?, description = ?, price = ?, stock = ?, image = ?
              WHERE item_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("ssdisi", $name, $description, $price, $stock, $image, $item_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function delete_item($item_id) {
    $query = "DELETE FROM items WHERE item_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $item_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }
}

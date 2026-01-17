<?php
require_once __DIR__ . '/../services/ItemService.php';
require_once __DIR__ . '/../models/Item.php';

class ItemController {

  protected $itemService;
  private $response = '';

  public function __construct() {
    $this->itemService = new ItemService();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['item_res'])) {
      $this->response = $_SESSION['item_res'];
      unset($_SESSION['item_res']);
    }
  }

  public function getAllItems() {
    return $this->itemService->get_all_items();
  }

  public function getItem($item_id) {
    return $this->itemService->get_item_by_id($item_id);
  }

  public function searchItems($keyword) {
    return $this->itemService->search_items($keyword);
  }

  public function getResponse() {
    return $this->response;
  }

  public function addItem($name, $description, $price, $stock, $image = null) {
    $result = $this->itemService->add_item($name, $description, $price, $stock, $image);
    if ($result) {
      $_SESSION['item_res'] = "item added";
    } else {
      $_SESSION['item_res'] = "failed to add item";
    }
    return $result;
  }

  public function getAllItemsAdmin() {
    return $this->itemService->get_all_items_admin();
  }

  public function updateItem($item_id, $name, $description, $price, $stock, $image = null) {
    $result = $this->itemService->update_item($item_id, $name, $description, $price, $stock, $image);
    if ($result) {
      $_SESSION['item_res'] = "item updated";
    } else {
      $_SESSION['item_res'] = "failed to update item";
    }
    return $result;
  }

  public function deleteItem($item_id) {
    $result = $this->itemService->delete_item($item_id);
    if ($result) {
      $_SESSION['item_res'] = "item deleted";
    } else {
      $_SESSION['item_res'] = "failed to delete item";
    }
    return $result;
  }
}

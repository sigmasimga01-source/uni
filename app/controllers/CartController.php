<?php
require_once __DIR__ . '/../services/CartService.php';
require_once __DIR__ . '/../models/Cart.php';

class CartController {

  protected $cartService;
  private $response = '';

  public function __construct() {
    $this->cartService = new CartService();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['cart_res'])) {
      $this->response = $_SESSION['cart_res'];
      unset($_SESSION['cart_res']);
    }
  }

  public function addToCart($item_id, $quantity = 1) {
    $result = $this->cartService->add_to_cart($item_id, $quantity);
    if ($result) {
      $_SESSION['cart_res'] = "item added to cart";
    } else {
      $_SESSION['cart_res'] = "failed to add item to cart";
    }
    return $result;
  }

  public function getCart() {
    return $this->cartService->get_cart();
  }

  public function updateQuantity($item_id, $quantity) {
    $result = $this->cartService->update_quantity($item_id, $quantity);
    if ($result) {
      $_SESSION['cart_res'] = "cart updated";
    }
    return $result;
  }

  public function removeFromCart($item_id) {
    $result = $this->cartService->remove_from_cart($item_id);
    if ($result) {
      $_SESSION['cart_res'] = "item removed from cart";
    }
    return $result;
  }

  public function clearCart() {
    return $this->cartService->clear_cart();
  }

  public function getCartTotal() {
    return $this->cartService->get_cart_total();
  }

  public function getCartCount() {
    return $this->cartService->get_cart_count();
  }

  public function getResponse() {
    return $this->response;
  }
}

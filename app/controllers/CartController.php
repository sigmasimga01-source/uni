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

  public function checkout($user_id) {
    $result = $this->cartService->checkout($user_id);

    if (is_array($result)) {
      if ($result['success']) {
        $_SESSION['cart_res'] = "order placed: Order #" . $result['order_id'];
        return $result['order_id'];
      } else {
        if ($result['error'] === 'low_balance') {
          $_SESSION['cart_res'] = "low balance. need $" 
                                  . $result['total'] 
                                  . " but only have $" 
                                  . $result['balance'] 
                                  . ". Hack Pentagon for money";
          header('Location: cart');
          exit();
        } else {
          $_SESSION['cart_res'] = "failed. Cart is empty.";
        }
        return false;
      }
    }

    $_SESSION['cart_res'] = "failed.";
    return false;
  }

  public function getOrders($user_id) {
    return $this->cartService->get_orders($user_id);
  }

  public function getAllOrders() {
    return $this->cartService->get_all_orders();
  }

  public function updateOrderStatus($order_id, $status) {
    $result = $this->cartService->update_order_status($order_id, $status);
    if ($result) {
      $_SESSION['cart_res'] = "order updated";
    } else {
      $_SESSION['cart_res'] = "failed to update order";
    }
    return $result;
  }

  public function getResponse() {
    return $this->response;
  }
}

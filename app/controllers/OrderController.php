<?php
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/CartService.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController {

  protected $orderService;
  protected $cartService;
  private $response = '';

  public function __construct() {
    $this->orderService = new OrderService();
    $this->cartService = new CartService();

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (isset($_SESSION['order_res'])) {
      $this->response = $_SESSION['order_res'];
      unset($_SESSION['order_res']);
    }
  }

  public function checkout($user_id) {
    $cart = $this->cartService->get_cart();

    if (empty($cart)) {
      $_SESSION['order_res'] = "Your cart is empty";
      return false;
    }

    $result = $this->orderService->checkout($user_id, $cart);

    if ($result['success']) {
      $this->cartService->clear_cart();
      $_SESSION['order_res'] = "Order placed successfully! Order #" . $result['order_id'];
      return $result['order_id'];
    } else {
      if ($result['error'] === 'low_balance') {
        $_SESSION['order_res'] = "Insufficient balance. You have $" . $result['balance'] . " but need $" . $result['total'];
        header('Location: cart');
      } else {
        $_SESSION['order_res'] = "Failed to place order";
      }
      return false;
    }
  }

  public function getOrders($user_id) {
    return $this->orderService->get_orders($user_id);
  }

  public function getAllOrders() {
    return $this->orderService->get_all_orders();
  }

  public function updateOrderStatus($order_id, $status) {
    $result = $this->orderService->update_order_status($order_id, $status);
    if ($result) {
      $_SESSION['order_res'] = "Order status updated to " . $status;
    } else {
      $_SESSION['order_res'] = "Failed to update order status";
    }
    return $result;
  }

  public function getResponse() {
    return $this->response;
  }

  public function deleteOrder($order_id) {
    $result = $this->orderService->delete_order($order_id);
    if ($result) {
      $_SESSION['order_res'] = "Order deleted successfully";
    } else {
      $_SESSION['order_res'] = "Failed to delete order";
    }
    return $result;
  }
}

<?php
require_once __DIR__ . '/Item.php';

class Cart {
  private Item $item;
  private int $quantity;

  public function __construct(
    Item $item,
    int $quantity = 1,
  ) {
    $this->item = $item;
    $this->quantity = $quantity;
  }

  public function getItem(): Item {
    return $this->item;
  }

  public function getQuantity(): int {
    return $this->quantity;
  }

  public function setQuantity(int $quantity): void {
    $this->quantity = $quantity;
  }
}

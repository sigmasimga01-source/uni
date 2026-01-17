<?php

class Cart {
  private int $item_id;
  private int $quantity;
  private ?string $added_at;

  private ?string $item_name;
  private ?float $item_price;
  private ?int $item_stock;

  public function __construct(
    int $itemId,
    int $quantity = 1,
    ?string $addedAt = null,
    ?string $itemName = null,
    ?float $itemPrice = null,
    ?int $itemStock = null,
  ) {
    $this->item_id = $itemId;
    $this->quantity = $quantity;
    $this->added_at = $addedAt;
    $this->item_name = $itemName;
    $this->item_price = $itemPrice;
    $this->item_stock = $itemStock;
  }

  public function getItemId(): int {
    return $this->item_id;
  }

  public function getQuantity(): int {
    return $this->quantity;
  }

  public function getAddedAt(): ?string {
    return $this->added_at;
  }

  public function getItemName(): ?string {
    return $this->item_name;
  }

  public function getItemPrice(): ?float {
    return $this->item_price;
  }

  public function getItemStock(): ?int {
    return $this->item_stock;
  }

  public function setQuantity(int $quantity): void {
    $this->quantity = $quantity;
  }
}

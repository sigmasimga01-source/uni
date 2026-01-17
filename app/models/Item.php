<?php

class Item {
  private ?int $item_id;
  private string $name;
  private ?string $description;
  private float $price;
  private int $stock;
  private ?string $image;

  public function __construct(?int $itemId, string $name, ?string $description, float $price, int $stock = 0, ?string $image = null) {
    $this->item_id = $itemId;
    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
    $this->stock = $stock;
    $this->image = $image;
  }

  public function getItemId(): ?int {
    return $this->item_id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getDescription(): ?string {
    return $this->description;
  }

  public function getPrice(): float {
    return $this->price;
  }

  public function getStock(): int {
    return $this->stock;
  }

  public function setName(string $name): void {
    $this->name = $name;
  }

  public function setDescription(?string $description): void {
    $this->description = $description;
  }

  public function setPrice(float $price): void {
    $this->price = $price;
  }

  public function setStock(int $stock): void {
    $this->stock = $stock;
  }

  public function getImage(): ?string {
    return $this->image;
  }

  public function setImage(?string $image): void {
    $this->image = $image;
  }
}

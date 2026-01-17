<?php

class Order {
  private ?int $order_id;
  private int $user_id;
  private float $total;
  private string $status;
  private ?string $created_at;

  private ?string $username;
  private ?string $email;

  public function __construct(
    ?int $orderId,
    int $userId,
    float $total,
    string $status = 'pending',
    ?string $createdAt = null,
    ?string $username = null,
    ?string $email = null
  ) {
    $this->order_id = $orderId;
    $this->user_id = $userId;
    $this->total = $total;
    $this->status = $status;
    $this->created_at = $createdAt;
    $this->username = $username;
    $this->email = $email;
  }

  public function getOrderId(): ?int {
    return $this->order_id;
  }

  public function getUserId(): int {
    return $this->user_id;
  }

  public function getTotal(): float {
    return $this->total;
  }

  public function getStatus(): string {
    return $this->status;
  }

  public function getCreatedAt(): ?string {
    return $this->created_at;
  }

  public function getUsername(): ?string {
    return $this->username;
  }

  public function getEmail(): ?string {
    return $this->email;
  }

  public function setStatus(string $status): void {
    $this->status = $status;
  }
}

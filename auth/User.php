<?php

class User {
    private ?int $user_id;
    private string $name;
    private string $lastname;
    private string $tel;
    private string $pass;

    public function __construct(?int $userId, string $Name, string $Lastname, string $Tel, string $Pass) {
        $this->user_id = $userId;
        $this->name = $Name;
        $this->lastname = $Lastname;
        $this->tel = $Tel;
        $this->pass = $Pass;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getLastname(): string {
        return $this->lastname;
    }

    public function getTel(): string {
        return $this->tel;
    }

    public function getPass(): string {
        return $this->pass;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setLastname(string $lastname): void {
        $this->lastname = $lastname;
    }

    public function setTel(string $tel): void {
        $this->tel = $tel;
    }

    public function setPass(string $pass): void {
        $this->pass = $pass;
    }
}
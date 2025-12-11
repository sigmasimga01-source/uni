<?php

class User {
    private ?int   $user_id;
    private string $name;
    private string $lastname;
    private string $username;
    private string $tel;
    private string $password;

    public function __construct(?int $userId, string $Name, string $Lastname, string $Username, string $Tel, string $password) {
        $this->user_id = $userId;
        $this->name = $Name;
        $this->lastname = $Lastname;
        $this->username = $Username;
        $this->tel = $Tel;
        $this->password = $password;
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

    public function getUsername(): string {
        return $this->username;
    }

    public function getTel(): string {
        return $this->tel;
    }

    public function getpassword(): string {
        return $this->password;
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

    public function setpassword(string $password): void {
        $this->password = $password;
    }
}
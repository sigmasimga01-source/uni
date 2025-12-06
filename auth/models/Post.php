<?php
class Post {
    private $id;
    private $userId;
    private $title;
    private $content;
    private $createdAt;

    public function __construct($id, $userId, $title, $content, $createdAt = null) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getCreatedAt() { return $this->createdAt; }
}

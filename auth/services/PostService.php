<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../core/db.php';

class PostService {
    private $dbHelper;

    public function __construct() {
        $this->dbHelper = new Dbhelper();
    }

    public function createPost($userId, $title, $content) {
        $post = new Post(null, $userId, $title, $content);
        return $this->dbHelper->add_post($post);
    }

    public function getAllPosts() {
        return $this->dbHelper->get_all_posts();
    }
}

<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../core/db.php';

class PostService extends Dbh {



  public function add_post($post) {
    $query = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $this->connection->prepare($query);

    $userId = $post->getUserId();
    $title = $post->getTitle();
    $content = $post->getContent();

    $stmt->bind_param("iss", $userId, $title, $content);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function get_all_posts() {
    $query = "
      SELECT 
        posts.post_id,
        posts.title,
        posts.content,
        posts.created_at,
        users.username
      FROM posts
      JOIN users ON posts.user_id = users.user_id
      ORDER BY posts.created_at DESC
    ";
    $result = $this->connection->query($query);

    $posts = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
      }
    }
    return $posts;
  }

  public function get_posts_by_user_id($userId) {
    $query = "
      SELECT 
        posts.post_id,
        posts.title,
        posts.content,
        posts.created_at,
        users.username
      FROM posts
      JOIN users ON posts.user_id = users.user_id
      WHERE posts.user_id = ?
      ORDER BY posts.created_at DESC
    ";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
      }
    }
    $stmt->close();
    return $posts;
  }
}

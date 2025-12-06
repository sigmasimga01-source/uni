<?php
class Dbhelper {
  // private $hostname;
  // private $username;
  // private $password;
  // private $database;
  private $connection;

  // public function __construct($hostname, $username, $password, $database) {
  //     $this->hostname = $hostname;
  //     $this->username = $username;
  //     $this->password = $password;
  //     $this->database = $database;
  //     $this->connection = new mysqli('localhost', 'root', '', 'salesdb');
  // }

  public function __construct() {
    $this->connection = new mysqli('localhost', 'root', '', 'blog_db');
    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  public function getConnection() {
    return $this->connection;
  }

  public function add_user($user) {

    $query = "INSERT INTO users (name, lastname, username, tel, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connection->prepare($query);

    $name = $user->getName();
    $lastname = $user->getLastname();
    $username = $user->getUsername();
    $tel = $user->getTel();
    $password = $user->getpassword();

    $stmt->bind_param("sssss", $name, $lastname, $username, $tel, $password);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function login($username, $password) {
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $hashedPassword = $user['password'];

      // Verify the password against the hash stored in database
      if (password_verify($password, $hashedPassword)) {
        $stmt->close();
        return true;
      }
    }

    $stmt->close();
    return false;
  }

  public function get_user($username) {
    $query = "SELECT user_id, name, lastname, username, tel FROM users WHERE username = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $stmt->close();
      return $user;
    }

    $stmt->close();
    return null;
  }

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
}

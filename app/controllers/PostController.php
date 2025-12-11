<?php
require_once __DIR__ . '/../services/PostService.php';
require_once __DIR__ . '/../models/Post.php';

class PostController {
  private $postService;
  public $posts = [];
  public $message = '';

  public function __construct() {
    $this->postService = new PostService();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  public function handleRequest() {
    // Handle Post Submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
      $this->createPost();
    }
  }

  public function getPosts() {
    // check for logged in user before fetching posts
    if (!isset($_SESSION['logged_in'])) {
      $this->message = "You must be <a href='login.php' style='color: lime; text-decoration: underline;'>logged in</a> to view posts.";
      return;
    } else {
      try {
        $this->posts = $this->postService->get_all_posts();
      } catch (\Throwable $th) {
        $this->message = "An error occurred while fetching posts. Please try again later.";
        error_log($th->getMessage());
        return;
      }
    }
  }

  public function getPost($postId) {
    if ($postId === null) {
      return null;
    }

    try {
      $allPosts = $this->postService->get_all_posts();
      foreach ($allPosts as $post) {
        if ($post['post_id'] == $postId) {
          return new Post(
            $post['post_id'],
            $post['user_id'],
            $post['title'],
            $post['content'],
            $post['created_at']
          );
        }
      }
      return null;
    } catch (\Throwable $th) {
      error_log($th->getMessage());
      return null;
    }
  }

  public function getUserPosts() {
    if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user_data']['user_id'])) {
      return [];
    }

    try {
      return $this->postService->get_posts_by_user_id($_SESSION['user_data']['user_id']);
    } catch (\Throwable $th) {
      error_log($th->getMessage());
      return [];
    }
  }

  private function createPost() {
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
      $this->message = "You must be logged in to create a post.";
      return;
    }

    // Check if user_id exists in session (handles stale sessions)
    if (!isset($_SESSION['user_data']['user_id'])) {
      $this->message = "Session expired or invalid. Please logout and login again.";
      return;
    }

    $userId = $_SESSION['user_data']['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $post = new Post(null, null, $userId, $title, $content);

    if ($this->postService->add_post($post)) {
      $this->message = "Post created successfully!";
      // Redirect to avoid form resubmission
      header("Location: posts.php");
      exit();
    } else {
      $this->message = "Error creating post.";
    }
  }
}

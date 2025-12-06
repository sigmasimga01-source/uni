<?php
require_once __DIR__ . '/../services/PostService.php';

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

    // check for logged in user before fetching posts
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
      $this->message = "You must be logged in to view posts.";
      return;
    } else {
      try {
        $this->posts = $this->postService->getAllPosts();
      } catch (\Throwable $th) {
        $this->message = "An error occurred while fetching posts. Please try again later.";
        error_log($th->getMessage());
        return;
      }
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

    if ($this->postService->createPost($userId, $title, $content)) {
      $this->message = "Post created successfully!";
      // Redirect to avoid form resubmission
      header("Location: posts.php");
      exit();
    } else {
      $this->message = "Error creating post.";
    }
  }
}

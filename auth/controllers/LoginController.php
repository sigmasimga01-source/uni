<?php

require_once __DIR__ . '/../core/db.php';

class LoginController {
  private $dbHelper;
  public $message = '';
  public $isLoggedIn = false;
  public $userData = null;

  public function __construct() {
    $this->dbHelper = new Dbhelper();
    session_start();
  }

  public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

      if (empty($_POST['username']) || empty($_POST['password'])) {
        $this->message = "All fields are required.";
        return false;
      }

      $username = $_POST['username'];
      $password = $_POST['password'];

      $this->isLoggedIn = $this->dbHelper->login($username, $password);

      if ($this->isLoggedIn) {
        $this->userData = $this->dbHelper->get_user($username);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_data'] = $this->userData;
        $this->message = "Login successful.";
        return true;
      } else {
        $this->message = "Invalid username or password.";
        return false;
      }
    }

    return false;
  }

  public function logout() {
    session_start();
    session_destroy();
    header("Location: login.php");
    exit();
  }

  public function isUserLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
  }

  public function getUserData() {
    if ($this->isUserLoggedIn()) {
      return $_SESSION['user_data'];
    }
    return null;
  }
}

<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../models/User.php';
class AuthController {

  private $isLoggedIn = false;
  private $userData = null;
  protected $authService;

  public function __construct() {
    $this->authService = new AuthService();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
      $this->isLoggedIn = true;
      $this->userData = $_SESSION['user_data'];
    }
  }

  public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

      if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['msg'] = "All fields are required.";
        return false;
      }

      $username = $_POST['username'];
      $password = $_POST['password'];

      $this->isLoggedIn = $this->authService->login($username, $password);

      if ($this->isLoggedIn) {
        $this->userData = $this->authService->get_user($username);
        $_SESSION['logged_in'] = true;
        $_SESSION['user_data'] = $this->userData;
        $_SESSION['msg'] = "Login successful.";
        return true;
      } else {
        $_SESSION['msg'] = "Invalid username or password.";
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
    return $this->isLoggedIn;
  }

  public function getUserData() {
    if ($this->isUserLoggedIn()) {
      return $this->userData;
    }
    return null;
  }

  public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

      if (
        empty($_POST['name']) ||
        empty($_POST['lastname']) ||
        empty($_POST['tel']) ||
        empty($_POST['password']) ||
        empty($_POST['username'])
      ) {
        $_SESSION['msg'] = "All fields are required.";
        return false;
      }

      $user = new User(
        null,
        $_POST['name'],
        $_POST['lastname'],
        $_POST['username'],
        $_POST['tel'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)
      );

      try {
        $isAdded = $this->authService->add_user($user);
      } catch (\Throwable $th) {
        $_SESSION['msg'] = "Error: " . $th->getMessage();
        return false;
      }

      if ($isAdded) {
        $_SESSION['msg'] = "User registered successfully.";
        header("Location: login.php");
        exit();
      } else {
        $_SESSION['msg'] = "Error registering user.";
      }

      return $isAdded;
    }

    return false;
  }

  public function getMessage() {
    if (isset($_SESSION['msg'])) {
      $message = $_SESSION['msg'];
      unset($_SESSION['msg']);
      return $message;
    }
    return '';
  }
}

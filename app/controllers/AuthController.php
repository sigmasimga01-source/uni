<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {

  private $isLoggedIn = false;
  private $user = null;
  private $response = '';
  protected $authService;

  public function __construct() {
    $this->authService = new AuthService();
    if (session_status() === PHP_SESSION_NONE) session_start();


    if (
      isset($_SESSION['logged_in']) &&
      $_SESSION['logged_in'] === true &&
      isset($_SESSION['user'])
    ) {
      $this->isLoggedIn = true;
      $this->user = $_SESSION['user'];
    }

    if (isset($_SESSION['res'])) {
      $this->response = $_SESSION['res'];
      unset($_SESSION['res']);
    }
  }

  public function login() {
    if (empty($_POST['username']) || empty($_POST['password'])) {
      $_SESSION['res'] = "MISSING USERNAME OR PASSWORD.";
      return false;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $this->isLoggedIn = $this->authService->login($username, $password);

    if ($this->isLoggedIn) {
      $userData = $this->authService->get_user($username);
      $_SESSION['logged_in'] = true;

      $this->user = new User(
        $userData['user_id'],
        $userData['role'],
        $userData['name'],
        $userData['lastname'],
        $userData['username'],
        $userData['email'],
        null,
        $userData['balance'] ?? 0.00
      );
      $_SESSION['user'] = $this->user;

      $_SESSION['res'] = "Login successful.";
      return true;
    } else {
      $_SESSION['res'] = "Invalid username or password.";
      return false;
    }
  }

  public function logout() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    session_destroy();
    header("Location: login");
    exit();
  }

  public function isLoggedIn() {
    return $this->isLoggedIn;
  }

  public function getUser() {
    if ($this->isLoggedIn()) {
      $userData = $this->authService->get_user_by_id($this->getUserId());
      $this->user = new User(
        $userData['user_id'],
        $userData['role'],
        $userData['name'],
        $userData['lastname'],
        $userData['username'],
        $userData['email'],
        null,
        $userData['balance'] ?? 0.00
      );
      $_SESSION['user'] = $this->user;
      return $this->user;
    }
    return null;
  }

  public function getUserId() {
    if ($this->isLoggedIn() && $this->user) {
      return $this->user->getUserId();
    }
    return null;
  }

  public function getResponse() {
    return $this->response;
  }

  public function register() {
    if (
      empty($_POST['name']) ||
      empty($_POST['lastname']) ||
      empty($_POST['email']) ||
      empty($_POST['password']) ||
      empty($_POST['username'])
    ) {
      $_SESSION['res'] = "All fields are required.";
      return false;
    }

    $user = new User(
      null,
      "customer",
      $_POST['name'],
      $_POST['lastname'],
      $_POST['username'],
      $_POST['email'],
      password_hash($_POST['password'], PASSWORD_DEFAULT)
    );

    try {
      $userExists = $this->authService->get_user($user->getUsername(), $user->getEmail());
      
      if ($userExists) {
        $_SESSION['res'] = "Username or email already in use.";
        header("Location: register");
        return false;
      }

      $isAdded = $this->authService->add_user($user);
    } catch (Throwable $th) {
      $_SESSION['res'] = "Error: " . $th->getMessage();
      return false;
    }

    if ($isAdded) {
      $_SESSION['res'] = "Registration successful. Please login.";
      header("Location: login");
      exit();
    } else {
      $_SESSION['res'] = "Registration failed.";
      return false;
    }
  }

  public function update() {

    if (
      empty($_POST['name']) ||
      empty($_POST['lastname']) ||
      empty($_POST['email']) ||
      empty($_POST['username'])
    ) {
      $_SESSION['res'] = "All fields are required.";
      return false;
    }

    try {
      $isUpdated = $this->authService->update_user(
        $this->getUserId(),
        [
          'name' => $_POST['name'],
          'lastname' => $_POST['lastname'],
          'username' => $_POST['username'],
          'email' => $_POST['email']
        ]
      );
    } catch (Throwable $th) {
      $_SESSION['res'] = "Error: " . $th->getMessage();
      return false;
    }

    if ($isUpdated) {
      $userData = $this->authService->get_user_by_id($this->getUserId());
      $this->user = new User(
        $userData['user_id'],
        $userData['role'],
        $userData['name'],
        $userData['lastname'],
        $userData['username'],
        $userData['email'],
        null,
        $userData['balance'] ?? 0.00
      );
      $_SESSION['user'] = $this->user;

      $_SESSION['res'] = "Profile updated successfully.";
      return true;
    } else {
      $_SESSION['res'] = "Profile update failed.";
      return false;
    }
  }

  public function addBalance($amount) {
    $result = $this->authService->add_balance($this->getUserId(), $amount);
    if ($result) {
      // refresh user data
      $userData = $this->authService->get_user_by_id($this->getUserId());
      $this->user = new User(
        $userData['user_id'],
        $userData['role'],
        $userData['name'],
        $userData['lastname'],
        $userData['username'],
        $userData['email'],
        null,
        $userData['balance'] ?? 0.00
      );
      $_SESSION['user'] = $this->user;
    }
    return $result;
  }

  public function getBalance() {
    return $this->authService->get_balance($this->getUserId());
  }

  public function deductBalance($amount) {
    $result = $this->authService->deduct_balance($this->getUserId(), $amount);
    return $result;
  }

  public function clearBalance() {
    return $this->authService->deduct_balance($this->getUserId(), $this->getBalance());
  }
}

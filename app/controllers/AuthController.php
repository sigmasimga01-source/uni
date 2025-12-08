<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {

  private $isLoggedIn = false;
  private $userData = null;

  public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

      if (empty($_POST['username']) || empty($_POST['password'])) {
        $this->message = "All fields are required.";
        return false;
      }

      $username = $_POST['username'];
      $password = $_POST['password'];

      $this->isLoggedIn = $this->dbh->login($username, $password);

      if ($this->isLoggedIn) {
        $this->userData = $this->dbh->get_user($username);
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
        $this->message = "All fields are required.";
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
        $isAdded = $this->dbh->add_user($user);
      } catch (\Throwable $th) {
        $this->message = "Error: " . $th->getMessage();
        return false;
      }

      if ($isAdded) {
        $this->message = "User registered successfully.";
        header("Location: login.php");
        exit();
      } else {
        $this->message = "Error registering user.";
      }

      return $isAdded;
    }

    return false;
  }

  public function getMessage() {
    return $this->message;
  }
}

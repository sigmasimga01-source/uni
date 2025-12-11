<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../services/AuthService.php';

class AuthController {
    private $authService;
    public $message = '';
    public $isLoggedIn = false;
    public $userData = null;
    public $success = false;

    public function __construct() {
        $this->authService = new AuthService();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

            if (empty($_POST['username']) || empty($_POST['password'])) {
                $this->message = "All fields are required.";
                return false;
            }

            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $this->isLoggedIn = $this->authService->login($username, $password);
            } catch (\Throwable $th) {
                $this->message = "An error occurred during login. Please try again later.";
                error_log($th->getMessage());
                return false;
            }

            if ($this->isLoggedIn) {
                // Security: Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                $this->userData = $this->authService->get_user($username);
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
                $_POST['password']
            );

            $isAdded = $this->authService->add_user($user);

            if ($isAdded) {
                $this->success = true;
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

    public function logout() {
        // Unset all session values
        $_SESSION = [];
        session_unset();

        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
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

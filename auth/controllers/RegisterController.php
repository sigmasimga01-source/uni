<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/db.php';

class RegisterController {
    private $dbHelper;
    public $message = '';
    public $success = false;

    public function __construct() {
        $this->dbHelper = new Dbhelper();
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

            $isAdded = $this->dbHelper->add_user($user);

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
}

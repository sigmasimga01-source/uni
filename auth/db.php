<?php
class Dbhelper {
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = new mysqli($hostname, $username, $password, $database);
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection->close();
    }

    public function addUser($user){
        
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);

        
        $stmt->bind_param("sss", $user['username'], password_hash($user['password'], PASSWORD_BCRYPT), $user['email']);
        return $stmt->execute();
    }
}
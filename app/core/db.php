<?php
class Dbh {
  // private $hostname;
  // private $username;
  // private $password;
  // private $database;
  protected $connection;

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

}

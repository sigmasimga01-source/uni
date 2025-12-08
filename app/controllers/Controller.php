<?php

class Controller {
  protected $dbh;
  public $message = '';
  public function __construct() {
    $this->dbh = new Dbh();
    session_start();
  }
}
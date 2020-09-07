<?php

use Dotenv\Dotenv;

require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');

if (file_exists(__DIR__ . "/../../.env")) {
  $dotenv->load();
}

class Database
{
  // private $host = "us-cdbr-east-02.cleardb.com";
  // private $db_name = "heroku_42fe2b55e267208";
  // private $username = "b3659f82aa7e1a";

  private $host = "localhost";
  private $db_name = "wejapablog";
  private $username = "root";
  public $conn;

  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $_ENV['PASSWORD2']);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }
}

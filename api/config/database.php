<?php

use Dotenv\Dotenv;

require '../../vendor/autoload.php';


// $dotenv = new Dotenv(__DIR__);
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Database
{

  private $host = "localhost";
  private $db_name = "wejapablog";
  private $username = "root";
  public $conn;

  public function getConnection()
  {

    $this->conn = null;

    try {
      // $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $_ENV['PASSWORD']);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->conn;
  }
}

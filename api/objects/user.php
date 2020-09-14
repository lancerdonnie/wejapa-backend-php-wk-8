<?php
class User
{
  private $conn;
  private $table_name = "users";

  public $id;
  public $names;
  public $email;
  public $password;
  public $isAdmin = 0;
  public $creationDate;
  public $updationDate;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function create()
  {
    if (!$this->getUser()) return false;

    $query = "INSERT INTO
    " . $this->table_name . "
SET
    names=:names, email=:email, password=:password, isAdmin=:isAdmin";
    //creationDate=:creationDate,
    //updationDate=:updationDate

    $stmt = $this->conn->prepare($query);

    $this->names = htmlspecialchars(strip_tags($this->names));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
    // $this->creationDate = htmlspecialchars(strip_tags($this->creationDate));
    // $this->updationDate = htmlspecialchars(strip_tags($this->updationDate));

    $stmt->bindParam(":names", $this->names);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":isAdmin", $this->isAdmin);
    // $stmt->bindParam(":creationDate", $this->creationDate);
    // $stmt->bindParam(":updationDate", $this->updationDate);

    if ($stmt->execute()) {
      $query = "SELECT  id, email, names, isAdmin FROM " . $this->table_name . " WHERE email =:email";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":email", $this->email);
      $stmt->execute();
      $details = $stmt->fetch(PDO::FETCH_ASSOC);
      return $details;
    }
    return false;
  }

  function getUser()
  {
    $query = "SELECT  email, password, names, isAdmin, id FROM " . $this->table_name . " WHERE email =:email";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":email", $this->email);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return false;
    }
    return true;
  }


  function login()
  {

    $query = "SELECT  email, password, id, names, isAdmin FROM " . $this->table_name . " WHERE email =:email";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":email", $this->email);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return false;
    }
    if ($row['password'] !== $this->password) {
      return false;
    }

    return $row;
  }
}

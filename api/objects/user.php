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
      return true;
    }
    // print_r($stmt->errorInfo());
    // die();
    return false;
  }

  function getUser()
  {
    $query = "SELECT  email, password FROM " . $this->table_name . " WHERE email =:email";

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

    $query = "SELECT  email, password FROM " . $this->table_name . " WHERE email =:email";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":email", $this->email);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return false;
    }
    // echo $this->email . "  " . $this->password;
    // die();
    if ($row['password'] !== $this->password) {
      return false;
    }

    return true;
  }

  // function read()
  // {
  //   $query = "SELECT * FROM $this->table_name";

  //   $stmt = $this->conn->prepare($query);

  //   $stmt->execute();

  //   return $stmt;
  // }

  // function readOne()
  // {
  //   $query = "SELECT * FROM $this->table_name WHERE id = ?";

  //   $stmt = $this->conn->prepare($query);

  //   $stmt->bindParam(1, $this->id);

  //   $stmt->execute();

  //   $row = $stmt->fetch(PDO::FETCH_ASSOC);

  //   $this->title = $row['title'];
  //   $this->tag = $row['tag'];
  //   $this->body = $row['body'];
  //   $this->author = $row['author'];
  //   $this->created = $row['created'];
  // }



  //   function update()
  //   {
  //     $query = "UPDATE
  //     " . $this->table_name . "
  // SET
  //     title=:title, tag=:tag, body=:body, author=:author WHERE id=:id";

  //     $stmt = $this->conn->prepare($query);

  //     $this->title = htmlspecialchars(strip_tags($this->title));
  //     $this->tag = htmlspecialchars(strip_tags($this->tag));
  //     $this->body = htmlspecialchars(strip_tags($this->body));
  //     $this->author = htmlspecialchars(strip_tags($this->author));

  //     $stmt->bindParam(":title", $this->title);
  //     $stmt->bindParam(":tag", $this->tag);
  //     $stmt->bindParam(":body", $this->body);
  //     $stmt->bindParam(":author", $this->author);
  //     $stmt->bindParam(':id', $this->id);

  //     if ($stmt->execute()) {
  //       return true;
  //     }

  //     return false;
  //   }

  // function delete()
  // {
  //   $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  //   $stmt = $this->conn->prepare($query);

  //   $this->id = htmlspecialchars(strip_tags($this->id));

  //   $stmt->bindParam(1, $this->id);

  //   if ($stmt->execute()) {
  //     return true;
  //   }

  //   return false;
  // }
}

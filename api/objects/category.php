<?php
class Blog
{
  private $conn;
  private $table_name = "categories";

  public $id;
  public $title;
  public $adminId;
  public $creationDate;
  public $updationDate;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $query = "SELECT * FROM $this->table_name";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function readOne()
  {
    $query = "SELECT * FROM $this->table_name WHERE id = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->id);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->title = $row['title'];
    $this->adminId = $row['adminId'];
    $this->creationDate = $row['creationDate'];
  }

  function create()
  {
    $query = "INSERT INTO
    " . $this->table_name . "
SET
    title=:title, adminId=:adminId";

    $stmt = $this->conn->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->adminId = htmlspecialchars(strip_tags($this->adminId));

    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":adminId", $this->adminId);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function update()
  {
    $query = "UPDATE
    " . $this->table_name . "
SET
    title=:title, adminId=:adminId, WHERE id=:id";

    $stmt = $this->conn->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->adminId = htmlspecialchars(strip_tags($this->adminId));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":adminId", $this->adminId);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}

<?php
class Blog
{
  private $conn;
  private $table_name = "blogs";

  public $id;
  public $title;
  public $tag;
  public $body;
  public $author;
  public $created;

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
    $this->tag = $row['tag'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->created = $row['created'];
  }

  function create()
  {
    $query = "INSERT INTO
    " . $this->table_name . "
SET
    title=:title, tag=:tag, body=:body, author=:author";

    $stmt = $this->conn->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->tag = htmlspecialchars(strip_tags($this->tag));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));

    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":tag", $this->tag);
    $stmt->bindParam(":body", $this->body);
    $stmt->bindParam(":author", $this->author);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}

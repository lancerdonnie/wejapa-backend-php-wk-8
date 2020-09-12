<?php
class Blog
{
  private $conn;
  private $table_name = "blogs";

  public $id;
  public $title;
  public $body;
  public $userId;
  public $category;
  public $creationDate;
  public $updationDate;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $query = "
      SELECT blogs.id, blogs.name,blogs.creationDate,blogs.title,blogs.body,blogs.image,categories.title as category,users.id as userId, users.email as email
      FROM $this->table_name
      JOIN categories ON $this->table_name.category=categories.id
      JOIN users ON users.id=blogs.userId";
    // $query = "SELECT * FROM $this->table_name";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function readOne()
  {
    $query = "
      SELECT blogs.id, blogs.name,blogs.creationDate,blogs.title,blogs.body,blogs.image,categories.title as category,categories.id as categoryId,users.id as userId, users.email as email
      FROM $this->table_name
      JOIN categories ON $this->table_name.category=categories.id
      JOIN users ON users.id=blogs.userId
      WHERE blogs.id = ?";
    // $query = "SELECT * FROM $this->table_name WHERE id = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->id);

    $stmt->execute();

    $blog_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $blog_item = array(
        "id" => $id,
        "body" => $body,
        "title" => $title,
        "category" => $category,
        "categoryId" => $categoryId,
        "userId" => $userId,
        "email" => $email,
        "image" => $image,
        "creationDate" => $creationDate,
      );
      array_push($blog_arr, $blog_item);
    }
    return $blog_arr;
  }

  function create()
  {

    $query = "INSERT INTO
    " . $this->table_name . "
SET
    title=:title, body=:body, userId=:userId, category=:category, image=:image";

    $stmt = $this->conn->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->image = htmlspecialchars(strip_tags($this->image));

    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":body", $this->body);
    $stmt->bindParam(":userId", $this->userId);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":image", $this->image);

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
    title=:title,  body=:body, userId=:userId, category=:category, updationDate=:updationDate WHERE id=:id";

    $stmt = $this->conn->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->updationDate = htmlspecialchars(strip_tags($this->updationDate));

    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":body", $this->body);
    $stmt->bindParam(":userId", $this->userId);
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":updationDate", $this->updationDate);

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

  function search($keywords)
  {
    $query = "SELECT b.id, b.name, b.creationDate, b.title, b.body,b.image, c.title as category, u.id as userId, u.email as email
    FROM blogs b
    JOIN categories c 
    ON b.category=c.id
    JOIN users u 
    ON u.id=b.userId
    WHERE c.title LIKE ?
    OR b.name LIKE ? 
    OR b.title LIKE ? 
    OR b.body LIKE ? 
    OR u.email LIKE ?
    OR c.title LIKE ?";

    $stmt = $this->conn->prepare($query);

    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
    $stmt->bindParam(4, $keywords);
    $stmt->bindParam(5, $keywords);
    $stmt->bindParam(6, $keywords);

    $stmt->execute();

    $blog_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $blog_item = array(
        "id" => $id,
        "body" => $body,
        "title" => $title,
        "category" => $category,
        // "categoryId" => $categoryId,
        "userId" => $userId,
        "email" => $email,
        "image" => $image,
        "creationDate" => $creationDate,
      );
      array_push($blog_arr, $blog_item);
    }
    return $blog_arr;
  }
}

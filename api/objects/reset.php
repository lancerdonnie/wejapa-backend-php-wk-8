<?php
class Reset
{
  private $conn;
  private $table_name = "passwordreset";

  public $email;
  public $key;
  public $expDate;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function forgotPassword()
  {
    $query = "SELECT * FROM users WHERE email = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->email);

    if (!$stmt->execute()) {
      return false;
    }

    $expFormat = mktime(
      date("H"),
      date("i"),
      date("s"),
      date("m"),
      date("d") + 1,
      date("Y")
    );

    $expDate = date("Y-m-d H:i:s", $expFormat);
    // $expDate = date('Y-m-d H:i:s');
    $key = md5(2418 * 2 + $this->email);
    $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
    $key = $key . $addKey;

    $query = "INSERT INTO passwordreset SET fff =:fff, email =:email, expDate =:expDate";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":expDate", $expDate);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":fff", $key);

    if (!$stmt->execute()) {
      var_dump($stmt->errorInfo());
      die();
      return false;
    }
    return true;
  }
}

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Reset
{
  private $conn;
  // private $table_name = "passwordreset";

  public $email;
  public $key;
  public $expDate;
  public $password;

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
    $mail = new PHPMailer(true);

    $mail->IsSMTP();
    // $mail->SMTPDebug = true;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->Host       = "smtp.mail.yahoo.com";
    $mail->Username   = "adedeji_ifeoluwa@yahoo.com";
    $mail->Hostname = $_SERVER['HTTP_HOST'];
    // $mail->Hostname = 'localhost.localdomain';
    $mail->Password   = $_ENV['EMAILPASSWORD'];

    $mail->IsHTML(true);
    $mail->AddAddress($this->email, "subscriber");
    $mail->SetFrom("adedeji_ifeoluwa@yahoo.com", "We japa");
    $mail->AddReplyTo("adedeji_ifeoluwa@yahoo.com", "We Japa");
    $mail->Subject = "Password Recovery";
    $content = "<b>Click the link to reset your password. It expires in 24 hours   </b>";
    $content .= "<a href='http://";
    $content .= $_SERVER['HTTP_HOST'];
    $content .= "/resetpassword.php?key= . $key . '>reset password</a>";
    $mail->MsgHTML($content);

    try {
      $mail->Send();
      return true;
    } catch (Exception $e) {
      die($mail->ErrorInfo);
    }
    return true;
  }

  function verify()
  {
    $query = "SELECT * FROM passwordreset WHERE fff = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->key);
    if (!$stmt->execute()) {
      die("Link may have expired");
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $curDate = date("Y-m-d H:i:s");
    if ($row['expDate'] < $curDate) die("link expired!");

    $query = "UPDATE users SET password=:password WHERE email=:email";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":email", $row['email']);

    if (!$stmt->execute()) {
      die("Something went wrong");
    }

    $query = "DELETE FROM passwordreset WHERE fff=:key";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":key", $this->key);
    if (!$stmt->execute()) {
      die("Something went wrong");
    }
    return true;
  }
}

<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: /");
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    !empty($_POST["email"])
  ) {
    include_once './api/config/database.php';
    include_once './api/objects/reset.php';

    $database = new Database();
    $db = $database->getConnection();
    $reset = new Reset($db);

    $reset->email = $_POST["email"];

    $details = $reset->forgotPassword();

    if ($details) {
      die("Password reset link has been sent to your email");
    } else {
      die("Something went wrong");
    }
  } else {
    die("Please enter an email");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
</head>

<body>
  <form action="" method="post">
    <input type="text" name="email" placeholder="email">
    <button type="submit">Submit</button>
  </form>
  <a href="/login.php">Login</a>
</body>

</html>
<?php
include_once 'core.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: /");
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    empty($_POST["names"]) ||
    empty($_POST["password"]) ||
    empty($_POST["confirm"]) ||
    empty($_POST["email"])
  ) die("Please fill details correctly");
  if ($_POST["confirm"] !== $_POST["password"]) die("Passwords don't match");

  include_once './api/config/database.php';
  include_once './api/objects/user.php';

  $database = new Database();
  $db = $database->getConnection();
  $user = new User($db);

  $user->names = $_POST["names"];
  $user->email = $_POST["email"];
  $user->password = $_POST["password"];
  $details = $user->create();

  if ($user->create()) {
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["id"] = $details["id"];
    header("location: /");
  } else {
    die("couldnt create user");
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
    <div><label for="email">Email</label><input type="text" name="email"></div>
    <div><label for="names">Name</label><input type="text" name="names"></div>
    <div><label for="password">Password</label><input type="password" name="password"></div>
    <div><label for="confirm">Confirm Password</label><input type="password" name="confirm"></div>
    <button type="submit">Submit</button>
  </form>
</body>

</html>
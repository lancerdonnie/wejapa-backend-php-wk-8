<?php
include 'core.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: /");
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    !empty($_POST["email"]) &&
    !empty($_POST["password"])
  ) {
    include_once './api/config/database.php';
    include_once './api/objects/user.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $user->email = $_POST["email"];
    $user->password = $_POST["password"];
    $details = $user->login();

    if ($details) {
      session_start();
      $_SESSION["loggedin"] = true;
      $_SESSION["id"] = $details['id'];
      $_SESSION["email"] = $_POST["email"];
      $_SESSION["isAdmin"] = $details["isAdmin"];
      header("location: /");
    } else {
      die("username or password incorrect");
    }
  } else {
    die("Please enter username or password");
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
    <input type="text" name="email">
    <input type="password" name="password">
    <button type="submit">Submit</button>
  </form>
  <a href="/register.php">Register</a>
</body>

</html>
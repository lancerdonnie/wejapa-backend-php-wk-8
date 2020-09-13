<?php

if (
  !empty($_GET['key']) && $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["password"])
) {
  $key = $_GET['key'];

  include_once './api/config/database.php';
  include_once './api/objects/reset.php';

  $database = new Database();
  $db = $database->getConnection();
  $reset = new Reset($db);

  $reset->key = $key;
  $reset->password = $_POST["password"];

  $details = $reset->verify();

  if ($details) {
    die("Password reset done");
  } else {
    die("Something went wrong");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>We japa</title>
</head>

<body>
  <form action="" method="POST">
    <input type="text" name="password" id="" placeholder="new password">
  </form>
</body>

</html>
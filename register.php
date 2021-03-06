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
  $user->isAdmin = isset($_POST["isadmin"]) ? $_POST["isadmin"] : 0;
  $details = $user->create();

  if ($user->create()) {
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["id"] = $details["id"];
    $_SESSION["isAdmin"] = $details["isAdmin"];
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
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="container flex flex-col h-screen items-center justify-center">
  <form class="flex flex-col items-left" action="" method="post">
    <div class="mb-2">
      <label class="w-20 inline-block" for="email">Email</label>
      <input class="border-solid border border-gray-600" type="text" name="email">
    </div>
    <div class="mb-2">
      <label class="w-20 inline-block" for="names">Name</label>
      <input class="border-solid border border-gray-600" type="text" name="names">
    </div>
    <div class="mb-2">
      <label class="w-20 inline-block" for="password">Password</label>
      <input class="border-solid border border-gray-600" type="password" name="password">
    </div>
    <div class="mb-2">
      <label class="w-20 inline-block" for="confirm">Confirm Password</label>
      <input class="border-solid border border-gray-600" type="password" name="confirm">
    </div>
    <div class="mb-2">
      <label class="w-20 inline-block" for="isadmin">is Admin?</label>
      <select class="border-solid border border-gray-600" name="isadmin">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
    <button class="bg-blue-400 text-white py-1 px-4 rounded mb-4" type="submit">Submit</button>
  </form>
  <a class="pr-8 text-blue-400" href="/login.php">Login</a>
</body>

</html>
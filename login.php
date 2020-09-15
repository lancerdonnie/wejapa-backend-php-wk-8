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
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="container flex flex-col h-screen items-center justify-center">
  <div class="mb-8 text-3xl">Login</div>
  <form class="flex flex-col items-center" action="" method="post">
    <div class="mb-2">
      <label class="w-20 inline-block" for="email">Email</label>
      <input class="border-solid border border-gray-600" type="text" name="email">
    </div>
    <div class="mb-2">
      <label class="w-20 inline-block" for="password">Password</label>
      <input class="border-solid border border-gray-600" type="password" name="password">
    </div>
    <button class="bg-blue-400 text-white py-1 px-4 rounded mb-4" type="submit">Submit</button>
  </form>
  <div>
    <a class="pr-8 text-blue-400" href="/register.php">Register</a>
    <a class="pr-8 text-gray-400" href="/reset.php">Forgot password?</a>
  </div>
</body>

</html>
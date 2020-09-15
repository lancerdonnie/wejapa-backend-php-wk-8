<?php
include_once 'core.php';
include "api/blogs/readone.php";

$logged;
$belongs;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) $logged = true;
$blog = readOne();
if ($blog) {
  $blog = $blog[0];
}
if ($blog['userId'] === $_SESSION["id"]) $belongs = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>
  <nav class="flex flex-1 items-center justify-center">
    <h2 class="cursor-pointer mr-4"><a href="/">Home</a></h2>
    <span class="add cursor-pointer mr-4"><?= $logged ? '<a href="/create.php">Add</a>' : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $_SESSION['isAdmin'] ?  '<a href="/categories.php">Categories</a>'  : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $logged ?  $_SESSION["email"] : "" ?></span>
    <span class="mr-4">
      <form class="search" action="/search.php"><input name="search" type="text" value="<?= $_GET['search'] ?>"></form>
    </span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
  </nav>
  <div class="blogs main">
    <?php if ($logged && $belongs) {
      echo "<a href=" . "/api/blogs/delete.php?id=" . $blog['id'] . "><i class='fa fa-2x fa-trash-o'></i></a>";
      echo "<a href=" . "/update.php?id=" . $blog['id'] . "><i class='fa fa-edit fa-2x'></i></a>";
    } ?>
    <div>
      <h1><?= $blog['title'] ?></h1>
      <span><?= $blog['category'] ?></span>
      <span class="created"><?= $blog['createdDate'] ?></span>
      <div><?= $blog['body'] ?></div>
    </div>
  </div>
</body>

</html>
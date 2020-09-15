<?php
include 'core.php';
include "api/blogs/read.php";

$logged;
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  $logged = true;
} else {
  header("location: /login.php");
}
$blogs = readBlog();
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
    <span class="add cursor-pointer mr-4"><?= $logged ? '<a href="/create.php">Add</a>' : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $_SESSION['isAdmin'] ?  '<a href="/categories.php">Categories</a>'  : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $logged ?  $_SESSION["email"] : "" ?></span>
    <span class="mr-4">
      <form class="search" action="/search.php">
        <input name="search" type="text">
      </form>
    </span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
  </nav>

  <div class="blogs">
    <?php foreach ($blogs as $value) : ?>
      <a href="/blog.php?id=<?= $value['id'] ?>" class="card" id=<?= $value['id'] ?>>
        <div class='card-image'><img src=<?= empty($value['image']) ? $img : $value['image'] ?> /></div>
        <div class='card-body'>
          <span><?= $value['category'] ?></span>
          <span><?= $value['title'] ?></span>
          <span><?= $value['body'] ?></span>
          <div class='card-profile'>
            <div class='card-profile-image'><img src=<?= $ava ?> /></div>
            <div class='card-profile-body'>
              <span><?= $value['email'] ?></span>
              <span><?= $value['creationDate'] ?></span>
            </div>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</body>

</html>
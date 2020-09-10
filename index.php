<?php
include 'core.php';
include "api/blogs/read.php";

$logged;
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  $logged = true;
}
$blogs = readBlog();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
  <link rel="stylesheet" href="index.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>
  <nav>
    <h2 style="margin-left: 20px;cursor:pointer;"><a href="/"> Blog</a></h2 style="margin-left: 20px;">
    <span class="add"><?= $logged ? '<a href="/create.php">Add Post</a>' : "" ?></span>
    <span class="add"><?php echo $logged ?  $_SESSION["email"] : "" ?></span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
  </nav>

  <div class="blogs">
    <?php foreach ($blogs as $value) : ?>
      <a href="/blog.php?id=<?= $value['id'] ?>" class="card" id=<?= $value['id'] ?>>
        <div class='card-image'><img src=<?= $img ?> /></div>
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
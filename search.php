<?php
include 'core.php';
include_once './api/config/database.php';
include_once './api/objects/blog.php';

if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
} else {
  header("location: /login.php");
}

$database = new Database();
$db = $database->getConnection();

$blogs = new Blog($db);
$blogs = $blogs->search($_GET['search']);
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
    <span>
      <form class="search" action="/search.php"><input name="search" type="text" value="<?= $_GET['search'] ?>"></form>
    </span>
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
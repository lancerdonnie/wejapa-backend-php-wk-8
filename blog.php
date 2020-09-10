<?php
include_once 'core.php';
include "api/blogs/readone.php";

$logged;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) $logged = true;
$blog = readOne();
if ($blog) {
  $blog = $blog[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
  <link rel="stylesheet" href="index.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <style>
    .blogs {
      /* display: none; */
    }

    form {
      display: none;
    }
  </style>
</head>

<body>
  <nav>
    <h2 style="margin-left: 20px;cursor:pointer;"><a href="/"> Blog</a></h2 style="margin-left: 20px;">
    <span></span>
  </nav>
  <form>
    <div>
      <label for="title">Title</label>
      <input class="form-input" name="title">
    </div>
    <div>
      <label for="tag">Tag</label>
      <input class="form-input" name="tag">
    </div>
    <div>
      <label for="content">Content</label>
      <textarea class="form-input" name="content"></textarea>
    </div>
    <button type="submit">update</button>
    <button class="close">close</button>
  </form>
  <div class="blogs main">
    <?php if ($logged) {
      echo "<a href=" . "/update.php?id=" . $blog['id'] . "><i class='fa fa-edit fa-2x'></i></a>";
    } ?>
    <div>
      <h1><?= $blog['title'] ?></h1>
      <span><?= $blog['category'] ?></span>
      <span class="created"><?= $blog['createdDate'] ?></span>
      <div><?= $blog['body'] ?></div>
    </div>
  </div>
  <!-- <script src="blog.js"></script> -->
</body>

</html>
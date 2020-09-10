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
</head>

<body>
  <nav>
    <h2 style="margin-left: 20px;cursor:pointer;"><a href="/"> Blog</a></h2 style="margin-left: 20px;">
    <span></span>
  </nav>
  <div class="blogs main">
    <?php if ($logged) {
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
  <!-- <script src="blog.js"></script> -->
</body>

</html>
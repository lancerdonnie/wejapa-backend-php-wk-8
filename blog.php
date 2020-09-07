<?php
include_once 'core.php';

$logged;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) $logged = true;
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
      display: none;
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
      <label for="author">Author</label>
      <input class="form-input" name="author">
    </div>
    <div>
      <label for="content">Content</label>
      <textarea class="form-input" name="content"></textarea>
    </div>
    <button type="submit">update</button>
    <button class="close">close</button>
  </form>
  <div class="blogs main">
    <?php if ($logged) echo "<i class='fa fa-edit fa-2x'></i>"; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="blog.js"></script>
</body>

</html>
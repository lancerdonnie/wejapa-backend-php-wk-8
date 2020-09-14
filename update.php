<?php
include_once 'core.php';
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true) {
  header("location: /login.php");
  exit;
}

include "api/blogs/readone.php";
include_once './api/config/database.php';
include_once './api/objects/category.php';

$database = new Database();
$db = $database->getConnection();

$cat = new Category($db);
$cat = $cat->read();

$logged;
$logged = true;

$blog = readOne();
if ($blog) {
  $blog = $blog[0];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    !empty($_POST["title"]) &&
    !empty($_POST["content"])
  ) {
    include_once './api/objects/blog.php';
    $bl = new Blog($db);
    $bl->id = $_GET['id'];
    $bl->title = $_POST["title"];
    $bl->body = $_POST["content"];
    $bl->category = $_POST["category"];
    $bl->userId = $_SESSION["id"];
    $bl->updationDate =  date("Y-m-d H:i:s");

    $isSuccess = $bl->update();
    if ($isSuccess) {
      header("location: /blog.php?id=" . $_GET['id']);
    }
    //show alert if success 
  } else {
    // die("Please enter username or password");
  }
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
  <form action="" method="POST">
    <div>
      <label for="title">Title</label>
      <input class="form-input" name="title" value="<?= $blog['title']; ?>">
    </div>
    <div>
      <label for="category">Category</label>
      <select class="form-input" name="category" value=<?= $blog['categoryId'] ?>>
        <?php foreach ($cat as $value) : ?>
          <option value=<?= $value['id'] ?>><?= $value['title'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label for="content">Content</label>
      <textarea class="form-input" name="content"><?= $blog['body']; ?></textarea>
    </div>
    <button type="submit">update</button>
  </form>
</body>

</html>
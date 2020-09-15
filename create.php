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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    !empty($_POST["title"]) &&
    !empty($_POST["content"])
  ) {
    include_once './api/objects/blog.php';
    $target_file;
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
      $target_dir = "images/";
      $_FILES["fileToUpload"]["name"] = $_SESSION['id'] . "-" . $_FILES["fileToUpload"]["name"];
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if ($_FILES["fileToUpload"]["size"] > 250000) {
        die("Sorry, your file is too large.");
      }

      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      } else {
        die("Sorry, there was an error uploading your file.");
      }
    }

    $bl = new Blog($db);
    $bl->title = $_POST["title"];
    $bl->body = $_POST["content"];
    $bl->category = $_POST["category"];
    $bl->userId = $_SESSION["id"];
    if ($target_file) $bl->image = $target_file;

    $isSuccess = $bl->create();
    if ($isSuccess) {
      header("location: /");
    }
    //show alert if success 
    // die("here");
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
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>
  <nav class="flex flex-1 items-center justify-center">
    <h2 class="cursor-pointer mr-4"><a href="/">Home</a></h2>
    <span class="add cursor-pointer mr-4"><?php echo $_SESSION['isAdmin'] ?  '<a href="/categories.php">Categories</a>'  : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $logged ?  $_SESSION["email"] : "" ?></span>
    <span class="mr-4">
      <form class="search" action="/search.php">
        <input name="search" type="text">
      </form>
    </span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
  </nav>
  <form action="" method="POST" enctype="multipart/form-data">
    <div>
      <label for=" title">Title</label>
      <input class="form-input" name="title" value="<?= isset($_POST['title']) ? $_POST['title'] : ""; ?>">
    </div>
    <div>
      <label for="category">Category</label>
      <select class="form-input border-solid border border-gray-600" name="category" value=<?= isset($_POST['categoryId']) ? $_POST['categoryId'] : "" ?>>
        <?php foreach ($cat as $value) : ?>
          <option value=<?= $value['id'] ?>><?= $value['title'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label for="content">Content</label>
      <textarea class="form-input" name="content"><?= isset($_POST['body']) ? $_POST['body'] : ""; ?></textarea>
    </div>
    <div>
      <label for="content">Image</label>
      <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
    </div>
    <button type="submit">submit</button>
  </form>
</body>

</html>
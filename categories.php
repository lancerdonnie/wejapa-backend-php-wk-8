<?php
include_once 'core.php';
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true) {
  header("location: /login.php");
  exit;
}

if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== '1') {
  header("location: /");
  exit;
}

$logged = true;

include_once './api/config/database.php';
include_once './api/objects/category.php';

$database = new Database();
$db = $database->getConnection();


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["edit"] === "edit") {
  if (
    !empty($_POST["title"]) && !empty($_POST["id"])
  ) {
    $category = new Category($db);
    $category->id = $_POST["id"];
    $category->title = $_POST["title"];
    $category->adminId = $_SESSION["id"];
    $category->updationDate =  date("Y-m-d H:i:s");
    $isSuccess = $category->update();
  } else {
  }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    !empty($_POST["title"])
  ) {
    $category = new Category($db);
    $category->title = $_POST["title"];
    $category->adminId = $_SESSION["id"];
    $isSuccess = $category->create();
  } else {
  }
}
$cat = new Category($db);
$cat = $cat->read();
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
  <div>click to edit</div>
  <ul>
    <?php foreach ($cat as $value) : ?>
      <li id="<?= $value['id'] ?>"><?= $value['title'] ?></li>
    <?php endforeach; ?>
  </ul>
  <h3>Add Category</h3>
  <form action="" method="POST">
    <div>
      <label for="title">Category Name</label>
      <input class="form-input" name="title">
    </div>
    <input name="id" type="hidden">
    <input name="edit" type="hidden">
    <button type="submit">add</button>
  </form>
  <script>
    const ul = document.querySelectorAll('ul>li')
    ul.forEach(e => e.addEventListener("click", () => {
      const r = document.querySelector('input[name = "title"]')
      const h = document.querySelector('input[name = "id"]')
      const d = document.querySelector('input[name = "edit"]')
      const s = document.querySelector('button')
      d.value = "edit"
      s.innerText = "update"
      r.value = e.textContent;
      h.value = e.id
    }))
  </script>
</body>

</html>
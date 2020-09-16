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
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["delete"])) {
  $category = new Category($db);
  $category->id = $_POST["delete"];
  $category->delete();
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
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <style>
    form {
      height: unset !important;
      width: unset !important;
      padding: 0 !important;
    }
  </style>
</head>

<body>
  <nav class="flex flex-1 items-center justify-center">
    <h2 class="cursor-pointer mr-4"><a href="/">Home</a></h2>
    <span class="add cursor-pointer mr-4"><?= $logged ? '<a href="/create.php">Add</a>' : "" ?></span>
    <span class="add cursor-pointer mr-4"><?php echo $logged ?  $_SESSION["email"] : "" ?></span>
    <span class="mr-4">
      <form class="search" action="/search.php">
        <input name="search" type="text">
      </form>
    </span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
  </nav>
  <div class="p-8">
    <div class="mb-8 text-4xl">click to edit</div>
    <ul class="flex flex-col items-start">
      <?php foreach ($cat as $value) : ?>
        <div>
          <li class="p-2 inline cursor-pointer bg-pink-400 text-white rounded mb-2" id="<?= $value['id'] ?>">
            <?= $value['title'] ?>
          </li>
          <form class="inline" action="" method="POST">
            <input type="hidden" name="delete" value="<?= $value['id'] ?>">
            <?php echo "<button class='inline' ><i style='position:static' class='fa fa-trash-o '></i></button>"; ?>
          </form>
        </div>
      <?php endforeach; ?>
    </ul>
    <h3 class="mb-8 text-4xl text-center">Add Category</h3>
    <form action="" method="POST">
      <div>
        <label for="title">Category Name</label>
        <input class="form-input" name="title">
      </div>
      <input name="id" type="hidden">
      <input name="edit" type="hidden">
      <button type="submit">add</button>
    </form>
  </div>
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
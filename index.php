<?php
include 'core.php';
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  $logged = true;
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
    <span class="add">Add Post</span>
    <span class="add"><a href=<?php echo $logged ? "/pages/logout.php" : "/login.php" ?>><?php echo $logged ? "logout" : "login" ?></a> </span>
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
    <button type="submit">submit</button>
    <button class="close">close</button>
  </form>

  <div class="blogs">
    <!-- <div class="card">
      <div class="card-image"></div>
      <div class="card-body">
        <span>technology</span>
        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum tempora modi fugit illo, velit esse ab doloribus ducimus adipisci </span>
        <span>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam consectetur, magnam harum autem quam quos, ad laboriosam expedita</span>
        <div class="card-profile">
          <div class="card-profile-image"></div>
          <div class="card-profile-body">
            <span>Carrie brewer</span>
            <span>2h ago</span>
          </div>
        </div>
      </div>
    </div> -->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="index.js"></script>
</body>

</html>
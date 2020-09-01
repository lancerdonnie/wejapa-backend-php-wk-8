<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <nav><span class="add">add</span><span class="update">update</span><span class="delete">delete</span></nav>

  <form>
    <input placeholder="title" type="text">
    <input placeholder="tag" type="text">
    <input placeholder="author" type="text">
    <input placeholder="content" type="text">
    <span class="close">close</span>
    <button type="submit">submit</button>
  </form>
  <div class="blogs">

    <a class="card">
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
    </a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="index.js"></script>
</body>

</html>
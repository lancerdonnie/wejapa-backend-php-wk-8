<?php
include 'core.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: /");
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (
    !empty($_GET["username"]) &&
    !empty($_GET["password"])
  ) {
    session_start();
    $_SESSION["loggedin"] = true;
    // $_SESSION["id"] = $id;
    $_SESSION["username"] = $_GET["username"];
    header("location: /");
  } else {
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wejapa Blog</title>
</head>

<body>
  <form action="" method="get">
    <input type="text" name="username">
    <input type="text" name="password">
    <button type="submit">Submit</button>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <!-- <script>
    const form = document.querySelector("form")
    form.addEventListener("submit", async (e) => {
      e.preventDefault()
      const {
        data
      } = await axios.post("/api/blogs/login.php", {
        username: "jide",
        password: "hfi"
      });
      console.log(data)
    })
  </script> -->
</body>

</html>
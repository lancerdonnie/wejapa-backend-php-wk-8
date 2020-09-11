<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/blog.php';

function readBlog()
{
  $database = new Database();
  $db = $database->getConnection();

  $blog = new Blog($db);

  $stmt = $blog->read();
  $num = $stmt->rowCount();

  $blogs_arr = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $blog_item = array(
      "id" => $id,
      "body" => $body,
      "title" => $title,
      "category" => $category,
      "userId" => $userId,
      "email" => $email,
      "creationDate" => $creationDate,
    );

    array_push($blogs_arr, $blog_item);
  }
  return $blogs_arr;
};

// http_response_code(200);
// echo json_encode(readBlog());

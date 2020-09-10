<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/blog.php';

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
    "name" => $title,
    "tag" => $tag,
    "body" => $body,
    "author" => $author,
    "title" => $title,
    "creationDate" => $creationDate,
  );

  array_push($blogs_arr, $blog_item);
}

http_response_code(200);
echo json_encode($blogs_arr);

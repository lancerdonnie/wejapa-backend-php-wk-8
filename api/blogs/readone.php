<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/blog.php';

$database = new Database();
$db = $database->getConnection();

$blog = new Blog($db);
$blog->id = isset($_GET['id']) ? $_GET['id'] : die();

$stmt = $blog->readOne();

$blogs_arr = array(
  "id" => $blog->id,
  "title" => $blog->title,
  "tag" => $blog->tag,
  "body" => $blog->body,
  "author" => $blog->author,
  "title" => $blog->title,
  "created" => $blog->created,
);

http_response_code(200);
echo json_encode($blogs_arr);

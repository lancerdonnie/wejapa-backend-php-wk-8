<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../objects/blog.php';

$database = new Database();
$db = $database->getConnection();

$blog = new Blog($db);

$data = json_decode(file_get_contents("php://input"));

$blog->id = $data->id;

$blog->author = $data->author;
$blog->body = $data->content;
$blog->title = $data->title;
$blog->tag = $data->tag;

if (
  $blog->update()
) {
  http_response_code(200);
  echo json_encode(array("message" => "Product was created."));
} else {
  http_response_code(503);
  echo json_encode(array("message" => "Unable to update product."));
}

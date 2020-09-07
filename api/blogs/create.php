<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../objects/blog.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$blog = new Blog($db);
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if (
  !empty($data->author) &&
  !empty($data->content) &&
  !empty($data->title)
) {
  session_start();
  $user->email = $_SESSION['email'];
  if (!$user->getUser()) {
    http_response_code(404);
    echo json_encode(array("message" => "You are not logged in"));
  }

  $blog->title = $data->title;
  $blog->body = $data->content;
  $blog->author = $data->author;
  $blog->tag = $data->tag;

  if ($blog->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Product was created."));
  } else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to create product."));
  }
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}

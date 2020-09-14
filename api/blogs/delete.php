<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../objects/blog.php';

$database = new Database();
$db = $database->getConnection();

$blog = new Blog($db);

$blog->id =  $_GET['id'];

if ($blog->delete()) {
  // http_response_code(200);
  // return true;
  header("location: /");
  // echo json_encode(array("message" => "Blog post was deleted."));
} else {
  header("location: /blog.php?=" . $_GET['id']);
  // return false;
  // http_response_code(503);
  // echo json_encode(array("message" => "Unable to delete blog post."));
}

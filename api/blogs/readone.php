<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/blog.php';


function readOne()
{
  $database = new Database();
  $db = $database->getConnection();
  $blog = new Blog($db);
  $blog->id = isset($_GET['id']) ? $_GET['id'] : die();
  $stmt = $blog->readOne();
  return $stmt;
}

// http_response_code(200);
// echo json_encode($blogs_arr);

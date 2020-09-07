<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/blog.php';


// $database = new Database();
// $db = $database->getConnection();

// $blog = new Blog($db);

$data = json_decode(file_get_contents("php://input"));
if (
  !empty($data->username) &&
  !empty($data->password)
) {
  session_start();
  $_SESSION["loggedin"] = true;
  // $_SESSION["id"] = $id;
  $_SESSION["username"] = $data->username;
  echo json_encode($_SESSION);
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Cant login"));
}

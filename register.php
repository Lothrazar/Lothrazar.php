<?php
include_once './services/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = file_get_contents("php://input");
$data = json_decode($data);

$email = $data->email;
$password = $data->password;
$password2 = $data->password2;

$db = new DatabaseService();
$success = $db->insertUser($email, $password);

if ($success) {
  http_response_code(200);
  echo json_encode(array(
    "message" => "User was successfully registered.",
    "email" => $email
  ));
}
else {
  http_response_code(400);
  echo json_encode(array(
    "message" => "Unable to register the user."));
}

?>

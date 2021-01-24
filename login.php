<?php
include_once './services/database.php';
// require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$email = '';
$password = '';

$db = new DatabaseService();

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;
// TODO: input validation
 
$jwt = $db->login($email, $password);

if($jwt != null) {
  http_response_code(200);
  echo json_encode(array(
      "message" => "Successful login.",
      "jwt" => $jwt
  ));
}
else {
  http_response_code(401);
  echo json_encode(array("message" => "Login failed"));
}
?>

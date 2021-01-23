<?php
include_once './services/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$databaseService = new DatabaseService();
$conn = $databaseService->get();

$data = file_get_contents("php://input");

error_log( "email input: " . $data);

$data = json_decode($data);

$email = $data->email;
$password = $data->password;
$password2 = $data->password2;
// TODO: verify input




// TODO: users db service
$table_name = 'users';
$query = "INSERT INTO " . $table_name . "
                SET    email = :email,
                    password = :password";
$success = false;
try {
  $stmt = $conn->prepare($query);

  $password_hash = password_hash($password, PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password_hash);
  $stmt->bindParam(':email', $email);

  $success = $stmt->execute();
}
catch(PDOException $exception) {
   error_log( "execution error: " . $exception->getMessage());
}

if ($success) {

    http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
}
else {
//    error_log("user insert statement failed ".$stmt->errorInfo());
    error_log(print_r($stmt->errorInfo(), true));
    http_response_code(400);
    echo json_encode(array("message" => "Unable to register the user."));
}

?>

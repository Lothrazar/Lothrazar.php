<?php

use \Firebase\JWT\JWT;

// used to get mysql database connection
class DatabaseService {

  private $jwtSecret = "";
  private $host = "localhost:3306";
  private $name = "lothraza_db";
  private $user = "lothraza_admin";
  private $conn = null;

  function __construct() {

    $secrets = json_decode(file_get_contents(__DIR__."/../secrets.json"), true);
    $this->jwtSecret = $secrets['jwt_secret'];

    try {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->name, 
        $this->user, 
        $secrets["mysql_password"]);
    } catch(PDOException $exception) {
        error_log( "Connection error: " . $exception->getMessage());
    }
  }

  public function getUser($email) {
    $table_name = 'users';
    $query = "SELECT id, password FROM " . $table_name . " WHERE email = :email LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
  }
  
  public function login($email, $password) {
    $row = $this->getUser($email);
    if ($row == null) {
      return null;
    }

    error_log("login user ".$row); 
    
    if (password_verify($password, $ $row['password'])) {

        $issuer = "https://www.lothrazar.net"; // this can be the servername
        $audience = $issuer;
        $iat = time(); 
        $token = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $iat,
            "nbf" => $iat + 10,
            "exp" => $iat + 60,
            "data" => array(
                "id" => $$row['id'],
                // "firstname" => $firstname,
                // "lastname" => $lastname,
                "email" => $email
        ));

        $jwt = JWT::encode($token, $this->jwtSecret);
        return $jwt;
        // echo json_encode(
        //     array(
        //         "message" => "Successful login.",
        //         "jwt" => $jwt,
        //         "email" => $email,
        //         "expireAt" => $expire_claim
        //     ));
    }

    return null;
  }

  public function insertUser($email, $password) {
    try {
      $table_name = 'users';
      $query = "INSERT INTO " . $table_name . "
                      SET    email = :email,
                          password = :password";
                          
      $stmt = $this->conn->prepare($query);

      $hash = password_hash($password, PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $hash);
      $stmt->bindParam(':email', $email);

      $success = $stmt->execute();
      return $success;
    }
    catch(PDOException $exception) {
      error_log("PDOException message: " . $exception->getMessage());
      error_log(print_r($stmt->errorInfo(), true));
    }
    return false;
  }
}
?>

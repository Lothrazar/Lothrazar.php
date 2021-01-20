<?php
// used to get mysql database connection
class DatabaseService {

    $secrets  = json_decode(file_get_contents("secrets.json"), true);



    public $host = "localhost:3306";
    public $name = "lothraza_db";
    public $user = "lothraza_admin";
    public $password = $secrets["mysql_password"];
    private $connection;

    public function get() {

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->name, $this->user, $this->password);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>

<?php
// used to get mysql database connection
class DatabaseService {

    public $host = "localhost:3306";
    public $name = "lothraza_db";
    public $user = "lothraza_admin";
    public $password = "";
    private $connection;

    public function get() {

        $this->secrets = json_decode(file_get_contents("../secrets.json"), true);
        $this->password = $this->secrets["mysql_password"];
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->name, $this->user, $this->password);
        } catch(PDOException $exception) {
            error_log( "Connection error: " . $exception->getMessage());
        }

        return $this->connection;
    }
}
?>

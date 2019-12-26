<?php
namespace Codecourse\Repositories;

// Will use PDO class and PDOException
// Otherwise error will be shown in db connection
use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "pro_model";
    private $username = "root";
    private $password = "";
    public $conn;

    public function dbConnection()
    {
        $this->conn = null;
        try {
                $this->conn = new PDO("mysql:host=" . $this->host . "; dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("SET CHARACTER SET utf8");
                // echo "Database connected!!!";
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

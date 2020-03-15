<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;
/**
 * Log in customer/viewers
 */
class LoginCustomer
{
    // Database connection constructor
    private $pdo;
    /**
     * Constructor for database connection
     */
    public function __construct()
    {
        $database = new Database();
        $dbConnection = $database->dbConnection();
        $this->pdo = $dbConnection;
    }
    /**
     * Log in method
     *
     * @param string $email 
     * @param string $table 
     *
     * @return void
     */
    public function logIn($email, $table)
    {
        try {
            $query = "SELECT * FROM $table WHERE email=:email";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);
            $loginData = $stmt->fetch(PDO::FETCH_OBJ);
            return isset($loginData) ? $loginData : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Redirecting method
     *
     * @param string $url 
     *
     * @return void
     */
    public function redirect($url)
    {
        header("Location: $url");
    }
}

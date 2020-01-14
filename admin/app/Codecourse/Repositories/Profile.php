<?php

namespace CodeCourse\Repositories;

// Will load database and helpers class
use CodeCourse\Repositories\Database as Database;
use CodeCourse\Repositories\Helpers as Helpers;

// use PDO;
// use PDOException;

class Profile
{
    // Database connection constructor
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
}

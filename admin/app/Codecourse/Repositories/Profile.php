<?php

namespace Codecourse\Repositories;

// Will load database and helpers class
use Codecourse\Repositories\Database as Database;
use Codecourse\Repositories\Helpers as Helpers;

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

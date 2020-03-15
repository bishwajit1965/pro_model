<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;

class Viewers
{
    // Database connection constructor
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $dbConnection = $database->dbConnection();
        $this->pdo = $dbConnection;
    }
    // Insert data
    public function store($fields, $table)
    {
        try {
            $columns = implode(', ', array_keys($fields));
            $placeholders = implode(', :', array_keys($fields));
            $query = "INSERT INTO $table ($columns) VALUES(:$placeholders)";
            $stmt = $this->pdo->prepare($query);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmtExec = $stmt->execute();
            if ($stmtExec) {
                $lastId = $this->pdo->lastInsertId();
                return $lastId ? true : false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Viewer Login method
     *
     * @param [data] $email
     * @param [type] $table
     * @return void
     */
    public function logIn($email, $table)
    {
        try {
            $query = "SELECT * FROM $table WHERE email=:email";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);
            $customerData = $stmt->fetch(PDO::FETCH_OBJ);
            if ($stmt->rowCount() == 1) {
                return isset($customerData) ? $customerData : false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Undocumented function
     *
     * @param [table Id] $id
     * @param [Table] $table
     * @return void
     */
    public function updateView($id, $table)
    {
        try {
            $sql = "SELECT * FROM $table WHERE id = :edit_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':edit_id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if ($result) {
                return $result;
            } else {
                return false;
            }
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update method
     *
     * @param  fields $fields commented
     * @param  id $id commented
     * @param  table $table commented
     * @return  mixed
     */
    public function update($fields, $id, $table)
    {
        // Delete photo from uploads folder
        $stmt = $this->pdo->prepare("SELECT photo FROM $table WHERE id = :id");
        $stmt->execute([':id' => $_GET['edit_id']]);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        while ($photo_data = $stmt->fetch(PDO::FETCH_OBJ)) {
            $del_photo = $photo_data->photo;
            unlink($del_photo);
        }
        try {
            $st = '';
            $counter = 1;
            $totalFields = count($fields);
            foreach ($fields as $key => $value) {
                if ($counter === $totalFields) {
                    $set = "$key = :" . $key;
                    $st = $st . $set;
                } else {
                    $set = "$key = :" . $key . ', ';
                    $st = $st . $set;
                    ++$counter;
                }
            }
            $sql = '';
            $sql .= "UPDATE $table SET " . $st;
            $sql .= ' WHERE id = ' . $id;
            $stmt = $this->pdo->prepare($sql);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $result = $stmt->execute();
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @param  fields $fields commented
     * @param  id $id commented
     * @param  table $table commented
     * @return void
     */
    public function updateWithoutPhoto($fields, $id, $table)
    {
        try {
            $st = '';
            $counter = 1;
            $totalFields = count($fields);
            foreach ($fields as $key => $value) {
                if ($counter === $totalFields) {
                    $set = "$key = :" . $key;
                    $st = $st . $set;
                } else {
                    $set = "$key = :" . $key . ' , ';
                    $st = $st . $set;
                    ++$counter;
                }
            }
            $sql = '';
            $sql .= "UPDATE $table SET " . $st;
            $sql .= ' WHERE id = ' . $id;
            $stmt = $this->pdo->prepare($sql);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $result = $stmt->execute();
            if ($result) {
                return $result ? true : false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Undocumented function
     *
     * @param  url $url commented
     * @return url commented
     */
    public function redirect($url)
    {
        header('Location:' . $url);
    }

    /**
     * Delete method
     *
     * @param  Table $table commented
     * @param  Data $data commented
     * @return mixed data output
     */
    public function delete($table, $data)
    {
        try {
            $this->pdo->beginTransaction();
            if (!empty($data) && is_array($data)) {
                $whereCond .= ' WHERE ';
                $i = 0;
                foreach ($data as $key => $value) {
                    $add = ($i > 0) ? ' AND ' : '';
                    $whereCond .= "$add" . "$key=:$key";
                    ++$i;
                }
            }
            $sql = 'DELETE FROM ' . $table . $whereCond;
            $query = $this->pdo->prepare($sql);
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $delete = $query->execute();
            $this->pdo->commit();
            return $delete ? true : false;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
}

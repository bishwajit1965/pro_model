<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;

class Core
{
    /**
     * Database connector variable
     *
     * @var string
     */
    private $pdo;
    /**
     * Will create database connection
     */
    public function __construct()
    {
        $database = new Database();
        $dbConnection = $database->dbConnection();
        $this->pdo = $dbConnection;
    }
    
    // Read data from database
    /*
    $sql = "SELECT * FROM tbl_student WHERE id = :id AND email = :email LIMIT 5";
    $query = $this->pdo->prepare($sql);
    $query->bindValue(":id", $id);
    $query->bindValue(":name", $name);
    $query->bindValue(":email", $email);
    $query->bindValue(":address", $address);
    $query->bindValue(":phone", $phone);
    $data = $query->execute();
    if ($data->rowCount() > 0) {
    header("Location:index.php?added");
    } else {
    header("Location:add_student.php?error");
    }
    */

    /**
     * Will select data from database
     *
     * @param string $table
     * @param array  $data
     *
     * @return void
     */
    public function select($table, $data = [])
    {
        try {
            $this->pdo->beginTransaction();
            $sql = 'SELECT ';
            $sql .= array_key_exists('select', $data) ? $data['select'] : '*';
            $sql .= ' FROM ' . $table;
            if (array_key_exists('where', $data)) {
                $sql .= ' WHERE ';
                $initiator = 0;
                foreach ($data['where'] as $key => $value) {
                    $add = ($initiator > 0) ? ' AND ' : '';
                    $sql .= "$add" . "$key=:$key";
                    ++$initiator;
                }
            }

            if (array_key_exists('order_by', $data)) {
                $sql .= ' ORDER BY ' . $data['order_by'];
            }

            if (array_key_exists('start', $data) && array_key_exists('limit', $data)) {
                $sql .= ' LIMIT ' . $data['start'] . ',' . $data['limit'];
            } elseif (array_key_exists('start', $data) && array_key_exists('limit', $data)) {
                $sql .= ' LIMIT ' . $data['limit'];
            } elseif (array_key_exists('limit', $data)) {
                $sql .= ' LIMIT ' . $data['limit'];
            }

            $query = $this->pdo->prepare($sql);

            if (array_key_exists('where', $data)) {
                foreach ($data['where'] as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
            }

            $query->execute();
            if (array_key_exists('return_type', $data)) {
                switch ($data['return_type']) {
                case 'count':
                    $value = $query->rowCount();
                    break;
                case 'single':
                    $value = $query->fetch(PDO::FETCH_OBJ);
                    break;
                default:
                    $value = '';
                    break;
                }
            } else {
                if ($query->rowCount() > 0) {
                    $value = $query->fetchAll(PDO::FETCH_OBJ);
                }
            }
            $this->pdo->commit();
            return !empty($value) ? $value : false;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo 'ERROR !!! ' . $e->getMessage();
        }
    }

    // Insert data to database
    /*
    $sql = "INSERT INTO tableName (name, email, address, phone) VALUES(:name, :email, :address, :phone)";
    $query = This->pdo->prepare($sql);
    $query->bindParam(":name", $name);
    $query->bindParam(":email", $email);
    $query->bindParam(":address", $address);
    $query->bindParam(":phone", $phone);
    $query->execute();
    */
    /**
     * Will insert data into database
     *
     * @param string $table
     * @param array  $data
     *
     * @return void
     */
    public function insert($table, $data)
    {
        try {
            $this->pdo->beginTransaction();
            if (!empty($data) && is_array($data)) {
                $keys = '';
                $values = '';
                $keys = implode(',', array_keys($data));
                $values = ':' . implode(', :', array_keys($data));
                $sql = 'INSERT INTO ' . $table . '(' . $keys . ') VALUES (' . $values . ')';
                $query = $this->pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $insertedData = $query->execute();
                if ($insertedData) {
                    $lastId = $this->pdo->lastInsertId();
                    $this->pdo->commit();
                    return $lastId ? true : '';
                }
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }

    // Update data to database
    /*
    $sql = "UPDATE table_student SET name = :name, email =:email, address =:address, phone =:phone WHERE id = :id";
    $query = $this->pdo->prepare($sql);
    $query->bindValue(':id', $id);
    $query->bindValue(':name', $name);
    $query->bindValue(':email', $email);
    $query->bindValue(':address', $address);
    $query->bindValue(':phone', $phone);
    $query->execute();
    */
    /**
     * Will update data in database
     *
     * @param string $table
     * @param int    $id
     * @param array  $data
     * @param array  $cond
     *
     * @return void
     */
    public function update($table, $id, $data, $cond)
    {
        try {
            $this->pdo->beginTransaction();
            // Delete photo from uploads folder
            $query = "SELECT photo FROM $table WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $_GET['id']]);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            while ($photo_data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $del_photo = $photo_data->photo;
                unlink($del_photo);
            }
            //Will update data in database
            if (!empty($data) && is_array($data)) {
                $keyValue = '';
                $whereCond = '';
                $initiator = 0;
                foreach ($data as $key => $value) {
                    $add = ($initiator > 0) ? ' , ' : '';
                    $keyValue .= "$add" . "$key=:$key";
                    ++$initiator;
                }
                if (!empty($cond) && is_array($cond)) {
                    $whereCond .= ' WHERE ';
                    $initiator = 0;
                    foreach ($cond as $key => $value) {
                        $add = ($initiator > 0) ? ' AND ' : '';
                        $whereCond .= "$add" . "$key=:$key";
                        ++$initiator;
                    }
                }
                $sql = 'UPDATE ' . $table . ' SET ' . $keyValue . $whereCond;
                $query = $this->pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                foreach ($cond as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $update = $query->execute();
                $this->pdo->commit();
                return $update ? $query->rowCount() : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }

    /**
     * Will update data in database
     *
     * @param string $table
     * @param array  $data
     * @param array  $cond
     *
     * @return void
     */
    public function updateWithoutPhoto($table, $data, $cond)
    {
        try {
            $this->pdo->beginTransaction();
            if (!empty($data) && is_array($data)) {
                $keyValue = '';
                $whereCond = '';
                $initiator = 0;
                foreach ($data as $key => $value) {
                    $add = ($initiator > 0) ? ' , ' : '';
                    $keyValue .= "$add" . "$key=:$key";
                    ++$initiator;
                }
                if (!empty($cond) && is_array($cond)) {
                    $whereCond .= ' WHERE ';
                    $initiator = 0;
                    foreach ($cond as $key => $value) {
                        $add = ($initiator > 0) ? ' AND ' : '';
                        $whereCond .= "$add" . "$key=:$key";
                        ++$initiator;
                    }
                }
                $sql = 'UPDATE ' . $table . ' SET ' . $keyValue . $whereCond;
                $query = $this->pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                foreach ($cond as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $update = $query->execute();
                $this->pdo->commit();
                return $update ? $query->rowCount() : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }

    /**
     * Will redirect to th desired url
     *
     * @home_url [param] $home_url
     *
     * @return void
     */
    public function redirect($home_url)
    {
        if (isset($home_url)) {
            header("Location: $home_url");
        }
    }
    // Delete data from database
    /*
    $sql = 'DELETE FROM tableName WHERE id = :id';
    $query = $this->prepare($sql);
    $query->bindValue(".id", $id);
    $query->execute();
    */
    /**
     * Will delete data from database as well as photo from folder
     *
     * @param string $table
     * @param int    $id
     * @param array  $data
     *
     * @return void
     */
    public function deleteDataWithFolderPhoto($table, $id, $data)
    {
        try {
            $this->pdo->beginTransaction();
            // Delete photo from uploads folder
            $query = "SELECT photo FROM $table WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $_GET['id']]);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            while ($photo_data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $del_photo = $photo_data->photo;
                unlink($del_photo);
            }
            if (!empty($data) && is_array($data)) {
                $whereCond .= ' WHERE ';
                $initiator = 0;
                foreach ($data as $key => $value) {
                    $add = ($initiator > 0) ? ' AND ' : '';
                    $whereCond .= "$add" . "$key=:$key";
                    ++$initiator;
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

    /**
     * Will delete data from database
     *
     * @param table $table commented
     * @param data  $data  commented
     *
     * @return void
     */
    public function delete($table, $data)
    {
        try {
            $this->pdo->beginTransaction();
            if (!empty($data) && is_array($data)) {
                $whereCond .= ' WHERE ';
                $initiator = 0;
                foreach ($data as $key => $value) {
                    $add = ($initiator > 0) ? ' AND ' : '';
                    $whereCond .= "$add" . "$key=:$key";
                    ++$initiator;
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
    /**
     * Will search data from database
     *
     * @param string $table
     * @param string $search
     *
     * @return true
     */
    public function searchData($table, $search)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table WHERE title LIKE '%$search%' OR body LIKE '%$search%' AND published_on <= Now() AND status = 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $this->pdo->commit();
            if ($stmt->rowCount() > 0) {
                while ($searchResult = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $searchedData[] = $searchResult;
                }
                return isset($searchedData) ? $searchedData : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Counting the post likes
     *
     * @param string $tableLikes
     * @param int    $articleId
     *
     * @return mixed
     */
    public function countPostLikes($tableLikes, $articleId)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT article_id FROM $tableLikes WHERE article_id = $articleId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $this->pdo->commit();
            if ($stmt->rowCount() > 0) {
                while ($numberOfLikes = $stmt->fetchAll(PDO::FETCH_OBJ)) {
                    $likeData = $numberOfLikes;
                }
                return isset($likeData) ? $likeData : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    
    /**
     * Checks if data exists in database or not
     *
     * @param table $table commented
     *
     * @return rows $table
     */
    public function dataExists($table)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $this->pdo->commit();
            if ($stmt->rowCount() > 0) {
                while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $profileData[] = $data;
                }
                return $profileData;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    
    /**
     * Checks if data exists in database or not
     *
     * @param table $table commented
     *
     * @return rows $table
     */
    public function selectAll($table)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $this->pdo->commit();
            if ($stmt->rowCount() > 0) {
                while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $fetchedData[] = $data;
                }
                return (isset($fetchedData)) ? $fetchedData : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Method to prevent duplicate entry
     *
     * @param string $table
     * @param int $articleId
     * @param string $sessionId
     *
     * @return void
     */
    public function preventDuplicateEntry($table, $articleId, $sessionId, $email)
    {
        $query = "SELECT * FROM $table WHERE article_id = :article_id && session = :session && email =:email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->bindParam(':session', $sessionId);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $stmtExecute = $stmt->fetch(PDO::FETCH_OBJ);
        return ($stmtExecute) ? $stmtExecute : false;
    }

    /**
     * Prevent Duplicate UserRole description
     * @param  string  $table
     * @param  int  $userID
     * @param  int  $role_id
     * @return  mixed
     */
    public function preventDuplicateAdminRole($table)
    {
        $query = "SELECT * FROM $table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $fetchedData[] = $data;
            }
            return (isset($fetchedData)) ? $fetchedData : false;
        }
    }
}

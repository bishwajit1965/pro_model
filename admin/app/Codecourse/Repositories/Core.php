<?php

namespace Codecourse\Repositories;

use Codecourse\Repositories\Database as Database;
use PDO;
use PDOException;

class Core
{
    // Database connection constructor
    private $pdo;

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
    public function select($table, $data = [])
    {
        try {
            $sql = 'SELECT ';
            $sql .= array_key_exists('select', $data) ? $data['select'] : '*';
            $sql .= ' FROM '.$table;
            if (array_key_exists('where', $data)) {
                $sql .= ' WHERE ';
                $i = 0;
                foreach ($data['where'] as $key => $value) {
                    $add = ($i > 0) ? ' AND ' : '';
                    $sql .= "$add"."$key=:$key";
                    ++$i;
                }
            }

            if (array_key_exists('order_by', $data)) {
                $sql .= ' ORDER BY '.$data['order_by'];
            }

            if (array_key_exists('start', $data) && array_key_exists('limit', $data)) {
                $sql .= ' LIMIT '.$data['start'].','.$data['limit'];
            } elseif (array_key_exists('start', $data) && array_key_exists('limit', $data)) {
                $sql .= ' LIMIT '.$data['limit'];
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
            return !empty($value) ? $value : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
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
    public function insert($table, $data)
    {
        try {
            if (!empty($data) && is_array($data)) {
                $keys = '';
                $values = '';
                $keys = implode(',', array_keys($data));
                $values = ':'.implode(', :', array_keys($data));
                $sql = 'INSERT INTO '.$table.'('.$keys.') VALUES ('.$values.')';
                $query = $this->pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $insertedData = $query->execute();
                if ($insertedData) {
                    $lastId = $this->pdo->lastInsertId();
                    return $lastId;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
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
    public function update($table, $id, $data, $cond)
    {
        try {
            // Delete photo from uploads folder
            $query = "SELECT photo FROM $table WHERE article_id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $_GET['aeticle_id']]);
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
                $i = 0;
                foreach ($data as $key => $value) {
                    $add = ($i > 0) ? ' , ' : '';
                    $keyValue .= "$add"."$key=:$key";
                    ++$i;
                }
                if (!empty($cond) && is_array($cond)) {
                    $whereCond .= ' WHERE ';
                    $i = 0;
                    foreach ($cond as $key => $value) {
                        $add = ($i > 0) ? ' AND ' : '';
                        $whereCond .= "$add"."$key=:$key";
                        ++$i;
                    }
                }
                $sql = 'UPDATE '.$table.' SET '.$keyValue.$whereCond;
                $query = $this->pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                foreach ($cond as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $update = $query->execute();
                return $update ? $query->rowCount() : false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Update without photo
    public function updateWithoutPhoto($table, $data, $cond)
    {
        try {
            if (!empty($data) && is_array($data)) {
                $keyValue = '';
                $whereCond = '';
                $i = 0;
                foreach ($data as $key => $value) {
                    $add = ($i > 0) ? ' , ' : '';
                    $keyValue .= "$add"."$key=:$key";
                    ++$i;
                }
                if (!empty($cond) && is_array($cond)) {
                    $whereCond .= ' WHERE ';
                    $i = 0;
                    foreach ($cond as $key => $value) {
                        $add = ($i > 0) ? ' AND ' : '';
                        $whereCond .= "$add"."$key=:$key";
                        ++$i;
                    }
                }
                $sql = 'UPDATE '.$table.' SET '.$keyValue.$whereCond;
                $query = $this->pdo->prepare($sql);

                foreach ($data as $key => $value) {
                    $query->bindValue(":$key", $value);
                }

                foreach ($cond as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
                $update = $query->execute();
                return $update ? $query->rowCount() : false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Redirecting URL to the desired page
    public function redirect($home_url)
    {
        header("Location: $home_url");
    }

    // Delete data from database
    /*
    $sql = 'DELETE FROM tableName WHERE id = :id';
    $query = $this->prepare($sql);
    $query->bindValue(".id", $id);
    $query->execute();
    */
    public function deleteDataWithFolderPhoto($table, $id, $data)
    {
        try {
           // Delete photo from uploads folder
            $query = "SELECT photo FROM $table WHERE article_id = :id";
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
                $i = 0;
                foreach ($data as $key => $value) {
                    $add = ($i > 0) ? ' AND ' : '';
                    $whereCond .= "$add"."$key=:$key";
                    ++$i;
                }
            }
            $sql = 'DELETE FROM ' . $table . $whereCond;
            $query = $this->pdo->prepare($sql);
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $delete = $query->execute();
            return $delete ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Delete only data
    public function delete($table, $id, $data)
    {
        try {
            if (!empty($data) && is_array($data)) {
                $whereCond .= ' WHERE ';
                $i = 0;
                foreach ($data as $key => $value) {
                    $add = ($i > 0) ? ' AND ' : '';
                    $whereCond .= "$add"."$key=:$key";
                    ++$i;
                }
            }
            $sql = 'DELETE FROM ' . $table . $whereCond;
            $query = $this->pdo->prepare($sql);
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $delete = $query->execute();
            return $delete ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;

class FrontEnd extends Core
{
    // Database connection constructor
    private $pdo;
    /**
     * Constructor to connect to database
     */
    public function __construct()
    {
        $database = new Database();
        $dbConnection = $database->dbConnection();
        $this->pdo = $dbConnection;
    }
    /**
     * Will fetch data from database to show as well to paginate
     *
     * @param String $query 
     *  
     * @return void  
     */
    public function frontEndDataAndPagination($query)
    {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $articleData[] = $data;
                }
                $this->pdo->commit();
                return !empty($articleData) ? $articleData : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Will get paging data
     *
     * @param string $table 
     * @param int    $records_per_page commented
     *
     * @return void
     */
    public function paging($table, $records_per_page)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table WHERE published_on <= NOW() && status = 0 ORDER BY id DESC";
            $starting_position = 0;
            if (isset($_GET["page_no"])) {
                $starting_position = ($_GET["page_no"] - 1) * $records_per_page;
            }
            $query2 = $query . " limit $starting_position, $records_per_page";
            $this->pdo->commit();
            return $query2;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }

    /**
     * Will generate pagination
     *
     * @param string $table 
     * @param int    $records_per_page 
     *
     * @return void
     */
    public function pagingLink($table, $records_per_page)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table WHERE published_on <= NOW() && status = 0";
            $self = $_SERVER['PHP_SELF'];
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $this->pdo->commit();
            $total_no_of_records = $stmt->rowCount();
            if ($total_no_of_records > 0) { ?>
                <ul class="pagination">
                    <?php
                    $total_no_of_pages = ceil($total_no_of_records / $records_per_page);
                    $current_page = 1;
                    if (isset($_GET["page_no"])) {
                        $current_page = $_GET["page_no"];
                    }
                    if ($current_page != 1) {
                        $previous = $current_page - 1;
                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?page_no=1'>First</a></li>";
                        echo "<li><a class='page-link' href='" . $self . "?page_no=" . $previous . "'>Previous</a></li>";
                    }
                    for ($i = 1; $i <= $total_no_of_pages; $i++) {
                        if ($i == $current_page) {
                            echo "<li class='page-item'><a class='page-link' href='" . $self . "?page_no=" . $i . "'
                                style='color:red; background-color:#D9EDF7;'> " . $i . "</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='" . $self . "?page_no=" . $i . "'>" . $i . "</a></li>";
                        }
                    }
                    if ($current_page != $total_no_of_pages) {
                        $next = $current_page + 1;
                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?page_no=" . $next . "'>Next</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?page_no=" . $total_no_of_pages . "'>Last</a></li>";
                    } ?>
                </ul>
                <?php
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Will generate th URL
     *
     * @param string $homeUrl 
     *
     * @return void
     */
    public function redirect($homeUrl)
    {
        header("Location: $homeUrl");
    }
    /**
     * Will select random data from article table
     *
     * @param string $table commented
     *
     * @return void
     */
    public function selectRandomArticle($table)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table WHERE published_on <= NOW() && status = 0 ORDER BY RAND() LIMIT 16";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($randomData = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $randomArticle[] = $randomData;
                }
                $this->pdo->commit();
                return !empty($randomArticle) ? $randomArticle : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Select data from database
     *
     * @param string $table 
     *
     * @return void
     */
    public function selectData($table)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table LIMIT 1";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($randomData = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $randomArticle[] = $randomData;
                }
                $this->pdo->commit();
                return !empty($randomArticle) ? $randomArticle : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Will insert like in article table 
     * 
     * @param string $table   
     * @param int    $lid 
     * @param int    $likeCount 
     *
     * @return void
     */
    public function likePost($table, $lid, $likeCount)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "UPDATE $table SET like_count = $likeCount WHERE id = $lid";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam('like_count', $likeCount);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($randomData = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $randomArticle[] = $randomData;
                }
                $this->pdo->commit();
                return !empty($randomArticle) ? $randomArticle : false;
            }
            
        }catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }
    /**
     * Delete data from database
     *
     * @param string $table 
     * @param array  $data  
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
     * Will select data from database
     *
     * @param string $table
     * @param array  $data
     *
     * @return void
     */
    public function selectMarqueeData($table, $data = [])
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

}

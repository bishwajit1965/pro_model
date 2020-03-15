<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;

class FrontEnd extends Core
{
    // Database connection constructor
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $dbConnection = $database->dbConnection();
        $this->pdo = $dbConnection;
    }
    /**
     * Will fetch data from database to show as well to paginate
     *
     * @param  String $query 
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
     * @param string $home_url 
     *
     * @return void
     */
    public function redirect($home_url)
    {
        header("Location: $home_url");
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
     * @param int    $id 
     * @param int    $likeCount 
     *
     * @return void
     */
    public function likePost($table, $id, $likeCount)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "UPDATE $table SET like_count = $likeCount WHERE id = $id";
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
}

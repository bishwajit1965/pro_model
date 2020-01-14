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

    public function frontEndDataAndPagination($query)
    {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                    #1dac10de$articleData[] = $data;
                }
                $this->pdo->commit();
                return !empty($articleData) ? $articleData : false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
        }
    }

    //Pagination begins
    public function paging($table, $records_per_page)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "SELECT * FROM $table WHERE published_on <= NOW() && status = 0";
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
     * Will redirect header as desired
     *
     * @param [type] $home_url
     * @return void
     */
    public function redirect($home_url)
    {
        header("Location: $home_url");
    }
}

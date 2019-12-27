<?php
require_once '../app/start.php';

use Codecourse\Repositories\Category as Category;
use Codecourse\Repositories\Session as Session;
use Codecourse\Repositories\Helpers as Helpers;

$category = new Category();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_category';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $category_name = $helpers->validate($_POST['category_name']);
                        // Validation
                        if (empty($category_name)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Category field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                            Session::set('message', $message);
                            $home_url = 'addCategory.php';
                            $category->redirect("$home_url");
                        } else {
                            // Insertable data associative array
                            $fields = [
                            'category_name' => $category_name
                            ];
                            $insertedData = $category->insert($table, $fields);
                            // validation messages and page redirects
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Category has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'categoryIndex.php';
                                $category->redirect("$home_url");
                            }
                        }
                    }
                }
            }
        }
        break;


    case 'update':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['submit'])) {
                            $id = $_POST['category_id'];
                            $category_name = $helpers->validate($_POST['category_name']);
                            $fields = [
                                'category_name' => $category_name
                            ];
                            $condition = ['category_id' => $id];
                            $updateStatus = $category->updateWithoutPhoto($table, $fields, $condition);
                            // validation messages and page redirects
                            if ($updateStatus) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Category has been updated successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'categoryIndex.php';
                                $category->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> WARNING !!!</strong> Category has not been updated successfully. No data has been provided !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'categoryIndex.php';
                                $category->redirect("$home_url");
                            }
                        }
                    }
                }
            }
        }
        break;
    case 'delete':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $id = $_POST['category_id'];
                        $condition = [
                            'category_id' => $id
                        ];
                        $deleteStatus = $category->delete($table, $id, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Category data has been deleted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'categoryIndex.php';
                            $category->redirect("$home_url");
                        }
                    }
                }
            }
        }
        break;

    default:
        // code...
        break;
}

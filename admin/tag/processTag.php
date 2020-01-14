<?php
require_once '../app/start.php';

use CodeCourse\Repositories\Tag as Tag;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Helpers as Helpers;

$tag = new Tag();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_tag';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $tag_name = $helpers->validate($_POST['tag_name']);
                        $category_id = $helpers->validate($_POST['category_id']);
                        // Validation
                        if (empty($tag_name)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Tag field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addTag.php';
                            $tag->redirect("$home_url");
                        } elseif (empty($category_id)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Category field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addTag.php';
                            $tag->redirect("$home_url");
                        } else {
                            // Insertable data associative array
                            $fields = [
                                'tag_name' => $tag_name,
                                'category_id' => $category_id
                            ];
                            $insertedData = $tag->insert($table, $fields);
                            // validation messages and page redirects
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Category has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
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
                            $id = $_POST['tag_id'];
                            $tag_name = $helpers->validate($_POST['tag_name']);
                            $category_id = $helpers->validate($_POST['category_id']);
                            $fields = [
                                'tag_name' => $tag_name,
                                'category_id' => $category_id
                            ];
                            $condition = ['tag_id' => $id];
                            if (empty($tag_name)) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Tag name field was left empty !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
                            } elseif (empty($category_id)) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Category id field field was left empty !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
                            } else {
                                $updateStatus = $tag->updateWithoutPhoto($table, $fields, $condition);
                                // validation messages and page redirects
                                if ($updateStatus) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Category has been updated successfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'tagIndex.php';
                                    $tag->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Tag has not been updated successfully. No data has been provided !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'tagIndex.php';
                                    $tag->redirect("$home_url");
                                }
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
                        $id = $_POST['tag_id'];
                        $condition = [
                            'tag_id' => $id
                        ];
                        $deleteStatus = $tag->delete($table, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Tag data has been deleted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'tagIndex.php';
                            $tag->redirect("$home_url");
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

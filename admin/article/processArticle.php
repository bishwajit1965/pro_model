<?php
require_once '../app/start.php';

use Codecourse\Repositories\Article as Article;
use Codecourse\Repositories\Session as Session;
use Codecourse\Repositories\Helpers as Helpers;

$article = new Article();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_article';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $title = $helpers->validate($_POST['title']);
                        $body = $helpers->validate($_POST['body']);
                        $author = $helpers->validate($_POST['author']);
                        $category_id = $helpers->validate($_POST['category_id']);
                        $tag_id = $helpers->validate($_POST['tag_id']);
                        $status = $helpers->validate($_POST['status']);
                        $published_on = $helpers->validate($_POST['published_on']);
                        $permitted = ['jpg', 'jpeg', 'png', 'gif'];
                        $file_name = $_FILES['photo']['name'];
                        $file_size = $_FILES['photo']['size'];
                        $file_temp = $_FILES['photo']['tmp_name'];
                        $div = explode('.', $file_name);
                        $file_ext = strtolower(end($div));
                        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                        $photo = "uploads/" . $unique_image;
                        if (!empty($file_name)) {
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Title field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addarticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($body)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Author field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addarticle.php';
                                $article->redirect("$home_url");
                            } else {
                                 // Insertable data associative array
                                $fields = [
                                'title' => $title,
                                'body' => $body,
                                'author' => $author,
                                'category_id' => $category_id,
                                'tag_id' => $tag_id,
                                'status' => $status,
                                'published_on' => $published_on,
                                'photo' => $photo
                                ];
                                $insertedData = $article->insert($table, $fields);
                                // validation messages and page redirects
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
	                                <strong> WOW !</strong> Category has been inserted successsfully !!!
	                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                                </button>
	                                </div>';
                                    Session::set('message', $message);
                                    $home_url = 'articleIndex.php';
                                    $article->redirect("$home_url");
                                }
                            }
                        } else {
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Title field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addarticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($body)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Aurhor field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addarticle.php';
                                $article->redirect("$home_url");
                            } else {
                                // Insertable data associative array
                                $fields = [
                                    'title' => $title,
                                    'body' => $body,
                                    'author' => $author,
                                    'category_id' => $category_id,
                                    'tag_id' => $tag_id,
                                    'status' => $status,
                                    'published_on' => $published_on
                                ];
                                $insertedData = $article->insert($table, $fields);
                                // validation messages and page redirects
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
	                                <strong> WOW !</strong> Category has been inserted successsfully !!!
	                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                                </button>
	                                </div>';
                                    Session::set('message', $message);
                                    $home_url = 'articleIndex.php';
                                    $article->redirect("$home_url");
                                }
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
                            $fields = [
                                'tag_name' => $tag_name
                            ];
                            $condition = ['tag_id' => $id];
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
                        $deleteStatus = $tag->delete($table, $id, $condition);
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

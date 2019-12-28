<?php
require_once '../app/start.php';

use Codecourse\Repositories\Article as Article;
use Codecourse\Repositories\Session as Session;
use Codecourse\Repositories\Helpers as Helpers;

$article = new Article();
$helpers = new Helpers();
Session::init();
// Table
$table = 'tbl_articles';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // User specific session received
                        if (isset($_POST['user_session'])) {
                            $user_session = $_POST['user_session'];
                        }
                        // Insertable field with validation
                        $title = $helpers->validate($_POST['title']);
                        $body = $helpers->validate($_POST['body']);
                        $author = $helpers->validate($_POST['author']);
                        $category_id = $helpers->validate($_POST['category_id']);
                        $tag_id = $helpers->validate($_POST['tag_id']);
                        $status = $helpers->validate($_POST['status']);
                        $published_on = $helpers->validate($_POST['published_on']);
                        // Photo
                        $permitted = ['jpg', 'jpeg', 'png', 'gif'];
                        $file_name = $_FILES['photo']['name'];
                        $file_size = $_FILES['photo']['size'];
                        $file_temp = $_FILES['photo']['tmp_name'];
                        $div = explode('.', $file_name);
                        $file_ext = strtolower(end($div));
                        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                        $photo = "uploads/" . $unique_image;
                        if (!empty($file_name)) {
                             // Insertable data associative array
                            $fields = [
                                'title' => $title,
                                'body' => $body,
                                'author' => $author,
                                'category_id' => $category_id,
                                'tag_id' => $tag_id,
                                'status' => $status,
                                'published_on' => $published_on,
                                'photo' => $photo,
                                'user_session' => $user_session
                            ];
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Title field is left blank 1234!!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($body)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Article content field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($author)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Author field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($category_id)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Category  field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($tag_id)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Tag  field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (!isset($status)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Status  field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (!isset($status)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Status  field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } else {
                                $insertedData = $article->insert($table, $fields);
                                move_uploaded_file($file_temp, $photo);
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !</strong> Article has been inserted successsfully !!!
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
                            // Insertable data associative array
                            $fields = [
                                'title' => $title,
                                'body' => $body,
                                'author' => $author,
                                'category_id' => $category_id,
                                'tag_id' => $tag_id,
                                'status' => $status,
                                'published_on' => $published_on,
                                'user_session' => $user_session
                            ];
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Title field is left blank 555555!!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($body)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Article content field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } elseif (empty($author)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> WOW !</strong> Author field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addArticle.php';
                                $article->redirect("$home_url");
                            } else {
                                $insertedData = $article->insert($table, $fields);
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !</strong> Article has been inserted successsfully !!!
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
                            if (isset($_POST['article_id'])) {
                                $id = $_POST['article_id'];
                            }
                            // Insertable field with validation
                            $title = $helpers->validate($_POST['title']);
                            $body = $helpers->validate($_POST['body']);
                            $author = $helpers->validate($_POST['author']);
                            $category_id = $helpers->validate($_POST['category_id']);
                            $tag_id = $helpers->validate($_POST['tag_id']);
                            $status = $helpers->validate($_POST['status']);
                            $published_on = $helpers->validate($_POST['published_on']);
                            // Photo
                            $permitted = ['jpg', 'jpeg', 'png', 'gif'];
                            $file_name = $_FILES['photo']['name'];
                            $file_size = $_FILES['photo']['size'];
                            $file_temp = $_FILES['photo']['tmp_name'];
                            $div = explode('.', $file_name);
                            $file_ext = strtolower(end($div));
                            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                            $photo = "uploads/" . $unique_image;

                            if (!empty($file_name)) {
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
                                $condition = [
                                    'article_id' => $id
                                ];
                                // $whereCond = ['where' => ['article_id' => $id]];
                                $updateStatus = $article->update($table, $id, $fields, $condition);
                                move_uploaded_file($file_temp, $photo);
                                // validation messages and page redirects
                                if ($updateStatus) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Article has been updated successfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'articleIndex.php';
                                    $article->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Article has not been updated successfully. No data has been provided !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'articleIndex.php';
                                    $article->redirect("$home_url");
                                }
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
                                $condition = ['article_id' => $id];
                                $updateStatus = $article->updateWithoutPhoto($table, $fields, $condition);
                                // validation messages and page redirects
                                if ($updateStatus) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Article has been updated successfully with previously uploaded photo !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'articleIndex.php';
                                    $article->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Article has not been updated successfully. No data has been provided !!!
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
    case 'delete':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $id = $_POST['article_id'];
                        $condition = [
                            'article_id' => $id
                        ];
                        $whereCond = ['where' => ['article_id' => '$id']];
                        if (isset($_POST['article_id'])) {
                            $id = $_POST['article_id'];
                        }
                        $condition = [
                            'article_id' => $id
                        ];
                        $deleteStatus = $article->deleteDataWithFolderPhoto($table, $id, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Article data has been deleted successfully !!!
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
        break;

    default:
        // code...
        break;
}

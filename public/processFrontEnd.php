<?php
// Class loader
require_once '../admin/app/start.php';

// Class included
use CodeCourse\Repositories\Article as Article;
use CodeCourse\Repositories\FrontEnd as FrontEnd;
use CodeCourse\Repositories\Like as Like;
use CodeCourse\Repositories\Session as Session;

// Classes instantiated
$article = new Article();
$frontEnd = new FrontEnd();
$like = new Like();
Session::init();

// Table to be operated on
$table = 'tbl_articles';
$tableLikes = 'tbl_likes';

if (isset($_POST['submit'])) {
    $accessor = $_POST['submit'];
    switch ($accessor) {
    case 'category':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Category data !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'index.php';
                        $frontEnd->redirect("$home_url");
                    }
                }
            }
        }
        break;
    case 'tag':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Tag data !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'index.php';
                        $frontEnd->redirect("$home_url");
                    }
                }
            }
        }
        break;
    case 'archive':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Archived data !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'index.php';
                        $frontEnd->redirect("$home_url");
                    }
                }
            }
        }
        break;
    case 'like':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }
                        $like_post = $_POST['like_count'];
                        if (isset($_GET['like_count'])) {
                            $like_count = $_POST['like_count'];
                        }
                        if (isset($_POST['user_session'])) {
                            $sessionId = $_POST['user_session'];
                        }
                        $fields = [
                        'id' => $id,
                        'like_count' => $like_post,
                        'user_session' => $sessionId
                        ];
                        $data = [
                            'article_id' => $id,
                            'email' => Session::get('login'),
                            'session' => $sessionId,
                            'token_code' => md5($id)
                        ];
                        // var_dump($data);
                        // die();

                        $whereCond = [
                        'id' => $id,
                        'user_session' => $sessionId
                        ];
                        $likeData = $like->insert($tableLikes, $data);
                        // var_dump($likeData);
                        // die();
                        $frontEndData = $article->updateWithoutPhoto($table, $fields, $whereCond);
                        $home_url = 'index.php';
                        $frontEnd->redirect("$home_url");
                        break;

                        if (isset($_POST['single-post-submit'])) {
                            $accessor = $_POST['single-post-submit'];
                            switch ($accessor) {
                            case 'single-post-like':
                                $frontEndData = $article->updateWithoutPhoto($table, $fields, $whereCond);
                                $home_url = 'singlePost.php';
                                $frontEnd->redirect("$home_url");
                                break;
                            
                            default:
                                $frontEndData = $article->updateWithoutPhoto($table, $fields, $whereCond);
                                $home_url = 'index.php';
                                $frontEnd->redirect("$home_url");
                                break;
                            }
                            
                        }
                        
                    }
                }
            }
        }
        break;
    default:
        break;
    }
}

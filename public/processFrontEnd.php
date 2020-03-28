<?php
/**
 * Class loader 
 */
require_once '../admin/app/start.php';

// Class included
use CodeCourse\Repositories\Article as Article;
use CodeCourse\Repositories\FrontEnd as FrontEnd;
use CodeCourse\Repositories\Like as Like;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Viewers as Viewers;

// Classes instantiated
$article = new Article();
$frontEnd = new FrontEnd();
$likes = new Like();
$viewers = new Viewers();
Session::init();

// Table to be operated on
$table = 'tbl_articles';
$tableLikes = 'tbl_likes';
$tableViewers = 'tbl_viewers';

// Session Id
$sessionId = session_id();
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
                        $data = [
                            'article_id' => $id,
                            'email' => Session::get('login'),
                            'session' => session_id(),
                            'viewers_id' => Session::get('id'),
                            'token' => md5(Session::get('id'))
                        ];
                        // Selecting all data from like table
                        $likeData = $likes->preventDuplicateEntry($tableLikes, $id, $sessionId);
                        // Matching data to check if liked
                        if ($likeData->article_id == $id && $likeData->session == $sessionId) {
                            $message ='<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>SORRY !!!</strong> You have already liked this post !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $frontEnd->redirect($home_url);
                        } else { 
                            $dataLikes = $likes->insert($tableLikes, $data);
                            $message ='<div class="alert alert-success alert-dismissible" role="alert">
                            <strong>SUCCESSFUL !!!</strong> You have successfully liked this post !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $frontEnd->redirect($home_url); 
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
                        // Catches article id of like table
                        if (isset($_POST['article_id'])) {
                            $articleId = $_POST['article_id'];
                        }
                        // Catches current viewers id
                        if (isset($_POST['viewers_id'])) {
                            $viewers_id = $_POST['viewers_id'];
                        }
                        // Catches current viewers email
                        if (isset($_POST['email'])) {
                            $email = $_POST['email'];
                        }
                        // Catches current viewers session
                        if (isset($_POST['session'])) {
                            $session = $_POST['session'];
                        }
                        // Conditions imposed to delete/dislike current viewers  
                        // like data for the post/posts he/she has liked in the
                        // current session
                        $conditions = [
                            'article_id' => $articleId,
                            'viewers_id' => $viewers_id,
                            'email' => $email,
                            'session' => $session 
                        ];
                        
                        $frontEnd->delete($tableLikes,  $conditions);
                        $message ='<div class="alert alert-danger alert-dismissible" role="alert"">
                            <strong>LOOK !!!</strong> Like data has been deleted !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'index.php';
                        $frontEnd->redirect($home_url);
                    }
                }
            }
        }
        break;
    default:
        break;
    }
}

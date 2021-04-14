<?php
/**Class loader*/
require_once '../admin/app/start.php';

// Class included
use CodeCourse\Repositories\Article as Article;
use CodeCourse\Repositories\FrontEnd as FrontEnd;
use CodeCourse\Repositories\Like as Like;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Viewers as Viewers;
use CodeCourse\Repositories\ViewersSessions as ViewersSessions;

// Classes instantiated
$article = new Article();
$frontEnd = new FrontEnd();
$likes = new Like();
$viewers = new Viewers();
$viewersSessions = new ViewersSessions();
Session::init();

// Table to be operated on
$table = 'tbl_articles';
$tableLikes = 'tbl_likes';
$tableViewers = 'tbl_viewers';
$tableSessions = 'tbl_session';

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
                        // Post id
                        if (isset($_POST['post_id'])) {
                            $id = $_POST['post_id'];
                        }
                        // As post value expires after redirected to 
                        //processFrontEnd.php post_id is set to
                        //  session to retrieve it
                        $postId = Session::set('post_id', $id);
                        
                        // Post_id is got
                        $sessionPostId = Session::get('post_id');
                        
                        // Session Id
                        $sessionId = session_id();
                        // Logged in viewers mail address
                        
                        $email = Session::get('login');
                        // Data to be inserted in the tbl_likes
                        $data = [
                            'article_id' => $id,
                            'email' => Session::get('login'),
                            'session' => session_id(),
                            'viewers_id' => Session::get('id'),
                            'token' => md5(Session::get('login'))
                        ];
                        // Fetching session_id() of the viewer from tbl_session
                        $viewersSession = $viewersSessions->select($tableSessions);
                        if (!empty($viewersSession)) {
                            foreach ($viewersSession as $sessionData) {
                                
                            }
                        }
                        // Selecting all data from like table
                        $likeData = $likes->preventDuplicateEntry($tableLikes, $id, $sessionId, $email);
                        // Matching data to check if the post has been 
                        //liked before or not
                        if (isset($_POST['like'])) {
                            $accessorKey = $_POST['like'];
                        }
                        // Switched as per uri request
                        switch ($accessorKey) {
                        case 'single-post-like':
                            $viewersSession = $viewersSessions->select($tableSessions);
                            if ($likeData->article_id == $id && $sessionData->session == $likeData->session && $likeData->email == $email) {
                                $message ='<div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>SORRY !!!</strong> You have already liked this post !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = "singlePost.php?post_id=$sessionPostId";
                                $frontEnd->redirect("$home_url");
                            } else { 
                                $dataLikes = $likes->insert($tableLikes, $data);
                                $message ='<div class="alert alert-success alert-dismissible" role="alert">
                                <strong>SUCCESSFUL !!!</strong> You have successfully liked this post !!! Thank you !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = "singlePost.php?post_id=$sessionPostId";
                                $frontEnd->redirect("$home_url"); 
                            }    
                            break;
                        case 'index-page-like':
                            if ($likeData->article_id == $id && $likeData->session == $sessionId && $likeData->email == $email) {
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
                                <strong>SUCCESSFUL !!!</strong> You have successfully liked this post !!! Thank you !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'index.php';
                                $frontEnd->redirect($home_url); 
                            }    
                            
                            break;
                        
                        default:
                            # code...
                            break;
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
                        // Catches post_id from like as is sent
                        if (isset($_POST['post_id'])) {
                            $id = $_POST['post_id'];
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
                        $postId = Session::set('post_id', $id);
                        
                        // Post_id is got
                        $sessionPostId = Session::get('post_id');

                        // Conditions imposed to delete/dislike current viewers  
                        // like data for the post/posts he/she has liked in the
                        // current session
                        $conditions = [
                            'article_id' => $id,
                            'viewers_id' => $viewers_id,
                            'email' => $email,
                            'session' => $session 
                        ];
                        // Initiates the switch accessor
                        if (isset($_POST['dislike'])) {
                            $accessorKey = $_POST['dislike'];
                        }
                        // Switches as per Uri request
                        switch ($accessorKey) {
                        case 'single-post-dislike':
                            $frontEnd->delete($tableLikes,  $conditions);
                            $message ='<div class="alert alert-danger alert-dismissible" role="alert"">
                                <strong>SORRY !!!</strong> You have disliked the post !!! Yet thank you for reading !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = "singlePost.php?post_id=$sessionPostId";
                            $frontEnd->redirect($home_url);
                            break;
                        case 'index-page-dislike':
                            $frontEnd->delete($tableLikes,  $conditions);
                            $message ='<div class="alert alert-danger alert-dismissible" role="alert"">
                                <strong>SORRY !!!</strong> You have disliked the post !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $frontEnd->redirect($home_url);
                            break;
                        default:
                            # code...
                            break;
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

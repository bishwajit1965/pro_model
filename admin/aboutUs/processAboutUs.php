<?php
require_once '../app/start.php';

use CodeCourse\Repositories\AboutUs as AboutUs;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Session as Session;

$aboutUs = new AboutUs();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_about_us';

// Accessor to switch CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'insert':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    //Insert table field with validation
                    $about_us = $helpers->validation($_POST['about_us']);
                    // Validation
                    if (empty($about_us)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> About us field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        Session::set('message', $message);
                        $home_url = 'addAboutUs.php';
                        $aboutUs->redirect("$home_url");
                    } else {
                        $fields = [
                            'about_us' => $about_us
                        ];
                        $insertedData = $aboutUs->insert($table, $fields);
                        // validation messages and page redirects
                        if ($insertedData) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> About us data has been inserted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'aboutUsIndex.php';
                            $aboutUs->redirect("$home_url");
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
                        $id = $_POST['id'];
                        $about_us = $helpers->validation($_POST['about_us']);
                        $fields = ['about_us' => $about_us];
                        $condition = ['id' => $id];
                        $updateStatus = $aboutUs->updateWithoutPhoto($table, $fields, $condition);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> About us data has been updated successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'aboutUsIndex.php';
                            $aboutUs->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WARNING !!!</strong> About us data has not been updated successfully. No data has been provided !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'aboutUsIndex.php';
                            $aboutUs->redirect("$home_url");
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
                    $id = $_POST['id'];
                    $condition = [
                        'id' => $id
                    ];
                    $deleteStatus = $aboutUs->delete($table, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> About us data has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'aboutUsIndex.php';
                        $aboutUs->redirect("$home_url");
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

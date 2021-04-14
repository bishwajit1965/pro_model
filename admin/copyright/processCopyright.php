<?php

require_once '../app/start.php';

use CodeCourse\Repositories\Copyright as Copyright;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Session as Session;

$copyright = new Copyright();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_copyright';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'insert':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    // Insertable field with validation
                    $copyright_text = $helpers->validation($_POST['copyright_text']);
                    // Validation
                    if (empty($copyright_text)) {
                        $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !!!</strong> Copyright text field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        Session::set('message', $message);
                        $home_url = 'addCopyright.php';
                        $copyright->redirect("$home_url");
                    } else {
                        // Insertable data associative array
                        $fields = [
                            'copyright_text' => $copyright_text
                        ];
                        $insertedData = $copyright->insert($table, $fields);
                        // validation messages and page redirects
                        if ($insertedData) {
                            $message = '<div class="alert alert-success alert-dismissible" role="alert">
                            <strong> WOW !</strong> Category has been inserted successsfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'copyrightIndex.php';
                            $copyright->redirect("$home_url");
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
                        $copyright_text = $helpers->validation($_POST['copyright_text']);
                        $fields = [
                            'copyright_text' => $copyright_text
                        ];
                        $condition = ['id' => $id];
                        $updateStatus = $copyright->updateWithoutPhoto($table, $fields, $condition);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> Copyright text has been updated successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'copyrightIndex.php';
                            $copyright->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WARNING !!!</strong> Copyright text has not been updated successfully. No data has been provided !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'copyrightIndex.php';
                            $copyright->redirect("$home_url");
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
                    $deleteStatus = $copyright->delete($table, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Copyright text data has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'copyrightIndex.php';
                        $copyright->redirect("$home_url");
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

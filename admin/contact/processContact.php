<?php
require_once '../app/start.php';

use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Contact as Contact;
use CodeCourse\Repositories\Session as Session;

$contact = new Contact();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_contact';

// Accessor to switch CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'archive':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    // Insert field with validation
                    $role_name = $helpers->validation($_POST['role_name']);
                    // Validation
                    if (empty($role_name)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Role field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        Session::set('message', $message);
                        $home_url = 'createRole.php';
                        $role->redirect("$home_url");
                    } else {
                        // Insert data associative array
                        $fields = [
                            'role_name' => $role_name
                        ];
                        $insertedData = $role->insert($table, $fields);
                        // validation messages and page redirects
                        if ($insertedData) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Category has been inserted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'roleIndex.php';
                            $role->redirect("$home_url");
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
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];   
                        }
                        $status = $helpers->validation($_POST['status']);
                        $fields = [
                            'status' => $status
                        ];
                        $whereCond = ['id' => $id];
                        $updateStatus = $contact->updateWithoutPhoto($table, $fields, $whereCond);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> This contact message is published to for public view !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'contactIndex.php';
                            $contact->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> SORRY !!!</strong>Encountered an error !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';

                            Session::set('message', $message);
                            $home_url = 'contactIndex.php';
                            $contact->redirect("$home_url");
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
                    $deleteStatus = $contact->delete($table, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Message has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'contactndex.php';
                        $contact->redirect("$home_url");
                    } else {
                        $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                        <strong> SORRY !</strong>Something is wrong. Message has not been deleted !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'contactndex.php';
                        $contact->redirect("$home_url");
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

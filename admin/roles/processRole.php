<?php
require_once '../app/start.php';

use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Role as Role;
use CodeCourse\Repositories\Session as Session;

$role = new Role();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_roles';

// Accessor to switch CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'insert':
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
                        $id = $_POST['role_id'];
                        $role_name = $helpers->validation($_POST['role_name']);
                        $fields = [
                            'role_name' => $role_name
                        ];
                        $condition = ['role_id' => $id];
                        $updateStatus = $role->updateWithoutPhoto($table, $fields, $condition);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> Role has been updated successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'roleIndex.php';
                            $role->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> Role has been not been updated !!!
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
case 'delete':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    $id = $_POST['role_id'];
                    $condition = [
                        'role_id' => $id
                    ];
                    $deleteStatus = $role->delete($table, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Role data has been deleted successfully !!!
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
    break;

default:
    // code...
    break;
}

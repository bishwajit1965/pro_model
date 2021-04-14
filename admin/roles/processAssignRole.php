<?php
require_once '../app/start.php';

use CodeCourse\Repositories\Admins as Admins;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Role as Role;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\UserAssignedRoles as UserAssignedRoles;
use CodeCourse\Repositories\UserRole as UserRole;

$role = new Role();
$helpers = new Helpers();
$assignUserRole = new userRole;
$userAssignedRole = new UserAssignedRoles;
Session::init();
$sessionId = session_id();
$tableUserRole = 'tbl_user_role';
$tableRole = 'tbl_roles';

// Accessor to switch CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'assign-user-role':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    // Insert field with validation
                    if (isset($_POST['userID'])) {
                        $userId = $_POST['userID'];
                    }
                    $roleId = $_POST['role_id'];
                    if (empty($userId)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> User id field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'assignRole.php';
                        $userAssignedRole->redirect("$home_url");
                    } elseif (empty($roleId)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Role id field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'assignRole.php';
                        $userAssignedRole->redirect("$home_url");
                    } else {
                        // Insert data associative array
                        $fields = [
                            'userID' => $userId,
                            'role_id' => $roleId
                        ];
                        //Fetching data to check duplicate admin role
                        $fetchedData = $userAssignedRole->preventDuplicateAdminRole($tableUserRole);
                        // Prevents duplicate admin role entry
                        if (!empty($fetchedData)) {
                            foreach ($fetchedData as $roleData) {
                                if ($roleData->userID == $userId && $roleData->role_id == $roleId) {
                                    $message = '<div class="alert alert-info alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> This user role has already been assigned !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'userIndex.php';
                                    $userAssignedRole->redirect("$home_url");
                                }
                            }
                        } else {
                            // Insert user role
                            $roleAssigned = $userAssignedRole->insert($tableUserRole, $fields);
                            // Validation messages and page redirects
                            if ($roleAssigned) {
                                $message = '<div class="alert alert-success alert-dismissible" role="alert">
                                <strong> WOW !</strong> User roles have been assigned successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'userIndex.php';
                                $userAssignedRole->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> SORRY !</strong> User roles have not been inserted !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'userIndex.php';
                                $userAssignedRole->redirect("$home_url");
                            }
                        }
                    }
                }
            }
        }
    }
    break;
    
case 'update-user-role':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['userID'])) {
                            $id = $_POST['userID'];
                        }
                        $role_id = $_POST['role_id'];
                        // $role_name = $helpers->validation($_POST['role_name']);
                        $fields = [
                            'userID' => $id,
                            'role_id' => $role_id
                        ];
                        $condition = ['userID' => $id];
                        $updateStatus = $userAssignedRole->updateWithoutPhoto($tableUserRole, $fields, $condition);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> Role has been updated successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'userIndex.php';
                            $userAssignedRole->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WOW !!!</strong> Role has been not been updated !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';

                            Session::set('message', $message);
                            $home_url = 'userIndex.php';
                            $userAssignedRole->redirect("$home_url");
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
                    $id = $_POST['userID'];
                    $condition = [
                        'userID' => $id
                    ];
                    $deleteStatus = $userAssignedRole->delete($tableUserRole, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Role data has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'userIndex.php';
                        $userAssignedRole->redirect("$home_url");
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

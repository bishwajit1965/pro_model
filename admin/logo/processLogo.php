<?php

require_once '../app/start.php';

use CodeCourse\Repositories\Logo as Logo;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Session as Session;

$logo = new Logo();
$helpers = new Helpers();
Session::init();
// Table
$table = 'tbl_logo';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'insert':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    // Insertable field with validation
                    $description = $helpers->validate($_POST['description']);
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
                            'description' => $description,
                            'photo' => $photo
                        ];
                        if (empty($description)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Description field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addLogo.php';
                            $logo->redirect("$home_url");
                        } else {
                            $logoData = $logo->insert($table, $fields);
                            move_uploaded_file($file_temp, $photo);
                            if ($logoData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Logo has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'logoIndex.php';
                                $logo->redirect("$home_url");
                            }
                        }
                    } else {
                        // Insertable data associative array
                        $fields = [
                            'description' => $description,
                        ];
                        if (empty($description)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Description field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addLogo.php';
                            $logo->redirect("$home_url");
                        } else {
                            $logoData = $logo->insert($table, $fields);
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Description has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'logoIndex.php';
                                $logo->redirect("$home_url");
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
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }
                        // Insertable field with validation
                        $description = $helpers->validation($_POST['description']);
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
                                'description' => $description,
                                'photo' => $photo
                            ];
                            $condition = [
                                'id' => $id
                            ];
                            if (empty($description)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Title field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editLogo.php';
                                $logo->redirect("$home_url");
                            } else {
                                // Will update data with photo
                                $updateStatus = $logo->update($table, $id, $fields, $condition);
                                move_uploaded_file($file_temp, $photo);
                                // Validation messages and page redirects
                                if ($updateStatus) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Logo has been updated successfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'logoIndex.php';
                                    $logo->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Logo has not been updated successfully.
                                    No data has been provided !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'logoIndex.php';
                                    $logo->redirect("$home_url");
                                }
                            }
                        } else {
                            // Insertable data associative array
                            $fields = [
                                'description' => $description
                            ];
                            $condition = ['id' => $id];
                            if (empty($description)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Description field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editLogo.php';
                                $logo->redirect("$home_url");
                            } else {
                                $updateStatus = $logo->updateWithoutPhoto($table, $fields, $condition);
                                // validation messages and page redirects
                                if ($updateStatus == true) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Logo has been updated successfully with previously uploaded photo !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'logoIndex.php';
                                    $logo->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Logo has not been updated successfully.
                                    No data has been provided !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'logoIndex.php';
                                    $logo->redirect("$home_url");
                                }
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
                    $id = $_POST['id'];
                    $condition = [
                        'id' => $id
                    ];

                    $deleteStatus = $logo->deleteDataWithFolderPhoto($table, $id, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Logo data has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'logoIndex.php';
                        $logo->redirect("$home_url");
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

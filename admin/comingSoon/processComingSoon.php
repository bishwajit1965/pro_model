<?php
/**
 * Includes class starter file
*/
require_once '../app/start.php';

use CodeCourse\Repositories\ComingSoon as ComingSoon;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Session as Session;

$comingSoon = new ComingSoon();
$helpers = new Helpers();
Session::init();
// Table to be operated upon
$table = 'tbl_ComingSoon';

// Accessor to switch CRUD options in switch
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
                    $title = $helpers->validation($_POST['title']);
                    $description = $helpers->validation($_POST['description']);
                    $status = $helpers->validation($_POST['status']);
                    $published_on = $helpers->validation($_POST['published_on']);
                    // Photo
                    $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
                    $file_name = $_FILES['photo']['name'];
                    $file_size = $_FILES['photo']['size'];
                    $file_temp = $_FILES['photo']['tmp_name'];
                    // Get Image extension
                    // $imgExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                    $photo = "uploads/" . $unique_image;
                    if (!empty($file_name)) {
                        // Insertable data associative array
                        $fields = [
                            'title' => $title,
                            'description' => $description,
                            'status' => $status,
                            'published_on' => $published_on,
                            'photo' => $photo,
                            'user_session' => $user_session
                        ];
                        if (empty($title)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Title field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addComingSoon.php';
                            $comingSoon->redirect("$home_url");
                        } elseif (empty($description)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Photo description field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addComingSoon.php';
                            $comingSoon->redirect("$home_url");
                        } elseif (!isset($status)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Photo status  field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addComingSoon.php';
                            $comingSoon->redirect("$home_url");
                        } else {
                            // Checks a valid photo
                            if (in_array($file_ext, $allowedExtension)) {
                                // Checks if the file size is not bigger than 5MB
                                if ($file_size < 5000000) {
                                    // Will insert data
                                    $insertedData = $comingSoon->insert($table, $fields);
                                    move_uploaded_file($file_temp, $photo);
                                } else {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> File size is more than 5 MB !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'addComingSoon.php';
                                    $comingSoon->redirect("$home_url");
                                }
                            } else {
                                $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                                <strong> SORRY !</strong> This is not a right file type. Only JPG, JPEG, PNG !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addComingSoon.php';
                                $comingSoon->redirect("$home_url");
                            }
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Photo has been inserted successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
                            }
                        }
                    } else {
                        // Insertable data associative array
                        $fields = [
                            'title' => $title,
                            'description' => $description,
                            'status' => $status,
                            'published_on' => $published_on,
                            'user_session' => $user_session
                        ];
                        if (empty($title)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Title field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addComingSoon.php';
                            $comingSoon->redirect("$home_url");
                        } elseif (empty($description)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> SORRY !</strong> Photo description field is left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addComingSoon.php';
                            $comingSoon->redirect("$home_url");
                        } else {
                            $insertedData = $comingSoon->insert($table, $fields);
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Photo has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
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
                        // Insert table field with validation
                        $title = $helpers->validation($_POST['title']);
                        $description = $helpers->validation($_POST['description']);
                        $status = $helpers->validation($_POST['status']);
                        $published_on = $helpers->validation($_POST['published_on']);
                        $updated_at = $helpers->validation($_POST['updated_at']);
                        // Photo related code
                        $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
                        $file_name = $_FILES['photo']['name'];
                        $file_size = $_FILES['photo']['size'];
                        $file_temp = $_FILES['photo']['tmp_name'];
                        $div = explode('.', $file_name);
                        $file_ext = strtolower(end($div));
                        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                        $photo = "uploads/" . $unique_image;
                        // Checks if photo has been included or not
                        if (!empty($file_name)) {
                            // Insertable data associative array
                            $fields = [
                                'title' => $title,
                                'description' => $description,
                                'status' => $status,
                                'published_on' => $published_on,
                                'updated_at' => $updated_at,
                                'photo' => $photo
                            ];
                            $condition = [
                                'id' => $id
                            ];
                            // Checks a valid photo
                            if (in_array($file_ext, $allowedExtension)) {
                                // Checks if the file size is not bigger than 5MB
                                if ($file_size < 5000000) {
                                    // Will update data with photo
                                    $updateStatus = $comingSoon->update($table, $id, $fields, $condition);
                                    move_uploaded_file($file_temp, $photo);
                                } else {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> File size is more than 5 MB !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'addComingSoon.php';
                                    $comingSoon->redirect("$home_url");
                                }
                            } else {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> This is not a right file type. Only JPG, JPEG, PNG !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addComingSoon.php';
                                $comingSoon->redirect("$home_url");
                            }
                            // Validation messages and page redirects
                            if ($updateStatus) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Photo in ComingSoon has been updated successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> WARNING !!!</strong> Photo in ComingSoon has not been updated successfully. No data has been provided !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
                            }
                        } else {
                            // Insertable data associative array
                            $fields = [
                                'title' => $title,
                                'description' => $description,
                                'status' => $status,
                                'published_on' => $published_on,
                                'updated_at' => $updated_at
                            ];
                            $condition = ['id' => $id];
                            $updateStatus = $comingSoon->updateWithoutPhoto($table, $fields, $condition);
                            // validation messages and page redirects
                            if ($updateStatus) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Photo in ComingSoon has been updated successfully with previously uploaded photo !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> WARNING !!!</strong> Article has not been updated successfully. No data has been provided !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'ComingSoonIndex.php';
                                $comingSoon->redirect("$home_url");
                            }
                        }
                    }
                }
            }
        }
    }
    break;
case 'publish':
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
                        $updateStatus = $comingSoon->updateWithoutPhoto($table, $fields, $whereCond);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> SUCCESS !!!</strong> Article has been publishes successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'ComingSoonIndex.php';
                            $comingSoon->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WARNING !!!</strong> Article has not been published !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'ComingSoonIndex.php';
                            $comingSoon->redirect("$home_url");
                        }
                    }
                }
            }
        }
    }
    break;
case 'unpublish':
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
                        $updateStatus = $comingSoon->updateWithoutPhoto($table, $fields, $whereCond);
                        // validation messages and page redirects
                        if ($updateStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> SUCCESS !!!</strong> Article has been unpublished successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'ComingSoonIndex.php';
                            $comingSoon->redirect("$home_url");
                        } else {
                            $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                            <strong> WARNING !!!</strong> Article has not been unpublished !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'ComingSoonIndex.php';
                            $comingSoon->redirect("$home_url");
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
                    if (isset($_POST['id'])) {
                        $id = $_POST['id'];
                    }
                    $condition = [
                        'id' => $id
                    ];
                    $deleteStatus = $comingSoon->deleteDataWithFolderPhoto($table, $id, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message ='<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Photo in ComingSoon has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'ComingSoonIndex.php';
                        $comingSoon->redirect("$home_url");
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

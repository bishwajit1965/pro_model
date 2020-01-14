<?php
require_once '../app/start.php';

use CodeCourse\Repositories\Header as Header;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Session as Session;

$header = new Header();
$helpers = new Helpers();
Session::init();
// Table
$table = 'tbl_header';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $title = $helpers->validate($_POST['title']);
                        $slogan = $helpers->validate($_POST['slogan']);
                        $email = $helpers->validate(filter_var($_POST['email']), FILTER_VALIDATE_EMAIL);
                        $phone = $helpers->validate($_POST['phone']);
                        $created_at = $helpers->validate($_POST['created_at']);
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
                                'title' => $title,
                                'slogan' => $slogan,
                                'email' => $email,
                                'phone' => $phone,
                                'created_at' => $created_at,
                                'photo' => $photo
                            ];
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Title field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($slogan)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Site slogan field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($email)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Email field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($phone)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Phone field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } else {
                                $insertedData = $header->insert($table, $fields);
                                move_uploaded_file($file_temp, $photo);
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !</strong> Article has been inserted successsfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'headerIndex.php';
                                    $header->redirect("$home_url");
                                }
                            }
                        } else {
                            // Insertable data associative array
                            $fields = [
                                'title' => $title,
                                'slogan' => $slogan,
                                'email' => $email,
                                'phone' => $phone,
                                'created_at' => $created_at,
                            ];
                            if (empty($title)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Title field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($slogan)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Site slogan field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($email)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Email field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } elseif (empty($phone)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> SORRY !</strong> Phone field is left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'addHeader.php';
                                $header->redirect("$home_url");
                            } else {
                                $insertedData = $header->insert($table, $fields);
                                if ($insertedData) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !</strong> Article has been inserted successsfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'headerIndex.php';
                                    $header->redirect("$home_url");
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
                            $title = $helpers->validate($_POST['title']);
                            $slogan = $helpers->validate($_POST['slogan']);
                            $email = $helpers->validate(filter_var($_POST['email']), FILTER_VALIDATE_EMAIL);
                            $phone = $helpers->validate($_POST['phone']);
                            $created_at = $helpers->validate($_POST['created_at']);
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
                                    'title' => $title,
                                    'slogan' => $slogan,
                                    'email' => $email,
                                    'phone' => $phone,
                                    'created_at' => $created_at,
                                    'photo' => $photo
                                ];
                                $condition = [
                                    'id' => $id
                                ];
                                if (empty($title)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Title field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($slogan)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Site slogan field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($email)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Email field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($phone)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Phone field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } else {
                                    // Will update data with photo
                                    $updateStatus = $header->update($table, $id, $fields, $condition);
                                    move_uploaded_file($file_temp, $photo);
                                    // Validation messages and page redirects
                                    if ($updateStatus) {
                                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                        <strong> WOW !!!</strong> Header has been updated successfully !!!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                        Session::set('message', $message);
                                        $home_url = 'headerIndex.php';
                                        $header->redirect("$home_url");
                                    } else {
                                        $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                        <strong> WARNING !!!</strong> Header has not been updated successfully.
                                        No data has been provided !!!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                        Session::set('message', $message);
                                        $home_url = 'headerIndex.php';
                                        $header->redirect("$home_url");
                                    }
                                }
                            } else {
                                // Insertable data associative array
                                $fields = [
                                    'title' => $title,
                                    'slogan' => $slogan,
                                    'email' => $email,
                                    'phone' => $phone,
                                    'created_at' => $created_at
                                ];
                                $condition = ['id' => $id];
                                if (empty($title)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Title field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($slogan)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Site slogan field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($email)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Email field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } elseif (empty($phone)) {
                                    $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                    <strong> SORRY !</strong> Phone field is left blank !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'editHeader.php';
                                    $header->redirect("$home_url");
                                } else {
                                    $updateStatus = $header->updateWithoutPhoto($table, $fields, $condition);
                                    // validation messages and page redirects
                                    if ($updateStatus == true) {
                                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                        <strong> WOW !!!</strong> Header has been updated successfully with previously uploaded photo !!!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                        Session::set('message', $message);
                                        $home_url = 'headerIndex.php';
                                        $header->redirect("$home_url");
                                    } else {
                                        $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                        <strong> WARNING !!!</strong> Header has not been updated successfully.
                                        No data has been provided !!!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                        Session::set('message', $message);
                                        $home_url = 'headerIndex.php';
                                        $header->redirect("$home_url");
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
                        $id = $_POST['header_id'];
                        $condition = [
                            'id' => $id
                        ];
                        $whereCond = ['where' => ['id' => '$id']];
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }
                        $condition = [
                            'id' => $id
                        ];
                        $deleteStatus = $header->delete($table, $id, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Header data has been deleted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'headerIndex.php';
                            $header->redirect("$home_url");
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

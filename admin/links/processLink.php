<?php

require_once '../app/start.php';

use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Link as Link;
use CodeCourse\Repositories\Session as Session;

// Classes instantiated
$link = new Link();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();

// Table to be operated upon
$table = 'tbl_link';

// Accessor to switch CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
case 'insert':
    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'verify') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {
                    // Insertable field with validation
                    $title = $helpers->validation($_POST['title']);
                    $email = $helpers->validation(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
                    $phone = $helpers->validation($_POST['phone']);
                    $url = $helpers->validation($_POST['url']);
                    $address = $helpers->validation($_POST['address']);
                    $zipcode = $helpers->validation($_POST['zipcode']);
                    $country = $helpers->validation($_POST['country']);
                    // Validation
                    if (empty($title)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Title field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($email)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Email field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($phone)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Phone field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($url)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Url field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($address)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Address field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($zipcode)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Zipcode field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } elseif (empty($country)) {
                        $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                        <strong> ERROR !!!</strong> Country field was left blank !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'addLink.php';
                        $link->redirect("$home_url");
                    } else {
                        // Insertable data associative array
                        $fields = [
                            'title' => $title,
                            'email' => $email,
                            'phone' => $phone,
                            'url' => $url,
                            'address' => $address,
                            'zipcode' => $zipcode,
                            'country' => $country
                        ];
                        $insertedData = $link->insert($table, $fields);
                        // validation messages and page redirects
                        if ($insertedData) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Link data has been inserted successsfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'linkIndex.php';
                            $link->redirect("$home_url");
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
                        $title = $helpers->validation($_POST['title']);
                        $email = $helpers->validation(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
                        $phone = $helpers->validation($_POST['phone']);
                        $url = $helpers->validation($_POST['url']);
                        $address = $helpers->validation($_POST['address']);
                        $zipcode = $helpers->validation($_POST['zipcode']);
                        $country = $helpers->validation($_POST['country']);
                        $fields = [
                            'title' => $title,
                            'email' => $email,
                            'phone' => $phone,
                            'url' => $url,
                            'address' => $address,
                            'zipcode' => $zipcode,
                            'country' => $country
                        ];
                        $condition = ['id' => $id];
                        if (empty($title)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Title field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'editLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($email)) {
                                $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Email field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'editLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($phone)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Phone field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'editLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($url)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Url field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'editLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($address)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Address field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'editLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($zipcode)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Zipcode field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addLink.php';
                            $link->redirect("$home_url");
                        } elseif (empty($country)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Country field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addLink.php';
                            $link->redirect("$home_url");
                            } else {
                            $updateStatus = $link->updateWithoutPhoto($table, $fields, $condition);
                            // validation messages and page redirects
                            if ($updateStatus) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Link data has been updated successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'linkIndex.php';
                                $link->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> WARNING !!!</strong> Link data has not been updated successfully. No data has been provided !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'linkIndex.php';
                                $link->redirect("$home_url");
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
                    $deleteStatus = $link->delete($table, $condition);
                    // validation messages and page redirects
                    if ($deleteStatus) {
                        $message = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong> WOW !</strong> Link data has been deleted successfully !!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'linkIndex.php';
                        $link->redirect("$home_url");
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

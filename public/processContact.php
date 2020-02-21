<?php
// Class loader
require_once '../admin/app/start.php';

// Class included
use CodeCourse\Repositories\Contact as Contact;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Helpers as Helpers;

// Classes instantiated
$contact = new Contact();
$helpers = new Helpers();
Session::init();

// Table to be operated on
$table = 'tbl_contact';

if (isset($_POST['submit'])) {
    $accessor = $_POST['submit'];
    switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $first_name = $helpers->validate($_POST['first_name']);
                        $last_name = $helpers->validate($_POST['last_name']);
                        $email = $helpers->validate($_POST['email']);
                        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                        $phone = $helpers->validate($_POST['phone']);
                        $message = $helpers->validate($_POST['message']);
                        $address = $helpers->validate($_POST['address']);
                        // Fields to be uploaded
                        $fields = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'phone' => $phone,
                        'message' => $message,
                        'address' => $address,
                        ];
                        if (empty($first_name)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> First name field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } elseif (empty($last_name)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> Last name field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } elseif (empty($email)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> Email field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } elseif (empty($phone)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> Phone field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } elseif (empty($message)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> Message field field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } elseif (empty($address)) {
                            $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <strong> ERROR !</strong> Message field field was left empty !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'index.php';
                            $contact->redirect("$home_url");
                        } else {
                            $insertedData = $contact->insert($table, $fields);
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible" role="alert">
                                <strong> WOW !</strong> Message has been sent successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'index.php';
                                $contact->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                                <strong> ERROR !</strong> Message has not been sent successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'index.php';
                                $contact->redirect("$home_url");
                            }
                        }
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
    default:
        # code...
        break;
    }
}

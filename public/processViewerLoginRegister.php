<?php
// Class loader
require_once '../admin/app/start.php';

// Classes are called
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\LoginCustomer as LoginCustomer;
use CodeCourse\Repositories\Register as Register;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Viewers as Viewers;
use CodeCourse\Repositories\ViewersSessions as ViewersSessions;

// Classes instantiated
Session::init();
$register = new Register();
$loginCustomer = new LoginCustomer();
$helpers = new Helpers();
$viewers = new Viewers();
$viewersSessions = new ViewersSessions();

// Table to be operated upon
$table = 'tbl_viewers';
$tableSession = 'tbl_session';
$articlesTable = 'tbl_articles';

if (isset($_POST['submit'])) {
    $accessor = $_POST['submit'];
    switch ($accessor) {
    case 'login':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        try {
                            $email = $_POST['email'];
                            $email = $helpers->validation(filter_var($email, FILTER_VALIDATE_EMAIL));
                            $password = $_POST['password'];
                            $password = $helpers->validation($password);
                            if (empty($_POST['email'])) {
                                $message ='<div class="alert alert-danger" role="alert">
                                <span class="alert-heading">SORRY !!! Empty email field !</span>
                                </div>';
                                Session::set('message', $message);
                                $url = 'login.php';
                                $loginCustomer->redirect("$url");
                            } elseif (empty($_POST['password'])) {
                                $message ='<div class="alert alert-danger" role="alert">
                                <span class="alert-heading">SORRY !!! Empty password field !</span>
                                </div>';
                                Session::set('message', $message);
                                $url = 'login.php';
                                $loginCustomer->redirect("$url");
                            } else {
                                $loginData = $loginCustomer->logIn($email, $table);
                                if ($loginData->email == $email && $loginData->password == md5($password)) {
                                    Session::init();
                                    Session::set('login', true);
                                    Session::set('id', $loginData->id);
                                    $value = $_POST['email'];
                                    Session::set('login', $value);
                                    // Code to insert session data into tbl_session
                                    $session = session_id();
                                    if (isset($session)) {
                                        $fields = [
                                            'email' => $value,
                                            'session' => $session
                                        ];
                                        // Will store data in sessions table
                                        $viewersSessions->insert($tableSession, $fields);
                                        $home_url = 'index.php';
                                        Session::redirect("$home_url");
                                    }
                                } else {
                                    $home_url = 'login.php';
                                    Session::redirect("$home_url?logInError");
                                }
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
            }
        }
        break;
    case 'log_out':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        Session::destroy();
                        session_unset();
                        $home_url = 'index.php';
                        Session::redirect("$home_url");
                    }
                }
            }
        }
        break;
    case 'register':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        $first_name = $helpers->validation($_POST['first_name']);
                        $last_name = $helpers->validation($_POST['last_name']);
                        $email = $helpers->validation($_POST['email']);
                        $email = $helpers->validation(filter_var($email, FILTER_VALIDATE_EMAIL));
                        $phone = $helpers->validation($_POST['phone']);
                        $address = $helpers->validation($_POST['address']);
                        $city = $helpers->validation($_POST['city']);
                        $zip_code = $helpers->validation($_POST['zip_code']);
                        $country = $helpers->validation($_POST['country']);
                        $password = $helpers->validation($_POST['password']);
                        $confirm_password = $helpers->validation($_POST['confirm_password']);
                        if ($_POST['password'] == $_POST['confirm_password']) {
                            $password = $password;
                            $password = md5($_POST['password']);
                            $fields = [
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
                                'phone' => $phone,
                                'address' => $address,
                                'city' => $city,
                                'zip_code' => $zip_code,
                                'country' => $country,
                                'password' => $password,
                            ];
                            if (empty($first_name)) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> First name empty !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (empty($last_name)) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Last name empty !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Email address empty !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (empty($password)) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Password field left empty !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (strlen($password) < 6) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Password should be at least 6 chars !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (empty($confirm_password)) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Confirm password field left empty !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } elseif (strlen($confirm_password) < 6) {
                                $message = '<div class="alert alert-danger" role="alert">
                                <strong class="alert-heading">SORRY !!!</strong>
                                <span class="mb-0"> Confirm password should be at least 6 chars !!!</span>
                            </div>';
                                Session::set('message', $message);
                                $home_url = 'register.php';
                                $register->redirect("$home_url");
                            } else {
                                $viewersData = $register->store($fields, $table);
                                if ($viewersData) {
                                    $message = '<div class="alert alert-success" role="alert">
                                    <strong class="alert-heading">SUCCESSFUL !!!</strong>
                                    <span class="mb-0"> Data entered successfully !!!</span>
                                </div>';
                                    Session::set('message', $message);
                                    if ($viewersData) {
                                        $home_url = 'register.php';
                                        Session::redirect("$home_url");
                                    }
                                }
                            }
                        } else {
                            $message ='<div class="alert alert-danger" role="alert">
                            <strong class="alert-heading">SORRY !!!</strong>
                            <span class="mb-0"> Password mismatch !!!</span>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'register.php';
                            $register->redirect("$home_url");
                        }
                    }
                }
            }
        }
        break;
    case 'update-customer':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['edit_customer_id'])) {
                            $editCustomertId = $_POST['edit_customer_id'];
                            $first_name = $helpers->validation($_POST['first_name']);
                            $last_name = $helpers->validation($_POST['last_name']);
                            $email = $helpers->validation($_POST['email']);
                            $phone = $helpers->validation($_POST['phone']);
                            $address = $helpers->validation($_POST['address']);
                            $city = $helpers->validation($_POST['city']);
                            $zip_code = $helpers->validation($_POST['zip_code']);
                            $country = $helpers->validation($_POST['country']);
                            $password = $password;
                            $password = md5($_POST['password']);
                            $fields = [
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
                                'phone' => $phone,
                                'address' => $address,
                                'city' => $city,
                                'zip_code' => $zip_code,
                                'country' => $country,
                                'password' => $password,
                            ];
                            if (empty($first_name)) {
                                $message = '<div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">SORRY !!!</h4>
                                <p class="mb-0"> First name empty !!!</p>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editCustomerProfile.php';
                                $customerProfile->redirect("$home_url");
                            } elseif (empty($last_name)) {
                                $message = '<div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">SORRY !!!</h4>
                                <p class="mb-0"> Last name empty !!!</p>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editCustomerProfile.php';
                                $customerProfile->redirect("$home_url");
                            } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $message = '<div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">SORRY !!!</h4>
                                <p class="mb-0"> Email address empty !!!</p>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editCustomerProfile.php';
                                $customerProfile->redirect("$home_url");
                            } else {
                                $customerProfileData = $customerProfile->updateWithoutPhoto($fields, $editCustomertId, $tableCustomer);
                                if ($customerProfileData) {
                                    $message =
                                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>WOW !</strong> Customer profile data has been updated successfully.
                                        </div>';
                                    Session::set('message', $message);
                                    if ($customerProfileData) {
                                        $home_url = 'customerProfileIndex.php';
                                        Session::redirect("$home_url");
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
                        $id = $_POST['delete_customer_id'];
                        $customerProfile->destroy($id, $tableCustomer);
                        $message = '<div class="alert alert-danger alert-dismissible" role="alert"">
                            <strong>LOOK !!!</strong> Cart data has been deleted!!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                        Session::set('message', $message);
                        $home_url = 'customerProfileIndex.php';
                        $customerProfile->redirect($home_url);
                    }
                }
            }
        }
        break;

    default:
        #...
        break;
    }
}

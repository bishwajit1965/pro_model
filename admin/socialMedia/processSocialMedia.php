<?php
require_once '../app/start.php';

use Codecourse\Repositories\Helpers as Helpers;
use Codecourse\Repositories\Session as Session;
use Codecourse\Repositories\SocialMedia as SocialMedia;

$socialMedia = new SocialMedia();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_social_media';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $name = $helpers->validate($_POST['name']);
                        // Validation message
                        if (empty($name)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong> ERROR !!!</strong> Social media name field was left blank !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'addSocialMedia.php';
                            $socialMedia->redirect("$home_url");
                        } else {
                            // Insertable data associative array
                            $fields = [
                                'name' => $name
                            ];
                            $insertedData = $socialMedia->insert($table, $fields);
                            // validation messages and page redirects
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Social media data has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'socialMediaIndex.php';
                                $socialMedia->redirect("$home_url");
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
                            $name = $helpers->validate($_POST['name']);
                            $fields = [
                                'name' => $name
                            ];
                            $condition = ['id' => $id];
                            if (empty($name)) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Social media name field was left empty !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'editSocialMedia.php';
                                $socialMedia->redirect("$home_url");
                            } else {
                                $updateStatus = $socialMedia->updateWithoutPhoto($table, $fields, $condition);
                                // validation messages and page redirects
                                if ($updateStatus) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !!!</strong> Social media data has been updated successfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'socialMediaIndex.php';
                                    $socialMedia->redirect("$home_url");
                                } else {
                                    $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                    <strong> WARNING !!!</strong> Social media data has not been updated successfully.
                                    No data has been provided !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'socialMediaIndex.php';
                                    $socialMedia->redirect("$home_url");
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
                        $deleteStatus = $socialMedia->delete($table, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Sicial media data has been deleted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'socialMediaIndex.php';
                            $socialMedia->redirect("$home_url");
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

<?php
require_once '../app/start.php';

use Codecourse\Repositories\Tag as Tag;
use Codecourse\Repositories\Session as Session;
use Codecourse\Repositories\Helpers as Helpers;

$tag = new Tag();
$helpers = new Helpers();
Session::init();
$sessionId = session_id();
$table = 'tbl_tag';

// Accessor to swith CRUD options in switch
$accessor = $_POST['submit'];
switch ($accessor) {
    case 'insert':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        // Insertable field with validation
                        $tag_name = $helpers->validate($_POST['tag_name']);
                        // Validation
                        if (empty($tag_name)) {
                            $message = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> ERROR !!!</strong> Tag field was left blank !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                            Session::set('message', $message);
                            $home_url = 'addTag.php';
                            $tag->redirect("$home_url");
                        } else {
                            // Insertable data associative array
                            $fields = [
                            'tag_name' => $tag_name
                            ];
                            $insertedData = $tag->insert($table, $fields);
                            // validation messages and page redirects
                            if ($insertedData) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !</strong> Category has been inserted successsfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
                            }
                        }
                    }
                }
            }
        }
        break;
    case 'select':
        if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'verify') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['submit'])) {
                            if (isset($_POST['order_id']) && isset($_POST['pro_price']) && isset($_POST['ordered_on']) && isset($_POST['status'])) {
                                // Verifies and matches all the fields then updates
                                $order_id = $cart->validate($_POST['order_id']);
                                $pro_price = $cart->validate($_POST['pro_price']);
                                $ordered_on = $cart->validate($_POST['ordered_on']);
                                $ordered_status = $cart->validate($_POST['status']);
                                // Revoke staus in orders table
                                $statusUpdated = $cart->revokeOrderStatus($tableOrders, $order_id, $pro_price, $ordered_on, $ordered_status);
                                // validation messages and page redirects
                                if ($statusUpdated) {
                                    $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                    <strong> WOW !</strong> Ordered status has been rovoked successfully !!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                    Session::set('message', $message);
                                    $home_url = 'inbox.php';
                                    $cart->redirect("$home_url");
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
                            $id = $_POST['tag_id'];
                            $tag_name = $helpers->validate($_POST['tag_name']);
                            $fields = [
                                'tag_name' => $tag_name
                            ];
                            $condition = ['tag_id' => $id];
                            $updateStatus = $tag->updateWithoutPhoto($table, $fields, $condition);
                            // validation messages and page redirects
                            if ($updateStatus) {
                                $message = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong> WOW !!!</strong> Category has been updated successfully !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
                            } else {
                                $message = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong> WARNING !!!</strong> Tag has not been updated successfully. No data has been provided !!!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                Session::set('message', $message);
                                $home_url = 'tagIndex.php';
                                $tag->redirect("$home_url");
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
                        $id = $_POST['tag_id'];
                        $condition = [
                            'tag_id' => $id
                        ];
                        $deleteStatus = $tag->delete($table, $id, $condition);
                        // validation messages and page redirects
                        if ($deleteStatus) {
                            $message = '<div class="alert alert-success alert-dismissible " role="alert">
                            <strong> WOW !</strong> Tag data has been deleted successfully !!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            Session::set('message', $message);
                            $home_url = 'tagIndex.php';
                            $tag->redirect("$home_url");
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

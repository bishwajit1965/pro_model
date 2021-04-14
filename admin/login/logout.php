<?php

// session_start();

require_once '../app/start.php';

use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\User as User;

Session::init();

$user = new User();

if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}

if ($user->is_logged_in() != '') {
    $user->logout();
    $user->redirect('index.php');
}

<?php

// session_start();

require_once '../app/start.php';
use Codecourse\Repositories\User as User;
use Codecourse\Repositories\Session as Session;

Session::init();

$user = new User();

if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}

if ($user->is_logged_in() != '') {
    $user->logout();
    $user->redirect('index.php');
}

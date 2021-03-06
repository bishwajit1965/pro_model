<?php
ob_start();
require_once '../admin/app/start.php';
use CodeCourse\Repositories\Session as Session;
Session::init();

// Detects file name
$path = $_SERVER['SCRIPT_FILENAME'];
if (isset($path)) {
    $current_page = basename($path, '.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project Model || <?= ucfirst($current_page); ?> page </title>
    <!-- Favicon -->
    <link rel="icon" href="img/favicon/favicon1.ico" type="image/x-icon" />

    <!-- Meta Data -->
    <meta name="Welcome" content="<?php echo 'All are most welcome';?>">
    
    <!-- /Meta Data -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <!-- Font awesome kit-->
    <script src="https://kit.fontawesome.com/1b551efcfa.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
</head>
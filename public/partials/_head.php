<?php
ob_start();

// Detects file name
$path = $_SERVER['SCRIPT_FILENAME'];
if (isset($path)) {
    $current_page = basename($path, '.php');
}
// Class loader
require_once '../admin/app/start.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project Model || <?= ucfirst($current_page); ?> page </title>
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon/favicon1.ico" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <!-- Font awesome kit-->
    <script src="https://kit.fontawesome.com/1b551efcfa.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Allura&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    
    <style>
        .color {
            color: #FFF;
        }

        .navbar {
            z-index: 999;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .sticky+.main-content {
            padding-top: 60px;
        }
    </style>
</head>
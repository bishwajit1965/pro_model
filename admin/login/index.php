<?php
// session_start();
require_once '../app/start.php';

use CodeCourse\Repositories\User as User;
use CodeCourse\Repositories\Session as Session;

Session::init();
$user_login = new User();
if ($user_login->is_logged_in() != '') {
    $user_login->redirect('home.php');
}
if (isset($_POST['btn-login'])) {
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtupass']);
    if ($user_login->login($email, $upass)) {
        $user_login->redirect('home.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login | Aroma</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin </b> Login </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            if (isset($_GET['inactive'])) {
            ?>
                <div class='alert alert-error'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    <strong>SORRY!!</strong> This Account is not Activated Go to your Inbox and Activate it.
                </div>
            <?php
            }
            ?>
            <form method="post">
                <?php
                if (isset($_GET['error'])) {
                ?>
                    <div class='alert alert-success'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Wrong Details!</strong>
                    </div>
                <?php
                }
                ?>
                <div class="form-group has-feedback">
                    <input type="email" name="txtemail" class="form-control" placeholder="Email address">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="txtupass" class="form-control" placeholder="Password" required="required">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <button type="submit" class="btn btn-sm btn-primary" name="btn-login">
                    <span class="glyphicon glyphicon-log-in"></span> Login</button>
                <a href="signup.php" class="btn btn-sm btn-success pull-right">
                    <span class="glyphicon glyphicon-plus"></span> Signup</a>
            </form>

            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>
                    Sign in using
                    Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i>
                    Sign in using
                    Google+</a>
            </div>
            <!-- /.social-auth-links -->
            <a href="fpass.php">I forgot my password</a><br>
            <a href="signup.php" class="text-center">Register a new membership</a>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery 3 -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>

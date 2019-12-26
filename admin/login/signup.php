<?php
require_once '../app/start.php';
use Codecourse\Repositories\User as User;
use Codecourse\Repositories\Session as Session;

Session::init();
$reg_user = new User();
if ($reg_user->is_logged_in() != '') {
    $reg_user->redirect('home.php');
}
if (isset($_POST['btn-signup'])) {
    $uname = trim($_POST['txtuname']);
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtpass']);
    $code = md5(uniqid(rand()));
    $stmt = $reg_user->runQuery('SELECT * FROM tbl_users WHERE userEmail=:email_id');
    $stmt->execute(array(':email_id' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $msg = "<div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Sorry !</strong>  email allready exists , Please Try another one
</div>";
    } else {
        if ($reg_user->register($uname, $email, $upass, $code)) {
            $id = $reg_user->lasdID();
            $key = base64_encode($id);
            $id = $key;
            $message = "
Hello $uname,
<br/><br/>
Welcome to Aroma!<br/>
To complete your registration  please , just click following link<br/>
<br /><br />
<a href='http://localhost/aroma/admin/verify.php?id=$id & code=$code'>Click HERE to Activate :)</a>
<br /><br />
Thanks,";
            $subject = 'Confirm Registration';
            $reg_user->send_mail($email, $message, $subject);
            $msg = "
<div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Success!</strong>  We've sent an email to $email.
    Please click on the confirmation link in the email to create your account.
</div>";
        } else {
            echo 'sorry , Query could not be executed...';
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup | Model</title>
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
        <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="../../index2.html"><b>Admin </b>Sign up</a>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">Register a new membership</p>
                <?php if (isset($msg)) {
                    echo $msg;
                }  ?>
                <form class="form-signin" method="post">
                    <!-- <h2 class="form-signin-heading">Sign Up</h2><hr /> -->
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Username" name="txtuname" required />
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <!--  <select name="txtuname" class="form-control">
                        <option value="">Username</option>
                        <option value="0">Admin</option>
                        <option value="1">Editor</option>
                        <option value="2">Author</option>
                    </select><br> -->
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="txtpass" required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                    Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                    Google+</a>
                </div>
                <a href="index.php" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <script>
        $(function () {
        $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
        });
        });
        </script>
    </body>
</html>

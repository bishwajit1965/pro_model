<?php
// session_start();

require_once '../app/start.php';
use CodeCourse\Repositories\User as User;
use CodeCourse\Repositories\Session as Session;

Session::init();

$user = new User();
if ($user->is_logged_in() != '') {
    $user->redirect('home.php');
}

if (isset($_POST['btn-submit'])) {
    $email = $_POST['txtemail'];

    $stmt = $user->runQuery('SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1');

    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        $id = base64_encode($row['userID']);
        $code = md5(uniqid(rand()));
        $stmt = $user->runQuery('UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email');
        $stmt->execute(array(':token' => $code, 'email' => $email));

        $message = "Hello , $email
        <br/><br/>
        We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore this email,
        <br/><br/>
        Click Following Link To Reset Your Password
        <br /><br />
        <a href='http://localhost/collResult/admin/login/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
        <br /><br />
        thank you :)
        ";
        $subject = 'Password Reset';

        $user->send_mail($email, $message, $subject);

        $msg = "<div class='alert alert-success'>
        <button class='close' data-dismiss='alert'>&times;</button>
        We've sent an email to $email.
        Please click on the password reset link in the email to generate new password.
        </div>";
    } else {
        $msg = "<div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Sorry!</strong>  this email not found.
        </div>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password</title>
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
                <a href="#"><b>Reset</b> Password</a>
            </div>
            <div class="register-box-body">
                <div class='alert alert-info'>
                    Please enter your email address. You will receive a link to create a new password via email.!
                </div>
                <?php if (isset($msg)) {
                    echo $msg;
                }  ?>
                <form class="form-signin" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                             <button class="btn btn-danger" type="submit" name="btn-submit">Generate new Password</button>
                        </div>
                    </div>
                </form>
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
    </body>
</html>


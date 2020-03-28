<?php

require_once '../admin/app/start.php';

use CodeCourse\Repositories\Session as Session;

?>
<!doctype html>
<html lang="en">

    <head>
        <title>Log in</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/1b551efcfa.js"></script>
        <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            /* background-image: url(img/background/background12.jpg);
            background-repeat: no-repeat; */
        }

        .container {
            width: 50%;
            max-height: px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
        }

        h5 {
            text-transform: uppercase;
            text-align: center;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #DDD;
            border-top: none;
            border-right: none;
            border-left: none;
            display: block;
            width: 100%;
            height: 30px;
            padding-left: 5px;
            background-color: #F8F9FA;
        }

        :focus {
            outline: none;
        }

        .form-group {
            display: flex;
        }

        .form-group input {
            width: 50%;
        }

        .input-group-text {
            border-bottom: 1px solid#DDD;
            background-color: #F8F9FA;
            border-right: none;
            border-top: none;
        }

        .forgot-pass a {
            text-decoration: none;
            color: #919191;
            font-size: 12px;
        }
        </style>
    </head>

    <body class="vh-100 d-flex align-items-center col justify-content-center">
        <div class="container bg-light">
            <div class="row pt-3 pb-3">
                <div class="col-sm-6 image-cover-left">
                    <img class="img-fluid img-responsive" style="width:100%;height:260px;border-radius: 5px;"
                        src="img/background/sunRise.jpg" alt="">
                </div>
                <div class="col-sm-6 form-input-area">
                    <h5>Readers' Log in</h5>
                    <div class="messages">
                        <?php
                        Session::init();
                        
                        if (isset($_GET['logInError'])) {
                            $message = '<div class="alert alert-danger" role="alert">
                                <span class="alert-heading">SORRY !!! wrong email or password !</span>
                            </div>';
                            echo $message;
                            header("Refresh:2, login.php");
                        }
                        $message = Session::get('message');
                        if (!empty($message)) {
                            echo $message;
                            Session::set('message', null);
                            header("Refresh:2");
                        }
                        ?>
                    </div>
                    <form action="processViewerLoginRegister.php" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Input your Email">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i> </span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password"
                                placeholder="Input your password">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i> </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" value="1"
                                        id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">
                                        <span style="color:#acacac;font-weight:500;font-size:12px;">
                                            Remember me
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 forgot-pass">
                                <a href="#">Forgot password ?</a>
                            </div>
                        </div>

                        <input type="hidden" name="action" value="verify">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" name="submit" style="width:100%;" value="single-post-login"
                                    class="btn btn-sm btn-info d-block"><i class="fas fa-users"></i> Log in
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <a href="register.php" class="btn btn-sm btn-primary d-block"><i
                                        class="fas fa-fast-backward"></i> Register
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <a href="#" name="submit-index" value="index-page-login" class="btn btn-sm btn-success d-block"><i class="fab fa-facebook"></i> Facebook Log in</a>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-sm btn-danger d-block">
                                    <i class="fab fa-google"></i>
                                    Google Log in</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
    </body>

</html>
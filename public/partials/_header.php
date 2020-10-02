<?php
// Load classes
require_once '../admin/app/start.php';

// Use the classes needed
use CodeCourse\Repositories\Header as Header;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Link as Link;
use CodeCourse\Repositories\Logo as Logo;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\viewersSessions as viewersSessions;

// Classes instantiated
$header = new Header();
$link = new Link();
$logo = new Logo;
$helpers = new Helpers();
$viewersSession = new viewersSessions();
Session::init();

// Tables to be operated upon
$table = 'tbl_header';
$tableLogo = 'tbl_logo';
$tableLink = 'tbl_link';
$tableSession = 'tbl_session';

// Limit of fetching data
$limit = ['limit' => '1'];
?>
<div class="container-fluid text-white header-area">
    <div class="row" style='min-height:330px;background-repeat:no-repeat;background-size:cover;
        <?php
        $headerData = $header->select($table, $limit);
        if (!empty($headerData)) {
            foreach ($headerData as $header) {
                ?> 
                    background-image:url("../admin/header/<?php echo $header->photo; ?>");
                <?php
            }
        }
        ?>'>
        <!-- Header top area -->
        <div class="col-sm-12">
            <div class="row pt-2">
                <div class="col-sm-6">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Link</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 pt-1">
                    <ul class="nav justify-content-end">
                        <?php
                        if (Session::get('login') == true) {
                            ?>
                        <li class="nav-item">
                            <form action="processViewerLoginRegister.php" method="post" class="d-inline">
                                <input type="hidden" name="action" value="verify">
                                <button type="submit" onclick="return confirm('Are you sure to log out ?');"
                                    name="submit" value="log_out" class="btn btn-sm btn-danger"><i
                                        class="fas fa-sign-out-alt"></i> Log out</button>
                            </form>
                        </li>
                        <?php
                        } else {
                            ?>
                        <li class="nav-item">
                            <a href="login.php?login-default=<?php echo 1; ?>"
                                class="nav-link text-white"><i class="fas fa-sign-in-alt"></i> Log
                                in</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="register.php"><i class="fas fa-user-plus"></i>
                                Register</a>
                        </li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <!-- <div class="border bg-danger py-1"></div>
            <hr style="height: 1px;background-color:#0000ff;border:1px solid #1FB0C5;"> -->
        </div>
        <!-- /Header top area ends -->

        <div class="col-sm-2" style='background-repeat:no-repeat;
        <?php
        $logoData = $logo->select($tableLogo, $limit);
        if (!empty($logoData)) {
            foreach ($logoData as $logo) {
                ?>
                    background-image:url("../admin/logo/<?php echo $logo->photo; ?>");
                <?php
            }
        }
        ?>'>
        </div>
        <div class="col-sm-8 text-center header-area">
            <?php
            if (!empty($headerData)) {
                foreach ($headerData as $header) {
                    ?>
            <h1><?php echo $header->title; ?>
            </h1>
            <h3><?php echo $header->slogan; ?>
            </h3>
            <h6><strong>Working since: </strong><?php echo $helpers->dateFormat($header->created_at); ?>
            </h6>
            <hr>
            <?php
                }
            }
            ?>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12 header-right">
                    <!-- Will fetch links data -->
                    <?php
                    $limit = ['limit' => '1'];
                    $linkData = $link->select($tableLink, $limit);
                    if (!empty($linkData)) {
                        foreach ($linkData as $link) {
                            ?>
                    <h6 style="border-bottom:2px solid #DDD;"><?php echo $link->title; ?>
                    </h6>
                    <p><i class="fas fa-envelope"></i> <?php echo $link->email; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $link->phone; ?></p>
                    <p><i class="fas fa-list"></i> <?php echo $link->url; ?></p>
                    <address style="margin-bottom: 5px;"><i class="fas fa-home"></i>
                        <?php echo $link->address; ?>
                    </address>
                    <div class="row">
                        <div class="col-sm-4">
                            <p style="font-size:10px;margin-bottom:5px;"><i class="fas fa-file-archive"></i> <?php echo $link->zipcode; ?>
                            </p>
                        </div>
                        <div class="col-sm-8">
                            <p style="font-size:10px;margin-bottom:5px;"><i class="fas fa-flag"></i> <?php echo $link->country; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <!-- /Will fetch links data ends-->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <!-- Logged in message -->
                    <small style="font-weight:900;">
                        <?php
                        if (Session::get('login') == true) {
                            echo '<span style="color:#edeff0;float:left;"><i class="fas fa-sign-out-alt"></i> Logged in ! </span> '.'<br>'.'Hello '.Session::get('login');
                        } else {
                            echo '<i class="fas fa-sign-in-alt"></i> <span style="color:#FFF;margin-bottom:15px;float:left;"> Not logged in !</span>';
                        }
                        ?>
                    </small>
                    <!-- /Logged in message -->
                </div>
            </div>
        </div>
    </div>
</div>
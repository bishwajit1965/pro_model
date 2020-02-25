<?php
// Load classes
require_once '../admin/app/start.php';

// Use the classes needed
use CodeCourse\Repositories\Header as Header;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Logo as Logo;
use CodeCourse\Repositories\Link as Link;

// Classes instantiated
$header = new Header();
$link = new Link();
$logo = new Logo;
$helpers = new Helpers();
Session::init();

// Tables to be operated upon
$table = 'tbl_header';
$tableLogo = 'tbl_logo';
$tableLink = 'tbl_link';

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
            <div class="row">
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
                        <li class="nav-item text-white">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 ">
                    <ul class="nav justify-content-end">
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
                        <li class="nav-item text-white">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr style="height: 1px;background-color:#0000ff;border:1px solid #1FB0C5;">
        </div>
        <!-- /Header top area ends -->

        <div class="col-sm-2 mt- p-" style='background-repeat:no-repeat;
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
        <div class="col-sm-8 text-center header-title">
            <?php
            if (!empty($headerData)) {
                foreach ($headerData as $header) {
                    ?>
                    <style>
                        .header-title h1 {
                            font-size: 60px;
                            font-weight: 800;
                            line-height: 60px;
                        }

                        .header-title h2 {
                            font-size: 40px;
                            font-weight: 800;
                            line-height: 40px;
                        }
                    </style>
                    <h1 style="text-shadow:1px 2px 3px #000;"><?php echo $header->title; ?> </h1>
                    <h3><?php echo $header->slogan; ?> </h3>
                    <hr style="width:30%;height:3px;background-color:#DDD;border-radius:5px;">
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-sm-2 py-">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Will fetch links data -->
                    <?php
                    $limit = ['limit' => '1'];
                    $linkData = $link->select($tableLink, $limit);
                    if (!empty($linkData)) {
                        foreach ($linkData as $link) {
                            ?>
                            <h6 style="border-bottom:2px solid #DDD;"><?php echo $link->title; ?></h6>
                            <p style="font-size:13px;margin-bottom:5px;"><i class="fas fa-envelope"></i>
                                <?php echo $link->email; ?>
                            </p>
                            <p style="font-size:13px;margin-bottom:5px;"><i class="fas fa-phone"></i> <?php echo $link->phone; ?> </p>
                            <p style="font-size:12px;margin-bottom:5px;"><i class="fas fa-list"></i> <?php echo $link->url; ?></p>
                            <address style="margin-bottom: 5px;"><i class="fas fa-home"></i>
                                <?php echo $link->address; ?>
                            </address>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p style="font-size:12px;margin-bottom:5px;"><i class="fas fa-file-archive"></i> <?php echo $link->zipcode; ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p style="font-size:12px;margin-bottom:5px;"><i class="fas fa-flag"></i> <?php echo $link->country; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!-- /Will fetch links data ends-->
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    // Load classes
    require_once '../admin/app/start.php';

    // Use the classes needed
    use CodeCourse\Repositories\Header as Header;
    use CodeCourse\Repositories\Session as Session;
    use CodeCourse\Repositories\Helpers as Helpers;
    use CodeCourse\Repositories\Logo as Logo;

    // Classes instantiated
    $header = new Header();
    $logo = new Logo;
    $helpers = new Helpers();
    Session::init();

    // Tables to be operated upon
    $table = 'tbl_header';
    $tableLogo = 'tbl_logo';
    $limit = ['limit' => '1'];
    ?>
    <div class="container-fluid text-white header-area py-">
        <div class="row" style='height:220px;background-repeat:no-repeat;background-size: cover;
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
            <div class="col-sm-2 mt-4 p4-4" style='background-repeat:no-repeat;;
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
            <div class="col-sm-8 text-center">
                <?php
                if (!empty($headerData)) {
                    foreach ($headerData as $header) {
                        ?>
                        <style>
                            h1 {
                                font-size: 60px;
                                font-weight: 800;
                                line-height: 60px;
                            }
                        </style>
                        <h1><?php echo $header->title; ?> </h1>
                        <h3><?php echo $header->slogan; ?> </h3>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
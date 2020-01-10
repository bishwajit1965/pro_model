<?php
include_once '../admin/app/start.php';

use Codecourse\Repositories\Session as Session;

$customerId = Session::get('customerId');
?>

<div class="row pt-1 header-area" style='
 <?php
    $headerData = $frontEnd->headerBannerAndDataView($tableHeader);
    if (!empty($headerData)) {
        foreach ($headerData as $data) { ?>
                background-image:url("../admin/header/<?= $data->photo; ?>");
            <?php }
            } ?>'>
    <div class="col-sm-3 d-flex flex-column justify-content-center">
        <?php
        $headerData = $frontEnd->headerBannerAndDataView($tableHeader);
        if (!empty($headerData)) {
            foreach ($headerData as $data) { ?>
                <h1 id="heading"><?= $data->title; ?></h1>
                <h2><?= $data->slogan; ?></h3>
                    <h3><?= 'Estd : ' . $helper->formatDate($data->established); ?></h3>
            <?php }
            } ?>
    </div>
    <div class="col-sm-3 d-flex flex-column justify-content-center text-center">
        <div class="search-container">
            <form action="#">
                <input type="text" class="p-1 pl-2" placeholder="Search..." name="search">
                <button type="submit" class="bg-warning"><i class="fa fa-search p-1"></i></button>
            </form>
        </div>
    </div>
    <div class="col-sm-2 d-flex flex-column justify-content-center text-center">
        <form action="#">
            <div class="input-group input-group-sm p-1">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-warning pb-2 px-2"><i class="fas fa-cart-plus"></i></span>
                </div>
                <?php
                $orderRelatedCustomerIdData = $cart->checksCustomerIdInOrdersTable($customerId, $tableOrders);
                if (!empty($orderRelatedCustomerIdData)) {
                    $quantity = 0;
                    $sum = 0;
                    foreach ($orderRelatedCustomerIdData as $orderData) {
                        $quantity = $quantity + $orderData->pro_quantity;
                        $sum = $sum + $orderData->total_price;
                    }
                    $vat = $sum * 0.15;
                    $grandTotal = $sum + $vat;
                }
                ?>
                <input placeholder="<?php if (!empty($quantity) && !empty($grandTotal)) {
                                        echo 'Q:' . $quantity . '|P :' . number_format($grandTotal, 2, '.', ',') . '&#2547;';
                                    } else {
                                        echo "Hello! Order now.";
                                    } ?>" type="text" name="total_price" class="form-control ">
            </div>
        </form>
    </div>
    <div class="col-sm-4 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-sm-7 social-links d-flex flex-row justify-content-between">
                <?php
                $socialMediaData = $frontEnd->socialMediaDataView($tableSocialMedia);
                if (!empty($socialMediaData)) {
                    foreach ($socialMediaData as $mediaData) { ?>
                        <a href="<?= $mediaData->site_name; ?>" target="blank">
                    <?php
                            if ($mediaData->site_name == 'http://www.facebook.com') {
                                echo '<i class="fab fa-facebook-square"></i>';
                            } elseif ($mediaData->site_name == 'https://www.twitter.com') {
                                echo '<i class="fab fa-twitter"></i>';
                            } elseif ($mediaData->site_name == 'http://www.linkedin.com') {
                                echo '<i class="fab fa-linkedin"></i>';
                            } elseif ($mediaData->site_name == 'https://www.github.com') {
                                echo '<i class="fab fa-github"></i>';
                            } elseif ($mediaData->site_name == 'https://www.plus.google.com') {
                                echo '<i class="fab fa-google-plus"></i>';
                            } elseif ($mediaData->site_name == 'https://www.youtube.com') {
                                echo '<i class="fab fa-youtube"></i>';
                            } else { }
                        }
                    }
                    ?>
                        </a>
            </div>
            <div class="col-sm-5 d-flex flex-row justify-content-between log-in">
                <?php
                $session = Session::checkLogin();
                if ($session == true) { ?>
                    <form action="pages/processLogin.php" method="post">
                        <input type="hidden" name="action" value="verify">
                        <button type="submit" name="submit" value="log_out" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                <?php
                } else {
                    ?>
                    <form action="pages/login.php" method="post">
                        <button type="submit" class="btn btn-sm btn-info">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>&nbsp;&nbsp;

                    <form action="pages/registerForm.php" method="post">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="float-right px-2" style="margin-left:auto;font-weight:600;font-size:21px;color:#dbdbdb;text-shadow:1px 2px 3px #000;">
        <?php
        if (isset($_SESSION['login'])) {
            $sessionEmail = $_SESSION['login'];
            echo isset($sessionEmail) ? 'Welcome !!! you are logged in - ' . $sessionEmail : ' ';
        } else {
            echo "You are not logged in !!!";
        }
        ?>
    </div>
</div>

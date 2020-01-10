<?php
require_once '../../admin/app/start.php';

use Codecourse\Repositories\Session as Session;
?>
<div class="row pt-1 header-area" style='
    <?php
    $headerData = $frontEnd->headerBannerAndDataView($tableHeader);
    if (!empty($headerData)) {
        foreach ($headerData as $data) { ?>
                background-image:url("../../admin/header/<?= $data->photo; ?>");
            <?php }
    } ?>'>
    <div class="col-sm-3 d-flex flex-column justify-content-center">
        <?php
        $headerData = $frontEnd->headerBannerAndDataView($tableHeader);
        if (!empty($headerData)) {
            foreach ($headerData as $data) { ?>
        <h1 id="heading"><?= $data->title; ?></h1>
        <h2><?= $data->slogan; ?></h3>
            <h3><?= 'Estd : ' . $helpers->formatDate($data->established); ?></h3>
            <?php }
        } ?>
    </div>
    <div class="col-sm-3 d-flex flex-column justify-content-center text-center">
        <div class="search-container">
            <form action="#">
                <input type="text" class="pl-2 p-1" placeholder="Search..." name="search">
                <button type="submit" class="bg-warning"><i class="fa fa-search p-1"></i></button>
            </form>
        </div>
    </div>
    <div class="col-sm-3 d-flex flex-column justify-content-center">
        <form action="#">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-warning pb-2 px-2"><i class="fas fa-cart-plus"></i></span>
                </div>
                <?php
                switch ($current_page) {
                    case 'cart':
                        $cartData = $cart->priceDisplay($tableCart, $sessionId);
                        if (!empty($cartData)) {
                            $sum = 0;
                            $quantity = 0;
                            foreach ($cartData as $carts) {
                                $total = $carts->pro_price * $carts->pro_quantity;
                                if ($sum !== null) {
                                    $sum = $sum + $total;
                                    $quantity = $quantity + $carts->pro_quantity;
                                }
                            }
                        } else {
                            $message = "Empty cart. You may place order.";
                        }
                        break;
                    case 'payment':
                        $cartData = $cart->priceDisplay($tableCart, $sessionId);
                        if (!empty($cartData)) {
                            $sum = 0;
                            $quantity = 0;
                            foreach ($cartData as $carts) {
                                $total = $carts->pro_price * $carts->pro_quantity;
                                if ($sum !== null) {
                                    $sum = $sum + $total;
                                    $quantity = $quantity + $carts->pro_quantity;
                                }
                            }
                        } else {
                            $message = "Empty cart. You may place order.";
                        }
                        break;
                    case 'paymentOffLine':
                        $cartData = $cart->priceDisplay($tableCart, $sessionId);
                        if (!empty($cartData)) {
                            $sum = 0;
                            $quantity = 0;
                            foreach ($cartData as $carts) {
                                $total = $carts->pro_price * $carts->pro_quantity;
                                if ($sum !== null) {
                                    $sum = $sum + $total;
                                    $quantity = $quantity + $carts->pro_quantity;
                                }
                            }
                        } else {
                            $message = "Empty cart. You may place order.";
                        }
                        break;
                    case 'order':
                        $customerOrderDetails = $cart->customerOrderDetails($tableOrders, $customerId);
                        if (!empty($customerOrderDetails)) {
                            $sum = 0;
                            $quantity = 0;
                            foreach ($customerOrderDetails as $carts) {
                                $total = $carts->pro_price * $carts->pro_quantity;
                                if ($sum !== null) {
                                    $sum = $sum + $total;
                                    $quantity = $quantity + $carts->pro_quantity;
                                }
                            }
                        } else {
                            $message = "Empty cart. You may place order.";
                        }
                        break;
                    case 'orderDetails':
                        $customerOrderDetails = $cart->customerOrderDetails($tableOrders, $customerId);
                        if (!empty($customerOrderDetails)) {
                            $sum = 0;
                            $quantity = 0;
                            foreach ($customerOrderDetails as $carts) {
                                $total = $carts->pro_price * $carts->pro_quantity;
                                if ($sum !== null) {
                                    $sum = $sum + $total;
                                    $quantity = $quantity + $carts->pro_quantity;
                                }
                            }
                        } else {
                        }
                        break;
                    case 'customerProfileIndex':
                        $message = "You can only update your profile!";
                        break;
                    case 'single':
                        $message = "Place order now !";
                        break;
                    default:
                        $message = "Place order";
                        break;
                }
                ?>
                <input placeholder="<?php if (isset($sum)  && isset($quantity)) {
                                        echo "Qty:" . $quantity . '|' . "Pri:" . number_format($sum, 2, '.', ',') . ' + Vat due (15%)' . '&#2547; ';
                                    } else {
                                        echo $message;
                                    }
                                    ?>" type="text" disabled="disabled" class="form-control form-control-sm">
            </div>
        </form>
    </div>
    <div class="col-sm-3 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-sm-8 d-flex justify-content-between social-links">
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
                        } else {
                        }
                    }
                }
                    ?>
                </a>
            </div>
            <div class="col-sm-4 d-flex justify-content-between log-in">
                <?php
                if (Session::checkLogin() == true) { ?>
                <form action="processLogin.php" method="post">
                    <input type="hidden" name="action" value="verify">
                    <input type="hidden" name="session_id" value="<?php echo $carts->session_id; ?>">
                    <button type="submit" name="submit" value="log_out" class="btn btn-sm btn-danger"><i
                            class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
                <?php
                } else {
                ?>
                <form action="pages/login.php" method="post">
                    <button type="submit" class="btn btn-sm btn-info">
                        Login
                    </button>
                </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="px-2"
        style="margin-left:auto;font-weight:600;font-size:21px;color:#dbdbdb;text-shadow:1px 2px 3px #000;">
        <?php
        if (isset($_SESSION['login'])) {
            $sessionEmail = $_SESSION['login'];
            echo isset($sessionEmail) ? 'Welcome !!! you are logged in - ' . $sessionEmail : ' ';
        }
        ?>
    </div>
</div>
<nav class="row navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <a class="navbar-brand" href="../index.php" style="font-size:16px;">HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="products.php">Products</a>
            </li>
            <?php
            include_once '../../admin/app/start.php';

            use Codecourse\Repositories\Session as Session;
            use Codecourse\Repositories\Cart as Cart;

            $cart = new Cart();
            $table5 = 'tbl_cart';

            $session = Session::checkLogin();
            $sessionId = session_id();
            $path = $_SERVER['SCRIPT_FILENAME'];
            $current_page = basename($path, '.php');
            if ($session == true) {
                ?>
            <li class="nav-item">
                <a class="nav-link" <?php if ($current_page == 'customerProfileIndex') {
                                                echo 'id="active"';
                                            } ?> href="customerProfileIndex.php">Profile</a>
            </li>
            <?php if ($cart->checkCartTable($table5, $sessionId)) { ?>
            <li class="nav-item">
                <a <?php if ($current_page == 'cart') {
                                        echo 'id="active"';
                                    } ?> class="nav-link" href="cart.php"> Cart</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'payment') {
                                        echo 'id="active"';
                                    } ?>class="nav-link" href="payment.php"> Payment</a>
            </li>

            <?php }
            } ?>
            <?php
            $orderRelatedCustomerIdData = $cart->checksCustomerIdInOrdersTable($customerId, $tableOrders);
            if (!empty($orderRelatedCustomerIdData)) {
                ?>
            <li class="nav-item">
                <a <?php if ($current_page == 'orderDetails') {
                                echo 'id="active"';
                            } ?>class="nav-link" href="orderDetails.php"> Order List</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'order') {
                                echo 'id="active"';
                            } ?>class="nav-link" href="order.php"> Order</a>
            </li>
            <?php
            }
            ?>

            <li class="nav-item">
                <a <?php if ($current_page == 'brandCategorySubCategory') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="brandCategorySubCategory.php">View products</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'aboutUs') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="aboutUs.php"> About Us</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'contact') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="contact.php"> Contact Us</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'termsAndConditions') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="termsAndConditions.php"> Term & Cond</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'privacyPolicy') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="privacyPolicy.php"> Priv Policy</a>
            </li>
            <li class="nav-item">
                <a <?php if ($current_page == 'returnPolicy') {
                        echo 'id="active"';
                    } ?>class="nav-link" href="returnPolicy.php"> Retu Policy</a>
            </li>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> -->
        </ul>
    </div>
</nav>
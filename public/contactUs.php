<!-- Head area -->
<?php require_once 'partials/_head.php'; ?>
<!-- /Head area -->

<!-- Top header area -->
<?php require_once 'partials/_topHeader.php'; ?>
<!-- /Top header area -->

<!-- Header area -->
<?php require_once 'partials/_header.php'; ?>
<!-- /Header area -->

<!-- Nab bar area -->
<?php require_once 'partials/_navBar.php'; ?>
<!-- /Nab bar area -->

<!-- Middle content area -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 contact-us mb-4" style="overflow:auto;">
            <h1>Contact us</h1>

            <?php
            // Load classes
            require_once '../admin/app/start.php';

            // Use the classes needed
            use CodeCourse\Repositories\Session as Session;
            Session::init();
            $message = Session::get('message');
            if (!empty($message)) {
                echo $message;
                Session::set('message', null);
            }

            ?>
            <form action="processContact.php" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="first_name" id="" class="form-control form-control-sm" placeholder="First name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-sm" placeholder="Last name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" id="phone" class="form-control form-control-sm" placeholder="Phone">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-sm" name="message" id="editor1" rows="1" placeholder="Message"></textarea>
                </div>
                <input type="hidden" name="action" value="verify">
                <button type="submit" name="submit" value="insert" class="btn btn-primary btn-sm"> <i class="fas fa-envelope"></i> Send Message</button>
            </form> 
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<!-- /Middle content area -->

<!-- Footer area -->
<?php require_once 'partials/_footerArea.php'; ?>
<!-- /Footer area -->

<!-- Footer bottom bar area -->
<?php require_once 'partials/_footerBottomBar.php'; ?>
<!-- Footer bottom bar area -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php require_once 'partials/_scripts.php'; ?>
<!-- /jQuery first, then Popper.js, then Bootstrap JS -->

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
<div class="container">
    <div class="row">
        <div class="col-sm-12 about-us py-3" style="overflow:auto;min-height:300px;">
            <h1>About us</h1>
            <?php
            // Load classes
            require_once '../admin/app/start.php';

            // Use the classes needed
            use CodeCourse\Repositories\AboutUs as AboutUs;

            $aboutUs = new AboutUs();
            // Table to be operated upon
            $table = 'tbl_about_us';

            $aboutUsData = $aboutUs->select($table);
           
            foreach ($aboutUsData as $about) {
                ?>
                <div style="background-color: #D4EDDA;padding:20px;border-left:4px solid #008000;">
                    <?php echo htmlspecialchars_decode($about->about_us); ?>
                </div>
                <?php
            }
            ?>            
            <a href="index.php" class="btn btn-lg btn-primary mt-4" id="shadow"><i class="fas fa-fast-backward"></i> Home</a>
        </div>
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

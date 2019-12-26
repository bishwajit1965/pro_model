<?php include_once 'views/partials/_head.php';?>
    <div class="container-fluid">
        <?php include_once 'views/partials/_topHeader.php';?>
        <?php include_once 'views/partials/_header.php';?>
        <?php include_once 'views/partials/_bottomHeader.php';?>
        <div class="row px-5">
            <?php include_once 'views/partials/_leftSidebar.php';?>
            <div class="col-sm-7 main-content py-2">
                <!-- Add code below for middle content area-->
                <h1>Middle</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia vitae officiis recusandae quod laudantium doloremque aut repudiandae aliquid totam unde deserunt magni rerum vel, sapiente facilis rem expedita est reiciendis.</p>
                <?php
                // Load classes
                require_once '../admin/app/start.php';

                // Use the classes needed
                use Codecourse\Repositories\UserRepository as UserRepository;

                $db = new Codecourse\Repositories\UserRepository();
                ?>
                <!-- /Add code above for middle content area-->
            </div>
            <?php include_once 'views/partials/_rightSidebar.php';?>
        </div>
        <?php include_once 'views/partials/_footer.php';?>
        <?php include_once 'views/partials/_footerBottom.php';?>
    </div>
<?php include_once 'views/partials/_scripts.php';?>



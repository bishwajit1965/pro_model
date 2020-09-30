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

<!-- Content area -->
<div class="container"> 
    <?php
    // Class loader
    require_once '../admin/app/start.php';

    // Use the classes needed
    use CodeCourse\Repositories\Session as Session;
    use CodeCourse\Repositories\Helpers as Helpers;
    use CodeCourse\Repositories\Contact as Contact;

    // Class instantiated
    $helpers = new Helpers();
    $contact = new Contact();
    Session::init();

    // Single post fetching id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    // Table to be operated upon
    $table = 'tbl_contact';

    // Conditional fetching of data
    $whereCond = [
        'where' => ['id' => $id],
        'return_type' => 'single',
    ];
    // Single comment data fetched
    $contact = $contact->select($table, $whereCond);
    ?>
    <div class="post" style="min-height:400px;">
        <div class="row">
            <div class="col-sm-12" style="overflow:auto;">
                <h1 class="mt-4" style="font-size:2.5rem;font-weight:800;">
                Reader's Testimonial
                </h1>
                <?php
                if (!empty($contact)) { 
                    ?> 
                    <p>
                        <span style="color:#999;font-weight:800;"> <?php echo $contact->first_name. ' '.$contact->last_name; ?> || </span>
        
                        <span style="color:#999;font-weight:800;"><strong> From :</strong> <?php echo $contact->address; ?> || </span>
        
                        <span style="color:#999;font-weight:800;"><strong> on :</strong> <?php echo $helpers->dateFormat($contact->created_at); ?></span>
                    </p>
                <div style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;"><strong> Commented that :</strong> <?php echo htmlspecialchars_decode($contact->message); ?>
                </div>
                    <?php
                }
                ?>     
                <p>
                    <a href="index.php" class="btn btn-sm btn-primary mt-4" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <i class="fas fa-fast-backward"></i> Home page</a>
                </p>
            </div>
        </div>
    </div>    
</div>
<!-- /Content area -->

<!-- Footer area -->
<?php require_once 'partials/_footerArea.php'; ?>
<!-- /Footer area -->

<!-- Footer bottom bar area -->
<?php require_once 'partials/_footerBottomBar.php'; ?>
<!-- /Footer bottom bar area -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php require_once 'partials/_scripts.php'; ?>
<!-- /jQuery first, then Popper.js, then Bootstrap JS -->




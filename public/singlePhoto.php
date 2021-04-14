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
    <style>
        div.card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .example-shadow{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);}
    </style>
    <?php
    // Class loader
    require_once '../admin/app/start.php';

    // Use the classes needed
    use CodeCourse\Repositories\Session as Session;
    use CodeCourse\Repositories\Gallery as Gallery;
    use CodeCourse\Repositories\Helpers as Helpers;

    // Class instantiated
    $gallery = new Gallery();
    $helpers = new Helpers();
    Session::init();
    
    // Table to be operated upon
    $table = 'tbl_gallery';
    
    // Single post fetching id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    // Conditional fetching of data
    $whereCond = [
        'where' => ['id' => $id],
        'return_type' => 'single',
    ];
    // Single article data fetched
    $photoData = $gallery->select($table, $whereCond);
    // var_dump($article);
    if (!empty($photoData)) { ?>
    <div class="post">
        <!-- Validation message begins -->
        <div class="row">
            <div class="col-sm-12">
                <?php
                Session::init();
                $message = Session::get('message');
                if (!empty($message)) {
                    echo $message;
                    Session::set('message', null);
                }
                ?>
            </div>
        </div>
        <!-- /Validation message ends -->
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="card mb-4" style="width:rem;">
                    <?php
                    if (!empty($photoData->photo)) { ?>
                    <img  src="../admin/gallery/<?php echo $photoData->photo; ?>" class=""
                        alt="gallery Photo" class="card-img-top"
                        style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);height:625px;">
                        <?php
                    } else {
                    }
                    ?>
                     
                    <div class="card-body" style="height:170px;">
                        <h5 class="card-title"><?php echo htmlspecialchars_decode($photoData->title); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars_decode($photoData->description); ?></p>
                    </div>
                    <div class="card-footer p-1"><a href="gallery.php?id=<?php echo $photoData->id;?>" class="btn btn-sm btn-primary"><i class="fa fa-backward"></i> Go to gallery</a></div>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php
}
?>
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
<!-- /jQuery first, then Popper.js, then Bootstrap JS
<!--Head area -->
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
    <style>
        .content-404>h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 60px;
            line-height: 60px;
            color:#a23806;
            font-weight: 900;
            text-shadow: 1px 2px 3px #400000;
            text-align: center;
        }
        div.card {
            /*width: 250px;*/
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            /*text-align: center;*/
        }
        .example-shadow{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);}
    </style>
    <div class="text-center m-auto py-3">
        <h1>Photo Gallery</h1>
    </div>
    <div class="row">
        <?php
        // Load classes
        require_once '../admin/app/start.php';
        // Use the classes needed
        use CodeCourse\Repositories\Session as Session;
        use CodeCourse\Repositories\Gallery as Gallery;
        use CodeCourse\Repositories\Helpers as Helpers;
        use CodeCourse\Repositories\FrontEnd as FrontEnd;
        // Classes instantiated
        $gallery = new Gallery();
        $helpers = new Helpers();
        $frontEnd = new frontEnd();
        $records_per_page = '16';
        Session::init();
        // Tables to be operated upon
        $table = 'tbl_gallery';

        $photoGallery = $frontEnd->paging($table, $records_per_page);
        $photoGalleryData = $frontEnd->frontEndDataAndPagination($photoGallery);
        if (!empty($photoGalleryData) && !empty($photoGallery)) {
        foreach ($photoGalleryData as $gallery) {
            ?>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card mb-4 ml-3" style="width: 19.8rem;">
                        <img src="../admin/gallery/<?php echo $gallery->photo; ?>" class="card-img-top" alt="Gallery Photo" style="height:220px;">
                        <div class="card-body" style="height:170px;">
                            <h5 class="card-title"><?php echo htmlspecialchars_decode($helpers->textShorten($gallery->title, 40)); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars_decode($helpers->textShorten($gallery->description, 100)); ?></p>
                        </div>
                        <div class="card-footer p-1"><a href="singlePhoto.php?id=<?php echo $gallery->id;?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View in detail</a></div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="col-sm-12 container text-center text-danger">
            <h2>No photo is avilable at present</h2>
        </div>  
        <?php
    } ?>
    </div>
    <!-- Pagination begins -->
    <div class="row d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-md pagination-responsive example-shadow">
                <?php $frontEnd->pagingLink($table, $records_per_page); ?>
            </ul>
        </nav>
    </div>
    <!-- /Pagination ends -->
</div>
<!-- /Middle content area -->

<!-- Footer area -->
<?php require_once 'partials/_footerArea.php'; ?>
<!-- /Footer area -->

<!-- Footer bottom bar area -->
<?php require_once 'partials/_footerBottomBar.php'; ?>
<!-- /Footer bottom bar area -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php require_once 'partials/_scripts.php'; ?>
<!-- /jQuery first, then Popper.js, then Bootstrap JS
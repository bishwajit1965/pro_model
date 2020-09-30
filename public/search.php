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
        <div class="col-sm-12 search-page  py-5" style="overflow:auto;">
            <style>
            .content-404>h1 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 50px;
                line-height: 60px;
                color: #a23806;
                font-weight: 900;
                text-shadow: 1px 2px 3px #400000;
            }

            .content-404>h2 {
                line-height: 40px;
                color: #a23806;
                font-weight: 900;
            }
            </style>
            <?php
            // Load classes
            require_once '../admin/app/start.php';

            // Use the classes needed
            use CodeCourse\Repositories\Core as Core;
            use CodeCourse\Repositories\FrontEnd as FrontEnd;
            use CodeCourse\Repositories\Session as Session;
            use CodeCourse\Repositories\Helpers as Helpers;
            use CodeCourse\Repositories\Category as Category;
            use CodeCourse\Repositories\Tag as Tag;

            // Classes instantiated
            $category = new Category();
            $core = new Core;
            $tag = new Tag();
            $frontEnd = new FrontEnd();
            $helpers = new Helpers();
            Session::init();

            // Tables to be operated upon
            $table = 'tbl_articles';
            $table_category = 'tbl_category';
            $table_tag = 'tbl_tag';

            // Search data caught
            if (!isset($_GET['search']) || $_GET['search'] == null) {
                header("Location: 404.php");
            } else {
                $search = $_GET['search'];
            }
            //Search
            $searchedData = $core->searchData($table, $search);
            if (!empty($searchedData)) {
                foreach ($searchedData as $article) {
                    ?>
            <div class="post">
                <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                    <h1><?php echo  $article->title; ?></h1>
                </a>
                <p>
                    <span style="color:#999;font-weight:600;"><strong> Author :</strong> <?php echo $article->author; ?>
                        || </span>
                    <span style="color:#999;font-weight:600;"><strong> Published on :</strong>
                        <?php echo $helpers->dateFormat($article->published_on); ?></span>
                </p>
                <p>
                    <span style="color:#999;font-weight:600;"><strong>Category :</strong>
                        <?php
                                $categoryData = $category->select($table_category);
                    if (!empty($categoryData)) {
                        foreach ($categoryData as $categoryResult) {
                            if ($categoryResult->category_id == $article->category_id) {
                                ?>
                        <a href="#" class="badge badge-primary"><?php echo $categoryResult->category_name; ?></a>
                        <?php
                            }
                        }
                    } ?>
                    </span>
                    <!-- Tag data will be fetched and displayed -->
                    <span style="color:#999;font-weight:600;"><strong> || Tag :</strong>
                        <?php
                                $tagData = $tag->select($table_tag);
                    if (!empty($tagData)) {
                        foreach ($tagData as $tagResult) {
                            if ($tagResult->tag_id == $article->tag_id) {
                                ?>
                        <a href="#" class="badge badge-primary"><?php echo $tagResult->tag_name; ?></a>
                        <?php
                            }
                        }
                    } ?>
                    </span>
                </p>

                <div class="row">
                    <div class="col-sm-6">
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                            <img class="img-fluid img-thumbnail img-cover w-100" style="height:200px;"
                                src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo">
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <p
                            style="color:#666;font-weight:600;margin-top:px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;">
                            <strong> Post synopsis :</strong>
                            <?php echo $article->description; ?></p>
                        <p><?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 390)); ?></p>
                        <div class="read-more d-flex justify-content-end">
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>"
                                class="btn btn-sm btn-primary "><i class="fas fa-book-open"></i>
                                Read More</a>
                        </div>

                    </div>
                </div>
            </div>
            <hr class="type_7" style="width: 100%;display:block;">
            <?php
                }
            } else {
                ?>
            <div class="row">
                <div class="m-auto text-danger text-center content-404">
                    <h1>SORRY ! NO DATA FOUND</h1>
                    <h2>The searched data is not available in the database yet.</h2>
                    <h2>You may try another one.</h2>
                </div>
            </div>

            <?php
            }
            ?>
        </div>
    </div>
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
<!-- /jQuery first, then Popper.js, then Bootstrap JS -->
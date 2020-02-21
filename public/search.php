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
        <?php require_once 'partials/_leftSideBar.php'; ?>
        <div class="col-sm-6 main-content" style="overflow:auto;">
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
                        <h1><?php echo  $article->title; ?></h1>
                        <p>
                            <span style="color:#999;font-weight:600;"><strong> Author :</strong> <?php echo $article->author; ?> || </span>
                            <span style="color:#999;font-weight:600;"><strong> Published on :</strong> <?php echo $helpers->dateFormat($article->published_on); ?></span>
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
                                }
                                ?>
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
                                }
                                ?>
                            </span>
                        </p>
                        <p><img class="img-fluid img-thumbnail" src="../../admin/article/<?php echo $article->photo; ?>" alt="Article Photo"></p>

                        <p style="color:#999;font-weight:600;"><strong> Post synopsis :</strong> <?php echo $article->description; ?></p>
                        <p><?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 320)); ?></p>
                        <p>
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>" class="btn btn-sm btn-primary"><i class="fas fa-book-open"></i> Read More</a>
                        </p>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="row">
                    <style>
                        h1 {
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 40px;
                            line-height: 50px;
                        }

                        h2 {
                            line-height: 40px;
                        }

                        .content {
                            min-height: 300px;
                        }
                    </style>
                    <div class="m-auto text-danger text-center content">
                        <h1>SORRY ! NO DATA FOUND</h1>
                        <h2>The searched data is not available in the database yet.</h2>
                        <h2>You may try another one.</h2>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <!-- Right side bar -->
        <?php require_once 'partials/_rightSideBar.php'; ?>
        <!-- /Right side bar -->
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
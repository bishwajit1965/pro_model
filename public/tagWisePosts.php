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
        <div class="col-sm-6 post" style="overflow:auto;">
            <style>
                .post>h1 {
                    font-family: 'Roboto', sans-serif;
                    font-size: 2.5em;
                    line-height: 45px;
                    font-weight:800;
                    margin-top: 40px;
                    text-shadow: 1px 2px 3px #333;
                    color: #222;
                }
            </style>
            <div class="tag-header bg-secondary">
                <h1>Tag related post</h1> 
            </div>

            <?php
            // Load classes
            require_once '../admin/app/start.php';

            // Use the classes needed
            use CodeCourse\Repositories\Article as Article;
            use CodeCourse\Repositories\Helpers as Helpers;

            $article = new Article();
            $helpers = new Helpers();
            // Table to be operated upon
            $table = 'tbl_articles';

            if (isset($_GET['tag_id'])) {
                $id = $_GET['tag_id'];
            }
            if (isset($id)) {
                // Conditional fetching of data
                $whereCondition = ['tag_id' => $id];
                $articleData = $article->select($table, $whereCondition);
                if (!empty($articleData)) {
                    foreach ($articleData as $article) {
                        if ($article->tag_id == $id) {
                            ?>
                            <h1><?php echo  $article->title; ?></h1>
                            <h4><?php echo  $article->description; ?></h4>
                            <p><?php echo  htmlspecialchars_decode($helpers->textShorten($article->body), 280); ?></p>
                            <?php
                        }
                    }
                }
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

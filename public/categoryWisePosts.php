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
            <div class="page-title text-white bg-info mt-1 p-1 mb-3">
                <h1 style="color:#FFF;">Category related posts</h1> 
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

            if (isset($_GET['category_id'])) {
                $id = $_GET['category_id'];
            }
            if (isset($id)) {
                $whereCondition = ['category_id' => $id];
                $articleData = $article->select($table, $whereCondition);
                if (!empty($articleData)) {
                    foreach ($articleData as $article) {
                        if ($article->category_id == $id) {
                            ?>
                            <h1><?php echo  $article->title; ?></h1>
                            <p>
                                <span style="color:#999;font-weight:600;"><strong> Author :</strong> <?php echo $article->author; ?> || </span>
                                <span style="color:#999;font-weight:600;"><strong> Published on :</strong> <?php echo $helpers->dateFormat($article->published_on); ?></span>
                            </p>

                            <p style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;"><strong> Post synopsis :</strong> <?php echo $article->description; ?>
                            </p>

                            <p><?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 320)); ?>
                            </p>

                            <p>
                                <a href="singlePost.php?post_id=<?php echo $article->id; ?>" class="btn btn-sm btn-primary" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><i class="fas fa-book-open"></i> Read More</a>
                            </p>
                            <?php
                        } else {
                            if ($article->category_id == null) {
                                echo "No data is found";
                            }
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
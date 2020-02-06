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
    <!-- Middle content area -->

    <?php
    // Class loader
    require_once '../admin/app/start.php';

    // Use the classes needed
    use CodeCourse\Repositories\Core as Core;
    use CodeCourse\Repositories\Session as Session;
    use CodeCourse\Repositories\Helpers as Helpers;
    use CodeCourse\Repositories\Category as Category;
    use CodeCourse\Repositories\Tag as Tag;

    // Class instantiated
    $core = new Core();
    $helpers = new Helpers();
    $category = new Category();
    $tag = new Tag();
    Session::init();

    // Single post fetching id
    if (isset($_GET['post_id'])) {
        $id = $_GET['post_id'];
    }

    // Table to be operated upon
    $table = 'tbl_articles';
    $table_category = 'tbl_category';
    $table_tag = 'tbl_tag';

    // Conditional fetching of data
    $whereCond = [
        'where' => ['id' => $id],
        'return_type' => 'single',
    ];
    // Single article data fetchrd
    $article = $core->select($table, $whereCond);
    // var_dump($article);
    if (!empty($article)) { ?>
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
                                <a href="#" class="badge badge-secondary"><?php echo $categoryResult->category_name; ?></a>
                    <?php
                            }
                        }
                    }
                    ?>
                </span>
                <!-- Tag data will be fetched and displayed -->
                <span style="color:#999;font-weight:600;"><strong> ||
                        Tag :</strong>
                    <?php
                    $tagData = $tag->select($table_tag);
                    if (!empty($tagData)) {
                        foreach ($tagData as $tagResult) {
                            if ($tagResult->tag_id == $article->tag_id) {
                    ?>
                                <a href="#" class="badge badge-secondary"><?php echo $tagResult->tag_name; ?></a>
                    <?php
                            }
                        }
                    }
                    ?>
                </span>
            </p>
            <?php

            if (!empty($article->photo)) { ?>
                <img class="img-fluid img-thumbnail w-100 h-75" src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo">
            <?php
            } else {
            }
            ?>

            <p style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;"><strong> Post synopsis :</strong> <?php echo $article->description; ?></p>

            <p><?php echo htmlspecialchars_decode($article->body); ?></p>
            <p>
                <a href="index.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-fast-backward"></i> Home page</a>
            </p>
        </div>
        <hr>
    <?php
    }
    ?>
    <!--Post wise Facebook comments-->
    <div class="facebook-post-comments">
        <div class="borders">
            <h5>Post comments:</h5>
        </div>
        <!-- Uri generator for each post -->
        <?php
        $url = (!empty($_SERVER['HTTPS'])) ? 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        ?>
        <!-- /Uri generator for each post -->
        <div class="fb-comments" data-href="<?php echo $url; ?>" data-numposts="5" data-width="80%"></div>
    </div>
    <!-- /Post wise Facebook comments -->

    <!-- Posts in the same category -->
    <div class="row">
        <div class="col-sm-12">
            <h1>Posts in the same category</h1>
            <span style="color:#888;font-weight:600;"><strong>Category :</strong>
                <?php
                if (!empty($categoryData)) {
                    foreach ($categoryData as $categoryResult) {
                        if ($categoryResult->category_id == $article->category_id) {
                ?>
                            <a href="#" class="badge badge-secondary"><?php echo $categoryResult->category_name; ?></a>
                <?php
                        }
                    }
                }
                ?>
        </div>
    </div>
    <div class="row">
        <?php
        $postData = $core->select($table);
        foreach ($postData as $post) {
            if ($post->category_id == $article->category_id) {
        ?>
                <div class="col-sm-2 p-1">
                    <a href="singlePost.php?post_id=<?php echo $post->id; ?>">
                        <img class="img-fluid img-thumbnail" src="../admin/article/<?php echo $post->photo; ?>" alt="Article Photo">
                    </a>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <!-- /Posts in the same category -->

    <!-- /Middle content area -->
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
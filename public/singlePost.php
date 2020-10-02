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
    use CodeCourse\Repositories\Core as Core;
    use CodeCourse\Repositories\Session as Session;
    use CodeCourse\Repositories\Helpers as Helpers;
    use CodeCourse\Repositories\Category as Category;
    use CodeCourse\Repositories\FrontEnd as FrontEnd;
    use CodeCourse\Repositories\Tag as Tag;
    use CodeCourse\Repositories\Like as Like;

    // Class instantiated
    $core = new Core();
    $helpers = new Helpers();
    $category = new Category();
    $tag = new Tag();
    $frontEnd = new FrontEnd();
    $like = new Like();
    Session::init();
    
    // Table to be operated upon
    $table = 'tbl_articles';
    $table_category = 'tbl_category';
    $table_tag = 'tbl_tag';
    $tableLikes = 'tbl_likes';
    //Session::set('post_id', $id);
    
    // Single post fetching id
    if (isset($_GET['post_id'])) {
        $id = $_GET['post_id'];
    }
    // Conditional fetching of data
    $whereCond = [
        'where' => ['id' => $id],
        'return_type' => 'single',
    ];

    // Single article data fetched
    $article = $core->select($table, $whereCond);
    // var_dump($article);
    if (!empty($article)) { ?>
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
            <div class="col-sm-12 single-post">
                <?php
                if (!empty($article->photo)) { ?>
                <img class="img-fluid img-thumbnail mb-3 w-100" src="../admin/article/<?php echo $article->photo; ?>"
                    alt="Article Photo"
                    style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);height:350px;margin-top:10px;">
                    <?php
                } else {
                }
                ?>
                <a href="index.php">
                    <h1><?php echo  $article->title; ?>
                    </h1>
                </a>
                <p>
                    <span style="color:#999;font-weight:600;"><strong> Author :</strong> <?php echo $article->author; ?>
                        || </span>
                    <span style="color:#999;font-weight:600;"><strong> Published on :</strong>
                        <?php echo $helpers->dateFormat($article->published_on); ?></span>
                    ||

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
                    <span style="color:#999;font-weight:600;"><strong> || Tag :</strong>
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
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <?php
                    // Checks if the viewer is logged in
                    if (Session::checkLogin()) {
                        ?>
                    <!-- Like button -->
                    <div class="col-sm-3 like">
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                            <form action="processFrontEnd.php" method="post">
                                <input type="hidden" name="action" value="verify">
                                <input type="hidden" name="post_id" value="<?php echo $article->id; ?>">
                                <input type="hidden" name="like" value="single-post-like">

                                <button type="submit" name="submit" value="like"
                                    class="fas fa-thumbs-up text-white btn btn-sm btn-primary"> Like
                                    <span class="badge badge-danger" style="border:1px solid#FFF;">
                                        <?php
                                        $articleId = $article->id;
                        $likeData = $like->countPostLikes($tableLikes, $articleId);
                        if (isset($likeData)) {
                            echo count($likeData);
                        } else { ?>
                                        <span style="color:#FFF;"><?php echo '0' ; ?></span>
                                        <?php
                                        } ?>
                                    </span>
                                </button>
                            </form>
                        </a>
                    </div>
                    <?php
                    } else {
                        ?>
                    <!-- If not logged in this like button will be shown with likes counted -->
                    <div class="col-sm-12">
                        <a href="login.php?post_id=<?php echo $article->id; ?>" name="post_id"
                            value="<?php echo $article->id; ?>"><i class="fas fa-thumbs-up"></i>
                            <?php
                            $articleId = $article->id;
                        $likeData = $like->countPostLikes($tableLikes, $articleId);
                        if (isset($likeData)) {
                            ?>
                            <sup style="color:#bf0000;font-weight:900;">
                                <?php echo count($likeData); ?>
                            </sup>
                                <?php
                        } else {
                            ?>
                            <span style="color:#bf0000;font-weight:900;"><?php echo 0 ; ?></span>
                            <?php
                        } ?>
                        </a>
                    </div>
                    <?php
                    }
                        ?>
                    <!-- / Like button ends -->

                    <!-- Dislike button begins-->
                    <?php
                    if (Session::checkLogin()) {
                        // Dislike button will be displayed to the person who has liked the post only
                        $likeData = $like->select($tableLikes);
                        if (!empty($likeData)) {
                            foreach ($likeData as $likeValue) {
                                if ($likeValue->email == Session::get('login') && $likeValue->article_id == $article->id
                                && $likeValue->session == session_id() && $likeValue->viewers_id == Session::get('id')) {
                                    ?>
                                    <div class="col-sm-3 dislike">
                                        <form action="processFrontEnd.php" method="post">
                                            <input type="hidden" name="action" value="verify">

                                            <input type="hidden" name="post_id" value="<?php echo $article->id; ?>">
                                            <input type="hidden" name="viewers_id" value="<?php echo Session::get('id'); ?>">
                                            <input type="hidden" name="email" value="<?php echo $likeValue->email; ?>">
                                            <input type="hidden" name="session" value="<?php echo session_id(); ?>">
                                            <input type="hidden" name="dislike" value="single-post-dislike">

                                            <button type="submit" name="submit" value="delete" style="padding:6px 15px;"
                                                class="fas fa-thumbs-down btn btn-sm btn-primary text-white" data-toggle="tooltip"
                                                title="<?php echo Session::get('login'). ' liked the post'; ?>">
                                                Dislike
                                            </button>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        } ?>
                        <?php
                    } else {
                    }
                    ?>
                    <!-- Dislike button ends -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p
                    style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;">
                    <strong> Post synopsis :</strong> <?php echo $article->description; ?>
                </p>

                <p><?php echo htmlspecialchars_decode($article->body); ?>
                </p>

                <p>
                    <a href="index.php" class="btn btn-sm btn-primary" id="shadow">
                        <i class="fas fa-fast-backward"></i> Home page</a>
                </p>
            </div>
        </div>
    </div>
    <hr>
    <?php
    }
    ?>
    <!-- Posts in the same category -->
    <div class="row">
        <div class="col-sm-12 single-post-category">
            <h4>Posts in the same category</h4>
            <span style="color:#888;font-weight:600;"><strong>Category :</strong></span>
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
    <div class="row py-4">
        <?php
        $postData = $core->select($table);
        foreach ($postData as $post) {
            if ($post->category_id == $article->category_id) {
                ?>
        <div class="col-sm-2 posts-same-category">
            <a href="singlePost.php?post_id=<?php echo $post->id; ?>">
                <img class="img-fluid img-thumbnail w-100" src="../admin/article/<?php echo $post->photo; ?>"
                    alt="Article Photo" style="height:100px;" data-toggle="tooltip"
                    title="<?php echo $post->description; ?>">
            </a>
        </div>
        <?php
            }
        }
        ?>
    </div>
    <!-- /Posts in the same category -->
    <div class="row">
        <div class="col-sm-12">
            <!--Post wise Facebook comments-->
            <div class="facebook-post-comments">
                <div class="single-post">
                    <h4>Post comments:</h4>
                </div>
                <!-- Uri generator for each post -->
                <?php
                $url = (!empty($_SERVER['HTTPS'])) ? 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                ?>
                <!-- /Uri generator for each post -->
                <div class="fb-comments" data-href="<?php echo $url; ?>" data-numposts="5" data-width="80%"></div>
            </div>
            <!-- /Post wise Facebook comments -->
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
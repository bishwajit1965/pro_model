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
    // Single article data fetched
    $article = $core->select($table, $whereCond);
    // var_dump($article);
    if (!empty($article)) { ?>
        <div class="post">
            <div class="row">
                <div class="col-sm-12 single-post">
                    <?php
                    if (!empty($article->photo)) { ?>
                        <img class="img-fluid img-thumbnail mb-3 w-100" src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);height:350px;margin-top:30px;">
                        <?php
                    } else {
                    }
                    ?>
                    <a href="index.php"><h1><?php echo  $article->title; ?></h1></a>
                    <p>
                        <span style="color:#999;font-weight:600;"><strong> Author :</strong> <?php echo $article->author; ?> || </span>
                        <span style="color:#999;font-weight:600;"><strong> Published on :</strong> <?php echo $helpers->dateFormat($article->published_on); ?></span> ||
                     
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
            <?php
            // Checks if the viewer is logged in
            if (Session::get('login')) {
                ?>
                <div class="col-sm-1 like">
                    <form action="processFrontEnd.php" method="post">
                        <input type="hidden" name="action" value="verify">
                        <input type="hidden" name="id" value="<?php echo $article->id; ?>">
                        <input type="hidden" name="like_count"
                            value="<?php echo $article->like_count + 1; ?>">
                        <input type="hidden" name="user_session"
                            value="<?php echo $article->user_session; ?>">
                        <input type="hidden" name="single-post-submit" value="single-post-like">

                        <button type="submit" name="submit" value="like"
                            class="fas fa-thumbs-up text-white btn btn-sm btn-primary">
                            <span class="badge badge-danger"><?php echo $article->like_count ; ?></span>
                        </button>
                    </form>
                </div>
                <div class="col-sm-1 dislike">
                    <form action="processFrontEnd.php" method="post">
                        <input type="hidden" name="action" value="verify">
                        <input type="hidden" name="id" value="<?php echo $article->id; ?>">
                        <input type="hidden" name="like_count"
                            value="<?php echo $article->like_count - 1; ?>">
                        <input type="hidden" name="user_session"
                            value="<?php echo $article->user_session; ?>">

                        <button type="submit" name="submit" value="like"
                            class="fas fa-thumbs-down btn btn-sm btn-primary text-white">
                             <span class="badge badge-danger"><?php echo $article->like_count ; ?></span>
                        </button>
                    </form>
                </div>
                <?php
            } else {
                ?>
                <div class="col-sm-10">
                    <span><a href="login.php" name="submit" value="single-page-login">
                        <i class="fas fa-thumbs-up"></i></a></span>
                        
                    <sup style="color:#bf0000;font-weight:900;"><?php echo $article->like_count ; ?></sup> 
                </div>
                <?php
            }
            ?> 
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;"><strong> Post synopsis :</strong> <?php echo $article->description; ?></p>
        
                    <p><?php echo htmlspecialchars_decode($article->body); ?></p>
                    <p><a href="index.php" class="btn btn-sm btn-primary" id="shadow">
                        <i class="fas fa-fast-backward"></i> Home page</a>
                    </p>
                </div>
            </div>
         </div>
        <hr>
        <?php
    }
    ?>
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
                        <img class="img-fluid img-thumbnail w-100" src="../admin/article/<?php echo $post->photo; ?>" alt="Article Photo" style="height:100px;" data-toggle="tooltip" title="<?php echo $post->description; ?>">
                    </a>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <!-- /Posts in the same category -->
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

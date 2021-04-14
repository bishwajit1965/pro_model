<?php
/**
 * Turn on output buffering
 */
ob_start();
/**
 * Detects file name
 */
$path = $_SERVER['SCRIPT_FILENAME'];
if (isset($path)) {
    $current_page = basename($path,'.php');
    if ($current_page = 'index.php') {
        $current_page = 'home';
        ucfirst($current_page);
    }
}
?>
<?php
// Load classes
require_once '../admin/app/start.php';

// Use the classes needed
use CodeCourse\Repositories\Category as Category;
use CodeCourse\Repositories\Core as Core;
use CodeCourse\Repositories\FrontEnd as FrontEnd;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Like as Like;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\Tag as Tag;
use CodeCourse\Repositories\Viewers as Viewers;

// Classes instantiated
$category = new Category();
$core = new Core();
$tag = new Tag();
$frontEnd = new FrontEnd();
$helpers = new Helpers();
$like = new Like();
$viewers = new viewers();
Session::init();

// Tables to be operated upon
$table = 'tbl_articles';
$table_category = 'tbl_category';
$table_tag = 'tbl_tag';
$tableLikes = 'tbl_likes';
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta Data for SEO -->
    <meta name="Tags" content="<?php echo constant("GREETING");?>">
    <meta name="Description" content="<?php echo "Project Model";?>">
     <!-- Meta Data for SEO -->
    <title>Project Model || <?php echo $current_page.' page'; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
        integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap4.min.css">
    <!-- Favicon -->
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon" />
    <!-- Font awesome kit-->
    <script src="https://kit.fontawesome.com/1b551efcfa.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <!-- Custom style sheets -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
    <!-- Top header bar -->
    <?php require_once 'partials/_topHeader.php'; ?>
    <!-- /Top header bar -->

    <!-- Header -->
    <?php require_once 'partials/_header.php'; ?>
    <!-- /Header -->

    <!-- Navbar -->
    <?php require_once 'partials/_navBar.php'; ?>
    <!-- /Navbar -->

    <!-- Main content area -->
    <div class="container-fluid">
        <div class="row">
            <!-- Left side bar -->
            <?php require_once 'partials/_leftSideBar.php'; ?>
            <!-- /Left side bar -->

            <!-- Middle content area -->
            <div class="col-sm-6 main-content" style="overflow:auto;">
                <!-- Marquee tag -->
                <div class="row mt-1">

                    <marquee class="bg-secondary py-2" behavior="scroll" scrollAmount="100" scrollDelay="1600" onMouseOver="this.stop();" onMouseOut="this.start();" direction="lft">

                    <?php
                    $table = 'tbl_articles';
                    $whereCond = [' where ' => ['status' => '1'],
                    'order_by' => 'id DESC', 'limit' => '6'
                    ];
                    $marqueeData = $frontEnd->selectMarqueeData($table, $whereCond);
                    if (!empty($marqueeData)) {
                        $counter = '1';
                        foreach ($marqueeData as $scrollingData) {
                            ?>
                                
                            <a class="text-white bg-dark p-3" href="singlePost.php?post_id=<?php echo $scrollingData->id; ?>contactUs.php"> <i class="fas fa-star"> </i> <?php echo '(' . $counter++ .''.')' . ' ' . $scrollingData->title; ?> <i class="fas fa-star"> </i></a>
                            
                            <?php
                        }
                    }
                    ?>
                    </marquee>
                </div>
                <!--/Marquee tag -->
                <!-- Will display the validation message if any-->
                <div class="row d-block">
                    <?php
                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                </div>
                <!--/ Will display the validation message if any ends-->

                <!-- Slider begins-->
                <div class="row bg-secondary py-2 mt-1"></div>
                <div class="row">
                    <?php require_once 'partials/_slider.php'; ?>
                </div>
                <div class="row bg-secondary py-2"></div>
                <!-- /Slider ends-->

                <?php
                // Fetching data from database to display in index.php page
                $records_per_page = 4;
                $articleData = $frontEnd->paging($table, $records_per_page);
                $articles = $frontEnd->frontEndDataAndPagination($articleData);
                foreach ($articles as $article) {
                    ?>
                <div class="post">
                    <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                        <h1><?php echo  $article->title; ?></h1>
                    </a>
                    <p>
                        <span style="color:#999;font-weight:600;"><strong> Author :</strong>
                            <?php echo $article->author; ?> ||
                        </span>
                        <span style="color:#999;font-weight:600;"><strong> Published on :</strong>
                            <?php echo $helpers->dateFormat($article->published_on); ?></span>
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <span style="color:#999;font-weight:500;"><strong>Category :</strong>
                                <?php
                                $categoryData = $category->select($table_category);
                                if (!empty($categoryData)) {
                                    foreach ($categoryData as $categoryResult) {
                                        if ($categoryResult->category_id == $article->category_id) {
                                            ?>
                                            <a href="#" class="badge badge-secondary">
                                                <?php echo $categoryResult->category_name; ?></a>
                                            <?php
                                        }
                                    }
                                } ?>
                            </span>
                            <span style="color:#999;font-weight:500;"><strong> || Tag :</strong>
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
                                } ?>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <?php
                            // Checks if the viewer is logged in
                            if (Session::checkLogin()) {
                                ?>
                                <!-- Like button -->
                                <div class="col-sm-4 like">
                                    <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                                        <form action="processFrontEnd.php" method="post">
                                            <input type="hidden" name="action" value="verify">
                                            <input type="hidden" name="post_id" value="<?php echo $article->id; ?>">
                                            <input type="hidden" name="like" value="index-page-like">

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
                                <div class="col-sm-5">
                                    <a href="login.php?post_id=<?php echo $article->id; ?>">
                                        <i class="fas fa-thumbs-up"></i>
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
                            } ?>
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
                                        <input type="hidden" name="viewers_id"
                                            value="<?php echo Session::get('id'); ?>">
                                        <input type="hidden" name="email" value="<?php echo $likeValue->email; ?>">
                                        <input type="hidden" name="session" value="<?php echo session_id(); ?>">
                                        <input type="hidden" name="dislike" value="index-page-dislike">

                                        <button type="submit" name="submit" value="delete" style="padding:6px 15px;"
                                            class="fas fa-thumbs-down btn btn-sm btn-primary text-white"
                                            data-toggle="tooltip"
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
                                } ?>
                                <!-- Dislike button ends -->
                            </div>
                        </div>
                    </div>

                    <p
                        style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;">
                        <strong> Post synopsis :</strong> <?php echo $article->description; ?>
                    </p>
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                                <img class="img-fluid img-thumbnail mt- w-100"
                                    src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo"
                                    style="height: 95px;">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 270)); ?>
                        </div>
                    </div>
                    <!-- <p><?php //echo htmlspecialchars_decode($helpers->textShorten($article->body, 320));?>
                    </p> -->
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>"
                                class="btn btn-sm btn-primary read-more-shadow"
                                style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                <i class="fas fa-book-open"></i> Read More</a>
                        </div>
                    </div>
                </div>
                <hr class="type_7">
                <?php
                }
                ?>
                <!-- Pagination begins -->
                <div class="row d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-md pagination-responsive">
                            <?php $frontEnd->pagingLink($table, $records_per_page); ?>
                        </ul>
                    </nav>
                </div>
                <!-- /Pagination ends -->
            </div>
            <!-- /Middle content area -->

            <!-- Right side bar -->
            <?php require_once 'partials/_rightSideBar.php'; ?>
            <!-- /Right side bar -->
        </div>
    </div>
    <!-- /Main content area -->

    <!-- Footer area -->
    <?php require_once 'partials/_footerArea.php'; ?>
    <!-- /Footer area -->

    <!-- Footer bottom bar -->
    <?php require_once 'partials/_footerBottomBar.php'; ?>
    <!-- /Footer bottom bar -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php require_once "partials/_scripts.php"; ?>
</body>

</html>
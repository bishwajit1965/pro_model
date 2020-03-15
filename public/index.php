<?php
ob_start();
// Detects file name
$path = $_SERVER['SCRIPT_FILENAME'];
if (isset($path)) {
    $current_page = basename($path, '.php');
}
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
    <title>Project Model || <?php echo ucfirst($current_page); ?> page</title>
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
        <?php
        // Load classes
        require_once '../admin/app/start.php';

        // Use the classes needed
        use CodeCourse\Repositories\FrontEnd as FrontEnd;
        use CodeCourse\Repositories\Session as Session;
        use CodeCourse\Repositories\Helpers as Helpers;
        use CodeCourse\Repositories\Category as Category;
        use CodeCourse\Repositories\Core as Core;
        use CodeCourse\Repositories\Tag as Tag;
        use CodeCourse\Repositories\Like as Like;
        
        // Classes instantiated
        $category = new Category();
        $core = new Core();
        $tag = new Tag();
        $frontEnd = new FrontEnd();
        $helpers = new Helpers();
        $like = new Like();
        Session::init();

        // Tables to be operated upon
        $table = 'tbl_articles';
        $table_category = 'tbl_category';
        $table_tag = 'tbl_tag';
        $tableLikes = 'tbl_likes';
        ?>
        <div class="row">
            <!-- Left side bar -->
            <?php require_once 'partials/_leftSideBar.php'; ?>
            <!-- /Left side bar -->

            <!-- Middle content area -->
            <div class="col-sm-6 main-content" style="overflow:auto;">
                <!-- Display validation message if any -->
                <div class="row d-block">
                    <?php
                    // Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                </div>
                <!-- /Display validation message if any ends-->

                <!-- Slider -->
                <div class="row bg-secondary py-2 mt-1"></div>
                <div class="row">
                    <?php require_once 'partials/_slider.php'; ?>
                </div>
                <div class="row bg-secondary py-2"></div>
                <!-- /Slider -->

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
                            <?php echo $article->author; ?> || </span>
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
                                }
                                ?>
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
                                }
                                ?>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                            <?php
                            // Checks if the viewer is logged in
                            if (Session::get('login')) {
                                ?>
                                <!-- Like button -->
                                <div class="col-sm-3 like">
                                    <form action="processFrontEnd.php" method="post">
                                        <input type="hidden" name="action" value="verify">
                                        <input type="hidden" name="id" value="<?php echo $article->id;?>">
                                        <input type="hidden" name="like_count"
                                            value="<?php echo $article->like_count + 1;?>">
                                        <input type="hidden" name="user_session"
                                            value="<?php echo $article->user_session;?>">

                                        <button type="submit" name="submit" value="like"
                                            class="fas fa-thumbs-up text-white btn btn-sm btn-primary">   
                                            <span class="badge badge-danger" style="border:1px solid#FFF;"><?php echo $article->like_count ; ?></span>
                                            
                                        </button>
                                    </form>
                                </div>
                                <!-- Dislike button -->
                                <div class="col-sm-3 dislike">
                                    <form action="processFrontEnd.php" method="post">
                                        <input type="hidden" name="action" value="verify">
                                        <input type="hidden" name="id" value="<?php echo $article->id;?>">
                                        <input type="hidden" name="like_count"
                                            value="<?php echo $article->like_count - 1;?>">
                                        <input type="hidden" name="user_session"
                                            value="<?php echo $article->user_session;?>">

                                        <button type="submit" name="submit" value="like"
                                            class="fas fa-thumbs-down btn btn-sm btn-primary text-white">&nbsp;
                                            <span class="badge badge-danger" style="border:1px solid#FFF;"><?php echo $article->like_count ; ?></span>
                                        </button>
                                    </form>
                                </div>
                                <?php
                            } else {
                                ?>
                                <!-- If not logged in this like button will be shown  -->
                                <div class="col-sm-6">
                                    <a href="login.php" name="submit-index" value="index-page-login"><i class="fas fa-thumbs-up"></i></a>
                                    <sup style="color:#bf0000;font-weight:900;"><?php echo $article->like_count ; ?></sup>   
                                </div>
                                <?php
                            }
                            ?>
                            </div>
                        </div> 
                    </div>
                    <!-- <p><img class="img-fluid img-thumbnail mt-4 w-100" src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo" style="height: 250px;"></p> -->

                    <p style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;">
                        <strong> Post synopsis :</strong> <?php echo $article->description; ?>
                    </p>
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                            <img class="img-fluid img-thumbnail mt- w-100" src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo" style="height: 90px;"></a>
                        </div>
                        <div class="col-sm-9">
                            <?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 270)); ?>
                        </div>
                    </div>
                    <!-- <p><?php //echo htmlspecialchars_decode($helpers->textShorten($article->body, 320)); ?></p> -->
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
                <?php
                // $articleId = $article->id;
                $articleId = 54;
                $likeData = $like->countPostLikes($tableLikes, $articleId);
                if (!empty($likeData)) {
                    foreach ($likeData as $value) {
                        echo '<pre>';
                        var_dump($likeData);
                        echo '</pre>';
                        die();
                        // echo $value;
                    }
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
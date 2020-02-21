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
    <title>Project Model || <?= ucfirst($current_page); ?> page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap4.min.css">
    <!-- Favicon -->
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon" />
    <!-- Font awesome kit-->
    <script src="https://kit.fontawesome.com/1b551efcfa.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Allura&display=swap" rel="stylesheet"> -->
    <!-- Custom style sheets -->
    <!-- <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/normalize.css"> -->
    <link rel="stylesheet" href="css/responsive.css" rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        .color {
            color: #FFF;
        }

        .navbar {
            z-index: 999;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }
        .sticky+.main-content {
            padding-top: 60px;
        }

        a {
            color: #000;
        }

        a:hover {
            text-decoration: none;
        }
        .post h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 2.5em;
            line-height: 45px;
            font-weight:800;
            margin-top: 40px;
            text-shadow: 1px 2px 3px #333;
            color: #222;
        }
    </style>
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

        // Classes instantiated
        $category = new Category();
        $core = new Core();
        $tag = new Tag();
        $frontEnd = new FrontEnd();
        $helpers = new Helpers();
        Session::init();

        // Tables to be operated upon
        $table = 'tbl_articles';
        $table_category = 'tbl_category';
        $table_tag = 'tbl_tag';
        ?>
        <div class="row">
            <!-- Left side bar -->
            <?php require_once 'partials/_leftSideBar.php'; ?>
            <!-- /Left side bar -->

            <!-- Middle contant area -->
            <div class="col-sm-6 main-content" style="overflow:auto;">
                <!-- Display validation message if any -->
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
                        <!-- <p><img class="img-fluid img-thumbnail" src="../admin/article/<?php echo $article->photo; ?>" alt="Article Photo"></p> -->

                        <p style="color:#666;font-weight:600;margin-top:30px;background-color:#D4EDDA;border-left:5px solid#4CAF50;padding:10px;"><strong> Post synopsis :</strong> <?php echo $article->description; ?></p>
                        <p><?php echo htmlspecialchars_decode($helpers->textShorten($article->body, 320)); ?></p>
                        <p>
                            <a href="singlePost.php?post_id=<?php echo $article->id; ?>" class="btn btn-sm btn-primary" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><i class="fas fa-book-open"></i> Read More</a>
                        </p>
                    </div>
                    <?php
                }
                ?>
                <!-- Pagination begins -->
                <div class="row d-flex justify-content-center">
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                            <?php $frontEnd->pagingLink($table, $records_per_page); ?>
                        </ul>
                    </nav>
                </div>
                <!-- /Pagination ends -->
            </div>
            <!-- /Middle contant area -->

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
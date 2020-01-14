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
    <link href="https://fonts.googleapis.com/css?family=Allura&display=swap" rel="stylesheet">
    <!-- Custom style sheets -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/responsive.css" rel="stylesheet" href="css/responsive.css">
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
    </style>
</head>


<body>
    <div class="container-fluid bg-dark text-white py-2">
        <div class="row">
            <div class="col-sm-3">BBC</div>
            <div class="col-sm-3">BBC</div>
            <div class="col-sm-3">BBC</div>
            <div class="col-sm-3">BBC</div>
        </div>
    </div>

    <div class="container-fluid bg-info text-white header-area py-2">
        <div class="header">
            <p>
                rem ipsum dolor sit amet, consectetur adipisicing elit. Earum praesentium quidem quae cum dolorem
                modiratione nulla similique accusamus voluptatum! Officia, eos reiciendis ea quam facere aut
                fuga error odio expedita ab? Repellendus, iste ad! Porro iure dolorem voluptates ut, facilis, eos
                sunt libero est esse eaque harum, culpa aliquam minus quis dignissimos enim molestiae? Culpa itaque
                im fuga impedit ratione ex tempora rerum nobis nisi ab omnis, nulla doloremque vero, ullam harum
                ea rum neque architecto aperiam ipsum praesentium quidem iste delectus cumque! Placeat,
                nentre magnam reiciendis perferendis nulla nobis dolores maxime aliquam repellendus, quisquam
                nimi voluptas obcaecati aperiam sed pariatur velit architecto vero explicabo neque tenetur ea, quia
                lorum ratione nihil! Necessitatibus dolorem molestiae, ut, iste beatae facere, at laborum maxime
                iussunt temporibus ad id voluptas quidem molestias. Sapiente eaque expedita impedit maiores minima
                luate debitis dolor culpa doloribus id quidem rerum incidunt eum est obcaecati veritatis quo
                spiiatis, quod eius reprehenderit? Pariatur architecto maxime magni ut dolores accusamus
                peferendis deleniti accusantium iste quam sequi, ipsum quasi in quis iusto aspernatur est,
                voluptatem soluta quas! Aliquid voluptate nulla iste nam impedit aliquam veniam nihil atque rem
                uaerat eligendi consequuntur ducimus, fugit odit tenetur quis, id commodi quidem?
            </p>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
        <a class="navbar-brand" href="#">Navba </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" <?php if ($current_page == 'index') {
                                            echo 'id="active"';
                                        } ?> href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" <?php if ($current_page == 'aboutUs') {
                                            echo 'id="active"';
                                        } ?> href="pages/aboutUs.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" <?php if ($current_page == 'contactUs') {
                                            echo 'id="active"';
                                        } ?> href="pages/contactUs.php">Contact Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 left-sidebar">
                <ul>
                    <li><a href="">One</a></li>
                    <li><a href="">One</a></li>
                </ul>
            </div>
            <div class="col-sm-6 main-content" style="overflow:auto;">
                <?php
                // Load classes
                require_once '../admin/app/start.php';

                // Use the classes needed
                use CodeCourse\Repositories\FrontEnd as FrontEnd;
                use CodeCourse\Repositories\Session as Session;
                use CodeCourse\Repositories\Helpers as Helpers;

                $frontEnd = new FrontEnd();
                $helpers = new Helpers();
                Session::init();

                // Table to be operated upon
                $table = 'tbl_articles';
                $records_per_page = 2;
                $articleData = $frontEnd->paging($table, $records_per_page);
                $articles = $frontEnd->frontEndDataAndPagination($articleData);
                foreach ($articles as $article) {
                ?>
                    <div class="post">
                        <h1><?= $article->title; ?></h1>
                        <img src="../admin/article/<?= $article->photo; ?>" alt="Article Photo">
                        <h4> <?= $article->description; ?></h4>
                        <p><?= htmlspecialchars_decode($helpers->textShorten($article->body, 320)); ?></p>
                        <p>
                            <a href="pages/singlePost.php?id=<?= $article->id; ?>" class="btn btn-sm btn-primary"><i class="fas fa-book-open"></i> Read More</a>
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
            <div class="col-sm-3 right-sidebar py-1">
                <div class="social-site-heading bg-secondary p-1 text-white">
                    <h4>Social site links</h4>
                </div>
                <div class="social-links d-flex flex-row justify-content-between bg-dark p-1"></a>
                    <a href="https://www.facebook.com" target="blank"> <i class="fab fa-facebook"></i> </a>
                    <a href="https://www.twitter.com" target="blank"> <i class="fab fa-twitter"></i> </a>
                    <a href="https://www.linkidin.com" target="blank"> <i class="fab fa-linkedin"></i> </a>
                    <a href="https://www.github.com" target="blank"> <i class="fab fa-github"></i> </a>
                    <a href="https://www.youtube.com" target="blank"> <i class="fab fa-youtube"></i> </a>
                </div>
                <div class="pagelinks mt-4">
                    <div class="social-site-heading bg-secondary p-1 text-white">
                        <h4>Social site links</h4>
                    </div>
                    <form action="pages/processFrontEnd.php" method="post">
                        <div class="btn-group d-flex flex-row justify-content-between" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary" name="submit" value="category" style="width:33.3%;">Category</button>
                            <button type="submit" class="btn btn-success" name="submit" value="tag" style="width:33.3%;">Tags</button>
                            <button type="submit" class="btn btn-info" name="submit" value="archive" style="width:33.3%;">Archive</button>
                            <input type="hidden" name="action" value="verify">
                        </div>
                    </form>
                    <?php
                    // Will display all the messages vlidation/insert/update/delete
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid footer-area bg-dark text-white py-2">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, itaque. Quasi necessitatibus
            numquam igenlaborum minus. Nam omnis, voluptates voluptatibus recusandae praesentium sed deserunt quae
            enim
            quisquam eldi ipsam. Neque veniam ex hic sit fugiat omnis culpa eum vero blanditiis sunt! Vel pariatur
        </p>
    </div>
    <div class="container-fluid footer-bottom-bar py-2 text-white text-center" style="background-color:#000;">
        &copy;<?php echo date('Y'); ?> All rights reserved to Model Project
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php include_once 'pages/partials/_scripts.php'; ?>
</body>

</html>

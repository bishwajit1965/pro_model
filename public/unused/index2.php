<?php include_once 'partials/_head.php'; ?>
<div class="container-fluid bg-white">
    <?php include_once 'partials/_topHeader.php'; ?>
    <?php include_once 'partials/_header.php'; ?>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <a class="navbar-brand" href="#">Navbar w/ text</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
        </ul>
        <span class="navbar-text">
            Navbar text with an inline element
        </span>
    </div>
</nav>
<div class="row">
    <?php include_once 'partials/_leftSidebar.php'; ?>
    <div class="col-sm-7 main-content py-2">
        <!-- Add code below for middle content area-->
        <h1>Middle</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia vitae officiis recusandae quod laudantium
            doloremque aut repudiandae aliquid totam unde deserunt magni rerum vel, sapiente facilis rem expedita est
            reiciendis.</p>
        <?php
        // Load classes
        require_once '../admin/app/start.php';

        // Use the classes needed
        use Codecourse\Repositories\FrontEnd as FrontEnd;

        $frontEnd = new FrontEnd();
        // Table to be operated upon
        $table = 'tbl_articles';

        $records_per_page = 2;
        $articleData = $frontEnd->paging($table, $records_per_page);
        $articles = $frontEnd->frontEndDataAndPagination($articleData);
        foreach ($articles as $article) {
            echo $article->title . '<br>';
            echo $article->description . '<br>';
            echo htmlspecialchars_decode($article->body) . '<br>';
        }
        ?>
        <!-- Pagination begins -->
        <div class="row d-flex justify-content-center">
            <nav aria-label="Page navigation example ">
                <ul class="pagination">
                    <?php $frontEnd->paginglink($table, $records_per_page); ?>
                </ul>
            </nav>
        </div>
        <!-- /Pagination eends -->

        <!-- /Add code above for middle content area-->
    </div>
    <?php include_once 'partials/_rightSidebar.php'; ?>
</div>
<?php include_once 'partials/_footer.php'; ?>
<?php include_once 'partials/_footerBottom.php'; ?>
</div>
<?php include_once 'partials/_scripts.php'; ?>

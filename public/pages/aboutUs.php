<!-- Head area -->
<?php include_once 'partials/_head.php'; ?>
<!-- /Head area -->

<!-- Top header area -->
<?php include_once 'partials/_topHeader.php'; ?>
<!-- /Top header area -->

<!-- Header area -->
<?php include_once 'partials/_header.php'; ?>
<!-- /Header area -->

<!-- Nab bar area -->
<?php include_once 'partials/_navBar.php'; ?>
<!-- /Nab bar area -->

<!-- Middle content area -->
<div class="container-fluid">
    <div class="row">
        <?php include_once 'partials/_leftSideBar.php'; ?>
        <div class="col-sm-6 main-content" style="overflow:auto;">
            <h1>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt rem possimus expedita enim
                rerum soluta nesciunt blanditiis distinctio quasi mollitia sequi, beatae veritatis corporis
                deleniti, adipisci iusto reprehenderit voluptatem officia odit sed quis pariatur exercitationem
                provident. Quod ad dolore iste dolorum delectus impedit nulla minus assumenda natus, numquam
                reiciendis fugiat esse, unde ea quasi, cum est cupiditate iusto aut libero. Id officiis
                consequuntur obcaecati necessitatibus tempore debitis sapiente ipsa a odit nostrum temporibus,
                error dolor, voluptates itaque enim nobis velit eaque perspiciatis quasi cupiditate explicabo
                facere culpa? Delectus recusandae, culpa facere nesciunt voluptates voluptas neque corporis
                voluptate tenetur praesentium, quidem a voluptatem optio ratione harum quia quisquam, rem
                molestias ea vero aperiam veniam repellat ad! Nostrum minima sint in. Quisquam, incidunt aliquam
                voluptatum, culpa voluptates quia expedita nostrum commodi nulla eaque quae adipisci
                consequuntur, voluptatem atque quidem. Aspernatur est dicta quis nam. Atque saepe facilis
                voluptatem omnis explicabo, fugit ut architecto ab in, deleniti eius natus neque vero officiis
                ipsam repellendus praesentium provident amet error! Deleniti esse aliquam consequatur nam ab sed
                itaque incidunt et neque id atque accusamus ad autem nulla recusandae odio enim mollitia, iure
                dolorum error natus in rem facere? Cupiditate similique, velit voluptatibus nisi cumque
                obcaecati?
            </p>

            <?php
            // Load classes
            require_once '../../admin/app/start.php';

            // Use the classes needed
            use CodeCourse\Repositories\FrontEnd as FrontEnd;

            $frontEnd = new FrontEnd();
            // Table to be operated upon
            $table = 'tbl_articles';

            $records_per_page = 2;
            $articleData = $frontEnd->paging($table, $records_per_page);
            $articles = $frontEnd->frontEndDataAndPagination($articleData);
            foreach ($articles as $article) {
            ?>
                <h1><?= $article->title; ?></h1>
                <h4> <?= $article->description; ?></h4>
                <p><?= htmlspecialchars_decode($article->body); ?></p>
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
            <!-- /Pagination eends -->
        </div>
        <!-- Right side bar -->
        <?php include_once 'partials/_rightSideBar.php'; ?>
        <!-- /Right side bar -->
    </div>
</div>
<!-- /Middle content area -->

<!-- Footer area -->
<?php include_once 'partials/_footerArea.php'; ?>
<!-- /Footer area -->

<!-- Footer bottom bar area -->
<?php include_once 'partials/_footerBottomBar.php'; ?>
<!-- Footer bottom bar area -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php include_once 'partials/_scripts2.php'; ?>
<!-- /jQuery first, then Popper.js, then Bootstrap JS -->

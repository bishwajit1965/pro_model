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
    <div class="pagelinks mt-2">
        <div class="social-site-heading bg-secondary p-1 text-white">
            <h4>Social site links</h4>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="btn-group d-flex flex-row justify-content-between" role="group" aria-label="Basic example">
                <button type="submit" class="btn btn-primary" name="submit" value="category" style="width:33.3%;">Category</button>
                <button type="submit" class="btn btn-success" name="submit" value="tag" style="width:33.3%;">Tags</button>
                <button type="submit type=" submit" class="btn btn-info" name="submit" value="archive" style="width:33.3%;">Archive</button>
                <input type="hidden" name="action" value="verify">
            </div>
        </form>
        <style>
            .category-link>ul {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .category-link>ul>li {
                background-color: #DDD;
                border-bottom: 1px solid#999;
                border-top: 1px solid#FFF;
            }

            .category-link>ul>li>a {
                padding: 8px;
                display: block;
                font-weight: 600;
            }

            .category-link>ul>li:last-child {
                border-bottom: 0px solid#FFF;
            }

            .category-link>ul>li>a:hover {
                background-color: #EDEFF0;
                color: #000;
                font-weight: 800;
                padding-left: 20px;
            }
        </style>
        <?php
        require_once '../admin/app/start.php';

        // Class included
        use CodeCourse\Repositories\Category as Category;
        use CodeCourse\Repositories\Core as Core;
        use CodeCourse\Repositories\Session as Session;
        use CodeCourse\Repositories\Tag as Tag;
        use CodeCourse\Repositories\Helpers as Helpers;

        // Classes instantiated
        $category = new Category();
        $core = new Core();
        $helpers = new Helpers();
        $tag = new Tag();
        Session::init();

        // Table to be operated on
        $table = 'tbl_articles';
        $tableCategory = 'tbl_category';
        $tableTag = 'tbl_tag';

        // Will display all the messages validation/insert/update/delete
        $message = Session::get('message');
        if (!empty($message)) {
            echo $message;
            Session::set('message', null);
        }

        if (isset($_POST['submit'])) {
            $accessor = $_POST['submit'];
            switch ($accessor) {
                case 'category':
                    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
                        if ($_REQUEST['action'] == 'verify') {
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $categoryData = $category->select($tableCategory);
                                    if (!empty($categoryData)) {
                                        foreach ($categoryData as $category) {
                                        ?>
                                            <div class="category-link">
                                                <ul>
                                                    <li>
                                                        <a href="categoryWisePosts.php?category_id=<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'tag':
                    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
                        if ($_REQUEST['action'] == 'verify') {
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $tagData = $tag->select($tableTag);
                                    if (!empty($tagData)) {
                                        foreach ($tagData as $tag) {
                                        ?>
                                            <div class="category-link">
                                                <ul>
                                                    <li>
                                                        <a href="tagWisePosts.php?tag_id=<?php echo $tag->tag_id; ?>"><?php echo $tag->tag_name; ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'archive':
                    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
                        if ($_REQUEST['action'] == 'verify') {
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                }
                            }
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        ?>
    </div>
    <div class="pagelinks mt-2">
        <div class="social-site-heading bg-secondary p-1 text-white">
            <h4>Recent posts</h4>
        </div>      
        <div class="row">
            <?php
            $limit = ['limit' => '5'];
            $recentPosts = $core->select($table, $limit);
            if (!empty($recentPosts)) {
                foreach ($recentPosts as $post) {
                    ?>
                    <div class="col-sm-12">
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>"><h4><?php echo $post->title; ?></h4></a>
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>"><img class="img-fluid img-thumbnail w-100" src="../admin/article/<?php echo $post->photo; ?>" alt="Post photo"></a>
                        <p><?php echo $helpers->textShorten(htmlspecialchars_decode($post->body), 175); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>
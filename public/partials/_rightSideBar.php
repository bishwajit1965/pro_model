<div class="col-sm-3 right-sidebar py-1">
    <div class="social-site-heading bg-secondary p-1 text-white">
        <h4>Social site links</h4>
    </div>
    <div class="social-links d-flex flex-row justify-content-between bg-dark p-1">
        <?php
        require_once '../admin/app/start.php';

        // Class included
        use CodeCourse\Repositories\Category as Category;
        use CodeCourse\Repositories\Core as Core;
        use CodeCourse\Repositories\Session as Session;
        use CodeCourse\Repositories\SocialMedia as SocialMedia;
        use CodeCourse\Repositories\Tag as Tag;
        use CodeCourse\Repositories\Helpers as Helpers;

        // Classes instantiated
        $category = new Category();
        $core = new Core();
        $helpers = new Helpers();
        $socialMedia = new SocialMedia();
        $tag = new Tag();
        Session::init();

        // Table to be operated on
        $table = 'tbl_articles';
        $tableCategory = 'tbl_category';
        $tableSocialMedia = 'tbl_social_media';
        $tableTag = 'tbl_tag';
        $limit = ['limit' => '7'];

        // Will fetch social media data
        $socialMediaData = $socialMedia->select($tableSocialMedia, $limit);
        if (!empty($socialMediaData)) {
            foreach ($socialMediaData as $socialMedia) {
                ?>
                <a href="<?php echo $socialMedia->name; ?>" target="blank">
                <?php
                if ($socialMedia->name == 'https://www.facebook.com') {
                    echo '<i class="fab fa-facebook text-white"></i>';
                } elseif ($socialMedia->name == 'https://www.twitter.com') {
                    echo '<i class="fab fa-twitter text-white"></i>';
                } elseif ($socialMedia->name == 'https://www.linkedin.com') {
                    echo '<i class="fab fa-linkedin text-white"></i>';
                } elseif ($socialMedia->name == 'https://www.youtube.com') {
                    echo '<i class="fab fa-youtube text-white"></i>';
                } elseif ($socialMedia->name == 'https://www.stackoverflow.com') {
                    echo '<i class="fab fa-stack-overflow text-white"></i>';
                } elseif ($socialMedia->name == 'https://www.github.com') {
                    echo '<i class="fab fa-github text-white"></i>';
                } else {
                }
                ?>
                </a>
                <?php
            }
        } 
        ?>
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
                                ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                      <label for="archive">Archive</label>
                                      <select class="form-control" name="archive" id="archive">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                      </select>
                                    </div>
                                    <button type="submit" name="submit" value="" class="btn btn-sm btn-primary"> Get Data</button>
                                </form>
                                <?php
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
            $limit = ['limit' => '4'];
            $recentPosts = $core->select($table, $limit);
            if (!empty($recentPosts)) {
                foreach ($recentPosts as $post) {
                    ?>
                    <div class="col-sm-12">
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>"><h5><?php echo $post->title; ?></h5></a>
                        <a href="singlePost.php?post_id=<?php echo $article->id; ?>">
                            <img class="img-fluid img-thumbnail w-100" src="../admin/article/<?php echo $post->photo; ?>" alt="Post photo">
                        </a>
                        <p><?php echo $helpers->textShorten(htmlspecialchars_decode($post->body), 150); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
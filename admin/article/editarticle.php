<?php include_once('../partials/_head.php'); ?>
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once('../partials/_header.php'); ?>
<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<?php include_once '../partials/_leftSidebar.php'; ?>
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Edit Article
    <small>it all starts here</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Blank page</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <!-- <h3 class="box-title">Add category</h3> -->
            <a href="articleIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Article Index</a>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <!-- Code below -->
                <?php
                // Will load vendor autoloader
                require_once('../app/start.php');

                use Codecourse\Repositories\Session as Session;
                use Codecourse\Repositories\Article as Article;
                use Codecourse\Repositories\Category as Category;
                use Codecourse\Repositories\Tag as Tag;

                // Instantiate Category
                $article = new Article;
                $category = new Category;
                $tag = new Tag;

                // Will display validation message if any
                Session::init();
                $message = Session::get('message');
                if (!empty($message)) {
                    echo $message;
                    Session::set('message', null);
                }
                ?>
                <?php
                $id = $_GET['edit_id'];
                $table = 'tbl_articles';
                $tableTag = 'tbl_tag';
                $whereCond = [
                'where' => ['article_id' => $id],
                'return_type' => 'single',
                ];
                $getArticleData = $article->select($table, $whereCond);
                if (!empty($getArticleData)) { ?>
                <form action="processArticle.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="<?=$getArticleData->title;?>" placeholder="Insert title">
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="author" class="form-control" value="<?=$getArticleData->author;?>" placeholder="Insert author">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php
                                    $table = 'tbl_category';
                                    $order_by = ['order_by' => 'category_id DESC'];
                                    $categoryData = $category->select($table, $order_by);
                                    if (!empty($categoryData)) {
                                        foreach ($categoryData as $category) { ?>
                                        <option
                                            <?php if ($category->category_id == $getArticleData->category_id) : ?>
                                                selected = "selected"
                                            <?php endif ?> value="<?= $category->category_id;?>"><?= $category->category_name;?>
                                        </option>
                                        <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Tag</label>
                                <select name="tag_id" class="form-control">
                                    <option value="">Select Tag</option>
                                    <?php
                                     $order_by = ['order_by' => 'tag_id DESC'];
                                    /*
                                    $selectCond = ['select' => 'name'];
                                    $whereCond = [
                                    'where' => ['id' => '1', 'email' => 'bishwajit@gmail.com'],
                                    'return_type' => 'single'
                                    ];
                                    $limit = ['start' => '2', 'limit' =>'4'];
                                    $limit = ['limit' => '4'];
                                    There is problem in $whereCond
                                    $whereCond = [
                                    'where' => ['id' => '2', 'email' => 'bishwajit@gmail.com'],
                                    'return_type' => 'single'
                                    ];
                                    */
                                    $tagData = $tag->select($tableTag, $order_by);
                                    if (!empty($tagData)) {
                                        $i = 1;
                                        foreach ($tagData as $tag) { ?>
                                            <option
                                                <?php if ($tag->tag_id == $getArticleData->tag_id) : ?>
                                                     selected = "selected"
                                                <?php endif ?>
                                            value="<?= $tag->tag_id;?>"><?= $tag->tag_name;?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="form-group" >
                                <label for="status" >Post Status</label>
                                <div class="selection">
                                    <select name="status" class="form-control">
                                        <?php
                                        if ($getArticleData->status == '0') { ?>
                                            <option value="0">Publish</option>
                                            <option value="1">Coming soon</option>
                                            <option value="2">Draft</option>
                                            <?php
                                        } elseif ($getArticleData->status == '1') { ?>
                                            <option value="1">Coming soon</option>
                                            <option value="0">Publish</option>
                                            <option value="2">Draft</option>
                                            <?php
                                        } elseif ($getArticleData->status == '2') { ?>
                                            <option value="2">Draft</option>
                                            <option value="0">Publish</option>
                                            <option value="1">Coming soon</option>
                                            <?php
                                        } else {
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Will publish on</label>
                                <input type="datetime-local" name="published_on" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="hidden" name="user_session" value="<?= $user_session;?>">
                            </div>

                            <div class="form-group">
                                <?php
                                if (!empty($getArticleData->photo)) { ?>
                                    <img src="<?=$getArticleData->photo;?>" style="width:100%;" class="img img-responsive img-thumbnail" alt="Article photo">
                                <?php } else { ?>
                                <img src="../images/avatar/avatar.jpg" style="width:100%;" class="img img-responsive img-thumbnail" alt="">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea id="editor1" name="body" rows="10" cols="80">
                            <?= htmlspecialchars_decode($getArticleData->body);?>
                        </textarea>
                    </div>
                        <input type="hidden" name="action" value="verify">
                        <input type="hidden" name="article_id" value="<?= $getArticleData->article_id; ?>">
                        <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Edit Article</button>
                </form>
                <?php } ?>
            <!-- Code above -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">Footer</div>
    <!-- /.box-footer-->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once('../partials/_footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php include_once('../partials/_scripts.php'); ?>
</body>
</html>

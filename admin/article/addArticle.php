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
                Add article
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
                    <a href="articleIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Article
                        Index</a>
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
                    use Codecourse\Repositories\Category as Category;
                    use Codecourse\Repositories\Tag as Tag;

                    // Instantiate classes
                    $category = new Category;
                    $tag = new Tag;

                    // Tables will be dealt with
                    $tableCategory = 'tbl_category';
                    $tableTag = 'tbl_tag';

                    // User epecific session
                    $user_session = session_id();

                    // Will display validation message if any
                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                    <form action="processArticle.php" method="post" enctype="multipart/form-data"
                        accept-charset="utf-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Post Title</label>
                                    <input type="text" name="title" class="form-control" value=""
                                        placeholder="Insert title">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Post short description</label>
                                    <input type="text" name="description" class="form-control" value=""
                                        placeholder="Insert description">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="author">Post Author</label>
                                    <input type="text" name="author" class="form-control" value=""
                                        placeholder="Insert author">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        <?php
                                        $order_by = ['order_by' => 'category_id DESC'];
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
                                        $categoryData = $category->select($tableCategory, $order_by);
                                        if (!empty($categoryData)) {
                                            $i = 1;
                                            foreach ($categoryData as $category) { ?>
                                        <option value="<?= $category->category_id; ?>"><?= $category->category_name; ?>
                                        </option>
                                        <?php }
                                        } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="title">Post Tag</label>
                                    <select name="tag_id" class="form-control">
                                        <option value="">Select Tag</option>}
                                        option
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
                                        <option value="<?= $tag->tag_id; ?>"><?= $tag->tag_name; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Status</label>
                                    <select name="status" class="form-control">
                                        <option>Select post status</option>
                                        <option value="0">Publish</option>
                                        <option value="1">Coming soon</option>
                                        <option value="2">Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="title">Post Photo</label>
                                    <input type="file" name="photo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Will publish on</label>
                                    <input type="datetime-local" name="published_on" class="form-control" value="">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" value="" placeholder="Category name">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" value="" placeholder="Category name">
                                </div> -->
                                <input type="hidden" name="user_session" value="<?= $user_session; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Post content</label>
                            <textarea id="editor1" name="body" rows="5" cols=""></textarea>
                        </div>
                        <input type="hidden" name="action" value="verify">
                        <button type="submit" name="submit" value="insert" class="btn btn-sm btn-primary"><i
                                class="fa fa-upload"></i> Add article</button>
                    </form>
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

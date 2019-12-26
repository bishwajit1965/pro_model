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
            use Codecourse\Repositories\Category as Category;
            use Codecourse\Repositories\Tag as Tag;

            // Instantiate classes
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
            <form action="processArticle.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="" placeholder="Insert title">
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" class="form-control" value="" placeholder="Insert author">
                        </div>
                        <div class="form-group">
                            <label for="title">Category</label>
                            <select name="category_name" class="form-control">
                                <option value="">One</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="title">Tag</label>
                            <select name="tag_name" class="form-control">
                                <option value="">One</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Status</label>
                            <select name="status" class="form-control">
                                <option value="">Select post status</option>
                                <option value="0">Publish</option>
                                <option value="1">Coming soon</option>
                                <option value="2">Unpublish</option>
                                <option value="3">Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="title">Publish on</label>
                            <input type="datetime-local" name="published_on" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="" placeholder="Category name">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="" placeholder="Category name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea id="editor1" name="body" rows="10" cols="80"></textarea>
                </div>
                <input type="hidden" name="action" value="verify">
                <button type="submit" name="submit" value="insert" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Add article</button>
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

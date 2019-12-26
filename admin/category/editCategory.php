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
    Edit Category
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
            <a href="categoryIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Category Index</a>
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
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                // Will load vendor autoloader
                require_once('../app/start.php');

                use Codecourse\Repositories\Session as Session;
                use Codecourse\Repositories\Category as Category;

                // Will display validation message if any
                $category = new Category;
                Session::init();
                $message = Session::get('message');
                if (!empty($message)) {
                    echo $message;
                    Session::set('message', null);
                }
                ?>
                <?php
                $id = $_GET['edit_id'];
                $table = 'tbl_category';
                $whereCond = [
                'where' => ['category_id' => $id],
                'return_type' => 'single',
                ];
                $getCategoryData = $category->select($table, $whereCond);
                if (!empty($getCategoryData)) { ?>
                <form action="processCategory.php" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="category_name">Category</label>
                        <input type="text" name="category_name" class="form-control" value="<?=$getCategoryData->category_name;?>" placeholder="Category name">
                    </div>
                    <input type="hidden" name="action" value="verify">
                    <input type="hidden" name="category_id" value="<?= $getCategoryData->category_id; ?>">
                    <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Edit Category</button>
                </form>
                <?php } ?>
            </div>
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
